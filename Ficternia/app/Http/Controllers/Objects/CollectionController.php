<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\ConnectionController;
use App\Models\Collection as DataCollection;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Story;
use App\Models\Draft;
use Illuminate\Support\Facades\DB;

class CollectionController extends ConnectionController
{
    /**
     * Törli az adott kollekció adatait.
     *
     * @param int $projId
     * @param int $storyId
     * @param int $id
     */
    public static function removeCollection($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, DataCollection::class, $id)){
            abort(403);
        }
        $item = parent::_get(DataCollection::class, ["id" => $id], true, onlyColumns:['content_id']);
        parent::_destroy(Content::class, ["id" => $item->content_id]);
   
        return redirect()->route('GetCollections',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Lekéri a kollekciólétrehozó laphoz a szükséges adatokat.
     *
     * @param int $projId
     * @param int $storyId
     * @return Collection $data
     */
    public static function createCollection($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $avilable_drafts = parent::_getRelatedContent(Story::class, $storyId, 'draft');
        $data = new Collection;
        $data->avilable_drafts = [];
        foreach ($avilable_drafts as $value) {
            array_push($data->avilable_drafts, ["id" => $value->id, "title" => $value->title]);
        }
        $data["projId"] = $projId;
        $data["dataType"] = "collection";
        $data["storyId"] = $storyId;
        return view("Planning.Collection.collectionMaker",[
            'data' => $data
        ]);
    }

    /**
     * Lekéri a kollekciófrissítő laphoz a szükséges adatokat.
     *
     * @param int $projId
     * @param int $storyId
     * @param int $id
     * @return Collection $data
     */
    public static function GetCollectionForUpdate($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, DataCollection::class, $id)){
            abort(403);
        }
        $data = new Collection;
        $data->collection = parent::_get(DataCollection::class, ["id" => $id], true);
        $content_raw = parent::_getRelatedContent(DataCollection::class, $id, 'draft', onlyColumns:['id']);
        $avilable_drafts = parent::_getRelatedContent(Story::class, $storyId, 'draft', onlyColumns:['id', 'title']);
        $content = [];
        $data->avilable_drafts = [];
        foreach ($content_raw as $value) {
            array_push($content, $value->id);
        }
        foreach ($avilable_drafts as $value) {
            $item = ["id" => $value->id, "title" => $value->title, "in_this_collection" => false];
            if(in_array($value->id, $content)){
                $item["in_this_collection"] = true;
            }
            array_push($data->avilable_drafts, $item);
        }
        $data["projId"] = $projId;
        $data["dataType"] = "collection";
        $data["storyId"] = $storyId;

        return view("Planning.Collection.collectionMaker",[
            'data' => $data
        ]);
    }

    /**
     * Eltárolja az adott kollekció adatait.
     *
     * @param Request $request
     * @param int $projId
     * @param int $storyId
     */
    public static function store(Request $request, $projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $request->validate([
            'name' => 'required',
        ]);
        $content = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "draft_")){
                array_push($content, $value);
            }
        }
        parent::_storeToContent($projId, DataCollection::class, [
            
            "name" => $request->input('name'),
            "color" => $request->input('color')
        ]);
        $newId = DB::getPdo()->lastInsertId();
        parent::_updateConnection(DataCollection::class, $newId, [$storyId]);
        parent::_updateConnection(DataCollection::class, $newId, $content, Draft::class, false);

        return redirect()->route('GetCollections',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Frissíti az adott kollekció adatait.
     *
     * @param Request $request
     * @param int $projId
     * @param int $storyId
     * @param int $id
     */
    public static function update(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, DataCollection::class, $id)){
            abort(403);
        }
        $request->validate([
            'name' => 'required'
        ]);
        $content = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "draft_")){
                array_push($content, $value);
            }
        }
        parent::_update(DataCollection::class,$id,[
            "name" => $request->input('name'),
            "color" => $request->input('color')
        ]);
        parent::_updateConnection(DataCollection::class, $id, $content, Draft::class, false);

        return redirect()->route('GetCollections',["projId" => $projId, "storyId" => $storyId]);
    }

    
}
