<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Story;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Content;
use App\Models\Religion;
use App\Models\Genre;
use App\Models\Character;
use App\Models\Draft;
use App\Models\Chapter;
use App\Models\Note;
use App\Models\Content_to_Content;

class ConnectionController extends Controller
{
    public static $projId = -1;

    /**
     * Eltárolja a tömb tartalmát a megadott Model adatbázistáblájában.
     *
     * @param  Model:class  $model
     * @param  array  $inputArray
     */
    public static function _store($model, $inputArray){
        $object = new $model;

        foreach ($inputArray as $key => $value) {
            $object->$key = $value;
        }

        $object->save();
    }

    /**
     * Eltárol egy objektumelemet úgy, hogy automatikusan létrehozza a hozzá tartozó content elemet is.
     *
     * @param int $projId
     * @param  Model:class  $model
     * @param  array  $inputArray
     */
    public static function _storeToContent($projId, $model, $inputArray){

        $c_input=["project_id" => $projId, "type" => Content::getType($model)];
        self::_store(Content::class, $c_input);
        $cId = DB::getPdo()->lastInsertId();
        $inputArray["content_id"] = $cId;

        self::_store($model, $inputArray);
    }

    /**
     * A ConnectionToConnection tábla tartalmát frissíti az inCollection lista alapján.
     *
     * @param Model:class  $model
     * @param int $id
     * @param Model:class  $collectionModel
     * @param bool $reverseSearch
     */
    public static function _updateConnection($model, $id, $inCollection, $collectionModel = Story::class, $reverseSearch = true){
        $inStories_legacy = [];
        $chContentId = self::_get($model, ["id" => $id], true, ["content"])->content->id;
        $storyContent = self::_getRelatedContent($model, $id, Content::getType($collectionModel), $reverseSearch, true);
        foreach ($storyContent as $key => $value) {
            array_push($inStories_legacy, $value->id);
        }
        $inCollectionValues = $inCollection;
        for ($i=0; $i < count($inCollection); $i++) { 
            $inCollection[$i] = self::_get($collectionModel, ["id" => $inCollection[$i]], true, onlyColumns:['content_id'])->content_id;
        }
        for ($i=0; $i < count($inCollection); $i++) {
            //Az adott történethez kapcsolódó viszony nem változott
            if(in_array($inCollection[$i], $inStories_legacy)){
                unset($inStories_legacy[array_search($inCollection[$i], $inStories_legacy)]);
            }
            //Az adott történet újonnan került összekötésre az elemmel
            else{
                if($reverseSearch == false){
                    self::_store(Content_to_Content::class, [
                        "first_id" => $chContentId, 
                        "second_id" => self::_get($collectionModel, ["id" => $inCollectionValues[$i]], true, ["content"])->content->id
                    ]);
                }
                else{
                    self::_store(Content_to_Content::class, [
                        "first_id" => self::_get($collectionModel, ["id" => $inCollectionValues[$i]], true, ["content"])->content->id, 
                        "second_id" => $chContentId
                    ]);
                }
                
            }
        }
        //Ezek az elemek szerepelnek az adatbázisban, de nem voltak kipipálva. törölni kell őket!
        if(count($inStories_legacy) > 0){
                foreach ($inStories_legacy as $key => $value) {
                    $stContentId = $value;
                    $item = new Collection;
                    if($reverseSearch == false){
                        $item = self::_get(Content_to_Content::class, ["first_id" => $chContentId, "second_id" => $stContentId], true);
                    }
                    else{
                        $item = self::_get(Content_to_Content::class, ["first_id" => $stContentId, "second_id" => $chContentId], true);
                    }
                    self::_destroy(Content_to_Content::class, ["id" => $item->id]);
                }
        }
    }

    /**
     * Lekéri az adott Model táblájának elemeit a megadott paraméterlista alapján.
     *
     * @param Model:class $model
     * @param array $parameterArray
     * @param bool $one
     * @param array $withrelations
     * @param array $onlyColumns
     * @param string $orderBy
     * @param string $sort
     * @param int $limit
     * @return Collection $data
     */
    public static function _get($model, $parameterArray = null, $one = false, 
    $withrelations = [], $onlyColumns = ['*'], $orderBy = null, $sort = 'asc', 
    $limit = null, $multiParamArray = []){
        $raw = $model::where($parameterArray);
        if($multiParamArray != []){
            $raw = $raw->whereIn($multiParamArray[0], $multiParamArray[1]);
        }

        $raw = $raw->with($withrelations);
        if ($one) {
            $raw = $raw->first($onlyColumns);
            $data = new Collection();
            if($raw == null){
                return null;
            }
            foreach ($raw->getAttributes() as $key => $value) {
                $data->$key = $value;
            }
            if($raw->getRelations() != []){
                foreach ($raw->getRelations() as $key => $value) {
                    $data->$key = parent::ClearModelCollection($value);
                }
            }
            return $data;
        }
        else {
            $raw = $raw->limit($limit);
            if($orderBy != null){
                $raw = $raw->orderBy($orderBy, $sort);
            }
            $raw = $raw->get($onlyColumns);
            $data = new Collection();
            foreach ($raw as $key => $value) {
                $item = new Collection();
                $itemraw = $value->getAttributes();
                foreach ($itemraw as $itemkey => $itemvalue) {
                $item->$itemkey = $itemvalue;
                }
                $itemraw = $value->getRelations();
                foreach ($itemraw as $itemkey => $itemvalue) {
                $item->$itemkey = $itemvalue;
                }
            $data[$key] = $item;
            }
            return $data;
        }
        
    }

    /**
     * Lekéri az adott Model táblájának elemeit a megadott paraméterlista alapján, véletlenszerű sorrendben.
     *
     * @param Model:class $model
     * @param array $parameterArray
     * @param array $withrelations
     * @param array $onlyColumns
     * @param int $limit
     * @param array $whereRelations
     * @return Collection $data
     */
    public static function _getInRandomOrder($model, $parameterArray = null, $withrelations = [], $onlyColumns = ['*'], $limit = null, $whereRelation = []){
        $raw = $model::inRandomOrder()->where($parameterArray);
        if(count($whereRelation) == 4){
            $raw = $raw->whereRelation($whereRelation[0], $whereRelation[1], $whereRelation[2], $whereRelation[3]);
        }
        $raw = $raw->with($withrelations)->limit($limit)->get($onlyColumns);
        return $raw;
        
    }

    /**
     * Lekéri az objektum id-je alapján a hozzá kapcsolódó többi objektumot, amiknek a típusa megegyezik a megadottal. Ha csak a contentet kérjük le, az elemek indexe a belső tartalom id-je lesz.
     *
     * @param Model:class $model
     * @param int $id
     * @param string $searchType
     * @param bool $reverse
     * @param bool $onlyContent
     * @return array $data
     */
    public static function _getRelatedContent($model, $id, $searchType, $reverse=false, $onlyContent = false, $orderBy = null, $sort = 'asc', $onlyColumns = []){
        //lekéri a Content id-je alapján a Character elemeket
        $direction = "related";
        $array=[];
        if($reverse == true){
            $direction = "related_reverse";
        }
        $array = $model::find($id)->content->whereRelation("content", ["id" => $id])
            ->with($direction)->get()[0]
            ->getRelations()[$direction];
        $data = [];
        if($onlyContent == true){
            for ($i=0; $i < count($array); $i++) { 
                if($searchType == "_ALL_" || $array[$i]->type == $searchType){
                    $item = new Content();
                    $item->id = $array[$i]->id;
                    $item->item_type = $array[$i]->type;
                    $item->project_id = $array[$i]->project_id;

                    $data[$i] = $item;
                }
            }
            
        }
        else{
            $IDs = [];
            $types = [];
            for ($i=0; $i < count($array); $i++) { 
                if($searchType == "_ALL_" || $array[$i]->type == $searchType){
                    array_push($types, $array[$i]->type);
                    array_push($IDs, $array[$i]->id, );
                }
            }
            if($searchType == "_ALL_"){
                //A program szabályrendszere miatt a lekért értékeket szortírozni kell homogén tömbökre a tartalomlekérés előtt
                $merged = new Collection();
                $sorted = new Collection();
                $sorted_types = array_unique($types);
                foreach ($sorted_types as $value) {
                    $sorted->$value = [];
                }
                for ($i=0; $i < count($types); $i++) { 
                    $item = $types[$i];
                    array_push($sorted->$item, $IDs[$i]);
                }
                $items = [];
                foreach ($sorted_types as $value) {
                    $item = Content::getClass($value)::whereIn("content_id", $sorted->$value)->get();
                    for ($i=0; $i < count($item); $i++) { 
                        $item[$i] = parent::ClearModelCollection($item[$i]);
                        $item[$i]->item_type = $value;
                    }
                    array_push($items, $item);
                }
                foreach ($items as $value) {
                    $merged = $merged->merge($value);
                }
                foreach ($merged as $value) {
                    array_push($data, $value);
                }
            }
            else{
                $items = Content::getClass($searchType)::whereIn("content_id", $IDs)->get();
                foreach ($items as $value) {
                    array_push($data, $value);
                }
            }
        }
        if($searchType != "_ALL_"){
            $data = parent::ClearModelCollection($data);
        }

        if($onlyColumns != []){
            for ($i=0; $i < count($data); $i++) { 
                $item = new Collection();
                foreach ($onlyColumns as $value) {
                    $item->$value = $data[$i]->$value;
                }
                $data[$i] = $item;
            }
        }
        if($orderBy != null){
            $swap = true;
            if($sort == "desc"){
                $swap = !$swap;
            }
            for ($j=0; $j < count($data)-1; $j++) { 
                for ($i=0; $i < count($data)-1-$j; $i++) { 
                    if($data[$i]->$orderBy > $data[$i+1]->$orderBy && $swap){
                        $x = $data[$i+1];
                        $data[$i+1] = $data[$i];
                        $data[$i] = $x;
                    }
                }
                
            }
            
        }
        return $data;
    }

    /**
     * Lekéri bármilyen típusú tábla kapcsolódó tartalmát, melynek típusa megegyezik a megadottal.
     *
     * @param Model:class $model
     * @param string $filter
     * @param array $relationparameterArray
     * @param array $parameterArray
     * @param array $withrelations
     * @return Collection $data
     */
    public static function _getRelated($model, $filter, $relationparameterArray, $parameterArray = [],  $withrelations = []){
        $raw = $model::where($parameterArray)->whereRelation($filter, $relationparameterArray)->with($withrelations)->get();

        $data = new Collection();
            foreach ($raw as $key => $value) {
                $item = new Collection();
                $itemraw = $value->getAttributes();
                foreach ($itemraw as $itemkey => $itemvalue) {
                $item->$itemkey = $itemvalue;
                }
                $itemraw = $value->getRelations();
                foreach ($itemraw as $itemkey => $itemvalue) {
                $item->$itemkey = $itemvalue;
                }
            $data[$key] = $item;
            }
            return $data;
    }
    
    /**
     * Lekéri az Id-je alapján egy projekt meghatározott fajtájú tartalmát, miközben ellenőrzi a tulajdonost. Lehetőség van az eredmény szűrésére is.
     *
     * @param  Model::class  $model
     * @param object $search
     * @param array $localsearch
     * @param array $withrelations
     * @param array $onlyColumns
     * @param string $orderBy
     * @param string $sort
     * @return array $data
     */
    public static function _getAllContentFromProject($model, $search, $localsearch = null, $withrelations = [], $onlyColumns = ['*'], $orderBy = null, $sort = 'asc'){


        $raw = $model::whereRelation("content", "project_id", "=", $search)
        ->whereRelation("content.owner", "user_id", "=", Auth::user()->id)
        ->where($localsearch)->with($withrelations);

        if($orderBy != null){
            $raw = $raw->orderBy($orderBy, $sort);
        }
        $raw = $raw->get($onlyColumns);

        $data = [];
        //Takarító
        foreach ($raw as $item) {
            if($withrelations != []){
                $item->relations = $item->getRelations();
            }
            $x = parent::ClearModelCollection($item);
            array_push($data, $x);
        }
        return $data;
    }

    /**
     * Megszámolja a paraméterekre kapott mezőket.
     *
     * @param  Model::class  $model
     * @param array $parameterArray
     * @return array $int
     */
    public static function _getCount($model, $parameterArray){
        return $model::where($parameterArray)->count();
    }

    /**
     * Felülírja az adott model táblájában az adott indexű elemet
     *
     * @param Model::class $model
     * @param int $id
     * @param array $inputArray
     */
    public static function _update($model, $id, $inputArray){
        $model = new $model;
        DB::table($model->getTable())->where('id', $id)->update($inputArray);
    }

    /**
     * Törli a megadott Model táblájából a megadott elsődleges kulcsú eleme(ke)t
     *
     * @param Model::class $model
     * @param array $parameterArray
     */
    public static function _destroy($model, $parameterArray){
        $model::where($parameterArray)->delete();
    }

    /**
     * Objektumokra szabott tulajdonos ellenőrző.
     *
     * @param Model::class $model
     * @param int $objId
     * @return bool $is_mine
     */
    protected static function _checkowner($model, $objId){
        try {
            $cId = $model::where('id', '=', $objId)->with("content")->get()[0]->getRelations()["content"]->id;
            return Content::where('id', '=', $cId)->with("owner")->get()[0]->getRelations()["owner"]->id == Auth::user()->id;
        } catch (\Throwable $th) {
            return "is_not_object";
        }
        
    }

    /**
     * A tervezéssel kapcsolatos objektumokra szabott tulajdonos ellenőrző függvény, magában foglalja a projekt és sztori ellenőrzést is.
     *
     * @param int $projId
     * @param int $storyId
     * @param Model::class $model
     * @param int $objId
     * @return bool $is_mine
     */
    protected static function _checkowner_Planning($projId, $storyId, $model = null, $objId = null){

        try {
            $out = false;
            $scId = Story::where('id', '=', $storyId)->with("content")->get()[0]->getRelations()["content"]->id;
            if ($model == null || $objId == null) {
                if (Project::find(['id' => $projId])[0]->user_id == Auth::user()->id &&
                    Content::where('id', '=', $scId)->with("owner")->get()[0]->getRelations()["owner"]->id == Auth::user()->id) {
                    $out = true;
                }
            }
            else{
                $ocId = $model::where('id', '=', $objId)->with("content")->get()[0]->getRelations()["content"]->id;
                if (Project::find(['id' => $projId])[0]->user_id == Auth::user()->id &&
                    Content::where('id', '=', $scId)->with("owner")->get()[0]->getRelations()["owner"]->id == Auth::user()->id &&
                    Content::where('id', '=', $ocId)->with("owner")->get()[0]->getRelations()["owner"]->id == Auth::user()->id) {
                    $out = true;
                }
            }
            return $out;    
        } catch (\Throwable $th) {
            return "is_not_object";
        }
    }

    /**
     * Egy store lekérés alapján elmenti a requestben lévő képet, és a requestet a kép nevével adja vissza.
     *
     * @param Request $request
     * @param string $ownerObjectName
     * @param string $filename
     * @param string $imgPathName
     * @return Request $request
     */
    public static function StoreImg($request, $ownerObjectName, $filename = "file", $imgPathName = "img_path" ){
        if($request->file($filename)){
            $file = $request->file($filename);
            $destinationPath = public_path().'/images/'.$ownerObjectName;
            $filename = str::random(6) . '_' .($file->getClientOriginalName());
            $uploadSuccess = $file->move($destinationPath, $filename);
            $request->merge([$imgPathName => $filename]);
        }
        else{
            $request->merge([$imgPathName => ""]);

        }
        return $request;
    }

    /**
     * Törli az úton elért képet.
     *
     * @param string $fileName
     * @param string $ownerObjectName
     */
    public static function RemoveImg($fileName, $ownerObjectName){
        $destinationPath = public_path().'/images/'.$ownerObjectName.'/';
        try {
            unlink($destinationPath.$fileName);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    /**
     * Visszaadja a megadott objektumhoz tartozó történeteket.
     *
     * @param string $fileName
     * @param string $ownerObjectName
     */
    public static function _getownstory($model, $id){
        $story = self::_getRelatedContent($model, $id, "story", true);
        $data = [];
        foreach ($story as $value) {
            $item = new Collection;
            $item->id = $value->id;
            $item->title = $value->title;
            array_push($data, $item);
        }
        return $data;
    }

    /**
     * A lehetséges láthatóságok listája
     *
     * @return array $visibilities
     */
    public static function getVisibilities(){
        return [
            "private",
            "public"
        ];
    }

    /**
     * A megadott táblaelemnek beállítja a megadott láthatóságot
     *
     * @param Model::class $model
     * @param int $id
     * @param string $newVis
     */
    public static function _changeVisibility($model, $id, $newVis){
        self::_update($model, $id, ["visibility" => $newVis]);
    }

    /**
     * A _getAllObjectRec kiegészítőfüggvénye
     *
     * @param array $raw
     * @param int $id
     * @param Object $newVis
     */
    private static function _searchParentRec($raw, $searchID, $item){
        $found = false;
        for ($i=0; $i < count($raw); $i++) { 
            //array_push(self::$proba, $raw[$i]->id);
            if($found == false){
                if($raw[$i]->id == $searchID){
                    $found = true;
                    //vizsgálni kell, hogy van-e childs tömbje, és abban mi van, mert előfordulhat, hogy az itemnek egy verziója szintén szerepel benne.
                    if(isset($raw[$i]->childs)){
                        $is_in = -1;
                        for ($y=0; $y < count($raw[$i]->childs); $y++) { 
                            if($raw[$i]->childs[$y]->id == $item->id){
                                $is_in = $y;
                            }
                        }
                        if($is_in != -1){
                            $raw[$i]->childs[$is_in]->childs = array_merge($raw[$i]->childs[$is_in]->childs, $item->childs);
                        }
                        else{
                            array_push($raw[$i]->childs, $item);
                        }
                    }
                    else{
                        $raw[$i]->childs = [];
                        array_push($raw[$i]->childs, $item);
                    }
                    break;
                }
                else{
                    if(isset($raw[$i]->childs)){
                        $raw[$i]->childs = self::_searchParentRec($raw[$i]->childs, $searchID, $item);
                    }
                }
            }
        }
        return $raw;
    }

    /**
     * Rekurzívan rendezi parent_id szerint a megfelelő objektumokat. Szükség esetén a $plus_item_content értékeit minden elemben elhelyezi.
     *
     * @param array $base
     * @param array $extension
     * @param array $plus_item_content
     */
    public static function _getAllObjectRec($base, $extension, $plus_item_content = []){
        //FONTOS: Az extension tömb elemeinek a kulcsa az elemek id-je legyen!
        $raw = $base;
        $parent_IDs = [];
        $not_null = -1;
        while ($not_null != 0) {
            $not_null = 0;
            foreach ($raw as $value) {
                if($value->parent_id != null){
                    $not_null++;
                }
            }
            for ($i=0; $i < count($raw); $i++) {
                $raw[$i]->plus_content = $plus_item_content;
                if($raw[$i]->parent_id != null){
                    $child = $raw[$i];
                    if(!in_array($raw[$i]->parent_id, $parent_IDs)){
                        //$raw[$i] = parent::_get(Event::class, ["id" => $raw[$i]->parent_id], true, onlyColumns:['id', 'name', 'type','description', 'parent_id', 'starting_time', 'ending_time']);
                        $raw[$i] = $extension[$raw[$i]->parent_id];
                        $raw[$i]->childs = [];
                        $parent_IDs[$i] = $raw[$i]->id;
                        array_push($raw[$i]->childs, $child);
                    }
                    else{
                        $src = $raw[$i]->parent_id;
                        unset($raw[$i]);
                        $newraw = [];
                        foreach ($raw as $value2) {
                            array_push($newraw, $value2);
                        }
                        $raw = $newraw;
                        $raw = self::_searchParentRec($raw, $src, $child);
                    }
                }
                
            }
        }
        return $raw;
    }

    /**
     * Serial alapján újrarendezi a megfelelő objektumokat a kívánt sorrend listáját felhasználva.
     *
     * @param Model::class $model
     * @param array $array
     */
    public static function resortObject($model, $array){
        $data = [];
        foreach ($array as $key => $value) {
            array_push($data, ["id" => $key, "serial" => $value]);
        }
        for ($j=0; $j < count($data)-1; $j++) { 
            for ($i=0; $i < count($data)-1-$j; $i++) { 
                if($data[$i]["serial"] > $data[$i+1]["serial"]){
                    self::_update($model, $data[$i]["id"], ["serial" => $data[$i+1]["serial"]]);
                    self::_update($model, $data[$i+1]["id"], ["serial" => $data[$i]["serial"]]);
                    $swap = $data[$i]["serial"];
                    $data[$i]["serial"] = $data[$i+1]["serial"];
                    $data[$i+1]["serial"] = $swap;
                }
            }
        }
    }
}
