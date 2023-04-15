<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Event;
use App\Models\Project;
use App\Http\Controllers\ProjectController;
use App\Models\Content;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ConnectionController;


class EventController extends ConnectionController
{    
    /**
     * Lekéri az eseménylétrehozó oldalhoz szükséges adatokat
     *
     * @param  int $id
     */
    public static function CreateEvent($id){
        $stories = ProjectController::_getallstoriesIDTitle($id);
        $major_events = parent::_getAllContentFromProject(Event::class, $id, onlyColumns:['id', 'name', 'type','description', 'parent_id', 'starting_time', 'ending_time'], orderBy:'starting_time' );
        $data = new Collection();
        $data->stories = $stories;
        $data->major_events = [];
        foreach ($major_events as $value) {
            if($value->type != self::getEventTypes()[2]){
                $data->major_events[$value->id] = $value->name;
            }
        }
        $data["dataType"] = "event";
        $data["projId"] = $id;
        return view("DataCollecting.event.eventMaker",[
            'data' => $data
        ]);
    }
    
    /**
     * Esemény frissítése
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $id
     */
    public static function updateEvent(Request $request, $projId, $id){
        if(!parent::_checkowner(Event::class, $id)){
            abort(403);
        }
        $request->validate([
            'starting_time' => 'required'
        ]);
        $parent_id = $request->input('parent_id');
        $ending_time = $request->input('ending_time');
        if($ending_time == null || $ending_time < $request->input('starting_time')){
            $ending_time = $request->input('starting_time');
        }
        $type = null;
        switch ($request->input('type')) {
            case 'chapter':
                $type = self::getEventTypes()[1];
                break;
            case 'status':
                $type = self::getEventTypes()[2];
                break;
            default:
                $type = self::getEventTypes()[1];
                break;
        }
        if($type != self::getEventTypes()[1]){
            $request->validate([
                'name' => 'required'
            ]);
            $parent_id = $request->input('parent_id');
            if (count(parent::_get(Event::class, ["parent_id" => $id], onlyColumns:['parent_id'])) > 0) {
                $parent_id = null;
            }
            if($parent_id == 0){
                $parent_id = null;
            }
            parent::_update(Event::class, $id, [
                'name' => $request->input('name'),
                'starting_time' => $request->input('starting_time'),
                'ending_time' => $ending_time,
                'type' => $type,
                'parent_id' => $parent_id,
                'description' => $request->input('description'),
            ]);
            $inStories = [];
            foreach ($request->input() as $key => $value) {
                if(str_contains($key, "story")){
                    array_push($inStories, $value);
                }
            }
            parent::_updateConnection(Event::class, $id, $inStories);
            if($request->input('type') == 'status'){
                $childs = parent::_get(Event::class,["parent_id" => $id], onlyColumns:['id']);
                foreach ($childs as $value) {
                    parent::_update(Event::class, $value->id, ["parent_id" => null]);
                }
            }
    
        }
        else{
            parent::_update(Event::class, $id, [
                'starting_time' => $request->input('starting_time'),
                'ending_time' => $ending_time,
                'description' => $request->input('description'),
            ]);
        }
        return redirect()->route('events',$projId);
    }
    
    /**
     * Lekéri az eventfrissító oldalhoz szükséges adatokat
     *
     * @param  int $projId
     * @param  int $id
     * @param  string $type
     */
    public static function getEventForUpdate($projId,$id,$type){
        $data = new Collection();
        $major_events = parent::_getAllContentFromProject(Event::class, $id, onlyColumns:['id', 'name', 'type','description', 'parent_id', 'starting_time', 'ending_time'], orderBy:'starting_time' );
        $data->event = parent::_get(Event::class, ['id' => $id]);
        $data->major_events = [];
        foreach ($major_events as $value) {
            if($value->id != $id){
                if($value->type != self::getEventTypes()[2]){
                    $data->major_events[$value->id] = $value->name;
                }
            }
        }
        $data->stories = ProjectController::_getallstoriesIDTitle($projId);
        $ownstory = parent::_getownstory(Event::class, $id);

        $array = [];
        foreach ($ownstory as $value) {
            $array[$value->id] = $value->title;
        }
        $data->inStory = $array;
        $data["dataType"] = "event";
        $data["projId"] = $projId;
        return view("DataCollecting.event.eventMaker",[
            'data' => $data
        ]);
    } 
       
    /**
     * Esemény mentése
     *
     * @param  Request $request
     * @param  int $id
     */
    public static function store(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'starting_time' => 'required'
        ]);
        //$request = parent::ClearRequest($request);
        $parent_id = $request->input('parent_id');
        $ending_time = $request->input('ending_time');
        $type = null;
        switch ($request->input('type')) {
            case 'chapter':
                $type = self::getEventTypes()[1];
                break;
            case 'status':
                $type = self::getEventTypes()[2];
                break;
            default:
                $type = self::getEventTypes()[0];
                break;
        }
        if($ending_time == null || $ending_time < $request->input('starting_time')){
            $ending_time = $request->input('starting_time');
        }
        if($parent_id == "0"){
            $parent_id = null;
        }
        parent::_storeToContent($id, Event::class, [
            'name' => $request->input('name'),
            'starting_time' => $request->input('starting_time'),
            'ending_time' => $ending_time,
            'type' => $type,
            'description' => $request->input('description'),
            'parent_id' => $parent_id
            ]);
        $newId = DB::getPdo()->lastInsertId();

        $inStories = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "story") && !str_contains($key, "history")){
                array_push($inStories, $value);
            }
        }
        parent::_updateConnection(Event::class, $newId, $inStories);

        //parent::_connectTableNewValue($request, $newId, "story", "story_events", "story_id", "event_id");
        return redirect()->route('events',$id);
        

    }

    /**
     * Esemény törlése
     *
     * @param  int $projId
     * @param  int $id
     */
    public static function removeEvent($projId, $id){
        if(!parent::_checkowner(Event::class, $id)){
            abort(403);
        }
        $ecId = parent::_get(Event::class, ["id" => $id], true, onlyColumns:['content_id'])->content_id;
        parent::_destroy(Content::class, ["id" => $ecId]);
   
        return redirect()->route('events',$projId);
    }

    /**
     * Visszaadja a lehetséges eseménytípusokalt.
     *
     * @return array
     */
    public static function getEventTypes(){
        return [
            "default",
            "chapter",
            "status"
        ];
    }
}
