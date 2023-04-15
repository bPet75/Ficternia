<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Http\Request;
use App\Models\StoryLocation;
use Illuminate\Support\Collection;
use App\Models\Location;
use App\Models\Content;
use App\Models\Event;
use App\Http\Controllers\MajorEventController;
use App\Models\MajorEventLocation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ConnectionController;


class LocationController extends ConnectionController
{
    
    /**
     * Helyszín mentése.
     *
     * @param  Request $request
     * @param  int $projId
     */
    public static function store(Request $request, $projId){
        $request->validate([
            'name' => 'required'
        ]);
        $request = parent::StoreImg($request, 'location');
        //parent::_store($request, "locations", ["name", "state", "ruler", "founder_name", "date_of_founding", "history", "description", "img_path"]);
        parent::_storeToContent($projId, Location::class, [
            "name" => $request->input('name'),
            "state" => $request->input('state'),
            "ruler" => $request->input('ruler'),
            "founder_name" => $request->input('founder_name'),
            "date_of_founding" => $request->input('date_of_founding'),
            "history" => $request->input('history'),
            "description"  => $request->input('description'),
            'img_path' => $request->input('img_path')
        ]);
        $newId = DB::getPdo()->lastInsertId();

        $inStories = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "story") && !str_contains($key, "history")){
                array_push($inStories, $value);
            }
        }
        parent::_updateConnection(Location::class, $newId, $inStories);

        //parent::_connectTableNewValue($request, $newId, "story", "story_locations", "story_id", "location_id");
        return redirect()->route('locations',$projId);
    }   

    /**
     * Helyszín frissítése.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $id
     */
    public static function updateLocation(Request $request, $projId, $id){
        if(!parent::_checkowner(Location::class, $id)){
            abort(403);
        }
        $request->validate([
            'name' => 'required'
        ]);
        $rawLoc = parent::_get(Location::class, ["id" => $id], true, onlyColumns:['img_path']);
        $img_path_legacy = $rawLoc->img_path;

        $request = parent::StoreImg($request, 'location');
        parent::_update(Location::class,$id,[
            "name" => $request->input('name'),
            "state" => $request->input('state'),
            "ruler" => $request->input('ruler'),
            "founder_name" => $request->input('founder_name'),
            "date_of_founding" => $request->input('date_of_founding'),
            "history" => $request->input('history'),
            "description"  => $request->input('description')
        ]);
        
        if($request->img_path != ""){
            parent::_update(Location::class,$id,[
                 'img_path' => $request->img_path,
             ]);

            parent::RemoveImg($img_path_legacy, "location");
        }
        $inStories = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "story") && !str_contains($key, "history")){
                array_push($inStories, $value);
            }
        }
        parent::_updateConnection(Location::class, $id, $inStories);

        //parent::_connectTableNewValue($request, $id, "story", "story_locations", "story_id", "location_id");
        return redirect()->route('locations',$projId);
    }
        
    /**
     * Adatok lekérése a helyszínlétrehozó oldal számára.
     *
     * @param  int $id
     * @return Collection
     */
    public static function CreateLocation($id){

        $stories = ProjectController::_getallstoriesIDTitle($id);
        $data = new Collection();
        $data->stories = $stories;
        $data["dataType"] = "location";
        $data["projId"] = $id;
        return view("DataCollecting.location.locationMaker",[
            'data' => $data
        ]);

    }
        
    /**
     * Adatok lekérése a helyszínfrissítő oldal számára.
     *
     * @param  int $projId
     * @param  int $id
     * @return Collection
     */
    public static function getLocationForUpdate($projId, $id){
        $data = new Collection();
        $data->location = parent::_get(Location::class, ["id" => $id], true, ["content"]);
        $data->stories = ProjectController::_getallstoriesIDTitle($projId);

        $ownstory = parent::_getownstory(Location::class, $id);
        $array = [];
        foreach ($ownstory as $value) {
            $array[$value->id] = $value->title;
        }
        $data->inStory = $array;

        $data["dataType"] = "location";
        $data["projId"] = $projId;
        return view("DataCollecting.location.locationMaker",[
            'data' => $data
        ]);
    }
        
    /**
     * Helyszín törlése
     *
     * @param  int $id
     */
    public static function _removeLocation($id){
        if(!parent::_checkowner(Location::class, $id)){
            abort(403);
        }
        $item = parent::_get(Location::class, ["id" => $id], true, onlyColumns:['img_path','content_id']);
        parent::RemoveImg($item->img_path, "location");
        $lcId = $item->content_id;
        parent::_destroy(Content::class, ["id" => $lcId]);
    }
    
    /**
     * Helyszín törlése és átirányítás
     *
     * @param  int $projId
     * @param  int $id
     */
    public static function removeLocation($projId, $id){
        self::_removeLocation($id);
        return redirect()->route('locations',$projId);
    }
}
