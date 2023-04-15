<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Character;
use App\Models\Story;
use App\Models\Event;
use App\Models\Location;
use App\Models\Religion;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Controllers\Objects\CharacterController;
use App\Http\Controllers\Objects\LocationController;
use App\Http\Controllers\Objects\StoryController;
use App\Http\Controllers\Objects\EventController;

class ProjectController extends ConnectionController
{    
    /**
     * Lekéri a projekt összes sztorijának id-jét és címét.
     *
     * @param  int $projId
     * @return array
     */
    public static function _getallstoriesIDTitle($projId){
        $raw = parent::_getAllContentFromProject(Story::class, $projId);
        $output = [];
        foreach ($raw as $value) {
            $output[$value->id] = $value->title;
        }
        return $output;
    }
    
    /**
     * A projekt szereplőinek lekérése.
     *
     * @param  int $projId
     * @param  int $storyID
     */
    public static function getAllCharacters($projId, $storyID = null){

        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = new Collection();
        $data->characters = parent::_getAllContentFromProject(Character::class, $projId, withrelations:["properties", "answers"]);

        $prop_array = Arr::only(CharacterController::RequiredProperties(), [0, 4, 6]);
        foreach ($data as $value) {
            foreach ($value->relations["properties"] as $item) {
                if (in_array($item->getAttributes()["name"], $prop_array)) {
                    $name = $item->getAttributes()["name"];
                    $desc = $item->getAttributes()["description"];
                    $value->$name = $desc;
                }
            }
            foreach ($prop_array as $prop) {
                if (!isset($value->$prop)) {
                    $name = $prop;
                    $desc = "";
                    $value->$name = $desc;
                }
            }
            $value->relations = null;
        } 
        foreach ($data->characters as $character) {
            $character->properties = [];
            foreach ($character->relations["properties"] as $value) {
                $character->properties[$value->name] = $value->description;
            }
            unset($character->relations);
        }
        $data["dataType"] = "character";
        $data["projId"] = $projId;
        return view('DataCollecting.character.characterList',[
            'data' => $data
        ]);
        
    }
    
    /**
     * A projekt összes helyszínének lekérése.
     *
     * @param  int $id
     */
    public static function getAllLocations($id){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = new Collection();
        $data->locations = parent::_getAllContentFromProject(Location::class, $id);
        $data["dataType"] = "location";
        $data["projId"] = $id;
        return view('DataCollecting.location.locationList',[
            'data' => $data
        ]);
        
    }
        
    /**
     * Események rekurzív rendezése.
     *
     * @param  Collection $coll
     * @return Collection
     */
    private static function _sortEvents($coll){
        for ($j=0; $j < count($coll)-1; $j++) { 
            for ($i=0; $i < count($coll)-1-$j; $i++) { 
                if(isset($coll->childs)){
                    self::_sortEvents($coll->childs);
                }
                if($coll[$i]->starting_time > $coll[$i+1]->starting_time){
                    $c = $coll[$i];
                    $coll[$i] = $coll[$i+1];
                    $coll[$i+1] = $c;
                }
            }
        }
        return $coll;
    }  

    /**
     * Események lekérése és rendezése.
     *
     * @param  array $base
     * @param  array $extension
     * @param  array $plus_item_content
     * @return array
     */
    private static function _getAllEventsRec($base, $extension, $plus_item_content = []){
        return self::_sortEvents(parent::_getAllObjectRec($base, $extension, $plus_item_content));
    }
        
    /**
     * Egy projekt eseményeinek lekérése rekurzívan rendezve.
     *
     * @param  int $id
     */
    public static function getAllEvents($id){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $events = self::_getAllContentFromProject(Event::class, $id);
        $new_events = [];
        for ($i=0; $i < count($events); $i++) { 
            $new_events[$events[$i]->id] = $events[$i];
        }
        $events = $new_events;
        $data = new Collection();
        $data->events = self::_getAllEventsRec(self::_getalleventswithoutchilds($id), $events, ["projId" => $id]);
        $data["dataType"] = "event";
        $data["projId"] = $id;
        return view('DataCollecting.event.eventList',[
            'data' => $data
        ]);
    }
    
    /**
     * Gyermek nélküli események lekérése.
     *
     * @param  int $id
     * @return array
     */
    public static function _getalleventswithoutchilds($id){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = []; 
        $events = parent::_getAllContentFromProject(Event::class, $id, onlyColumns:['id', 'name', 'type','description', 'parent_id', 'starting_time', 'ending_time'], orderBy:'id' );
        foreach ($events as $value) {
            if(count(parent::_get(Event::class, ["id" => $value->id], withrelations:["childs"])[0]->childs) == 0){
                array_push($data, $value);
            }
        }
        return $data;
    }
    
    /**
     * A projekt összes sztorijának lekérése.
     *
     * @param  string $type
     * @param  int $id
     * @return void
     */
    public static function getAllStories($type, $id){
        $data = new Collection();
        $data->stories = parent::_getAllContentFromProject(Story::class, $id);
        $data["dataType"] = "story";
        $data["projId"] = $id;
        $data['type'] = $type;
        if($type == "datacollecting"){
            $data["extend"] = "DataCollecting.index";
            $data['section'] = "lister";
        }else{
            $data["extend"] = "main";
            $data['section'] = "content";
        }
        return view('layouts.chooseStory',[
            'data' => $data
        ]);
    }
        
    /**
     * Projekt mentése.
     *
     * @param  Request $request
     */
    public static function store(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        parent::_store(Project::class, 
        [
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'description' => $request->description
        ]);
        return redirect()->route('chooseProject', ["type"=>"datacollecting"]);
    }
    
    /**
     * Projekt frissítése.
     *
     * @param  Request $request
     * @param  int $id
     */
    public static function updateProject(Request $request,$id){
        $request->validate([
            'name' => 'required'
        ]);
        parent::_update(Project::class,$id,
        [
        'name'=>$request->input("name"),
        'user_id'=>Auth::user()->id,
        'description'=>$request->input("description")
        ]);
        return redirect()->route('chooseProject', ["type" => "datacollecting"]);
    }
    
    /**
     * Egy projekt és a hozzá tartozó elemek törlése.
     *
     * @param  int $id
     */
    public static function removeProject($id){
        $uId = parent::_get(Project::class, ["ID" => $id], true, onlyColumns:['user_id'])->user_id;
        if(Auth::user()->id != $uId){
            abort(403);
        }
        $characters = self::_getAllContentFromProject(Character::class, $id, onlyColumns:'id');
        $locations = self::_getAllContentFromProject(Location::class, $id, onlyColumns:'id');
        $stories = self::_getAllContentFromProject(Story::class, $id, onlyColumns:'id');

        foreach ($characters as $value) {
            CharacterController::_removeCharacter($value->id);
        }
        foreach ($locations as $value) {
            LocationController::_removeLocation($value->id);
        }
        foreach ($stories as $value) {
            StoryController::_removeStory($value->id);
        }
        parent::_destroy(Project::class, ["id" => $id]);
   
        return redirect()->route('chooseProject', ['type' => 'datacollecting']);
    }
        
    /**
     * Adatok lekérése a projektfrissítő oldal számára.
     *
     * @param  int $id
     */
    public static function getProjectForUpdate($id){
        
        $data = parent::_get(Project::class, ["id" => $id], true, onlyColumns:["id", "name", "description"]);
        return view('DataCollecting.project.projectMaker',[
            'data' => $data
        ]);
    }
        
    /**
     * Átirányítás a projektkészítő oldalra.
     *
     */
    public static function createProject(){
        return view('DataCollecting.project.projectMaker');
    }
 
    /**
     * Egy projekt összes vallásának lekérése.
     *
     * @param  int $id
     * @return void
     */
    public static function _getAllReligions($id){
        return parent::_getAllContentFromProject(Religion::class, $id);
    }
        
    /**
     * Egy projekt összes vallásának lekérése és átirányítás.
     *
     * @param  int $id
     */
    public static function getAllReligions($id){
        $data = new Collection();
        $data->religions = self::_getAllReligions($id);
        $data["dataType"] = "religion";
        $data["projId"] = $id;
        return view('DataCollecting.religion.religionList',[
            'data' => $data
        ]);

    }
        
    /**
     * Adatok átadása az idővonalnak
     *
     * @param  int $projId
     */
    public static function assembleTimeline($projId){
        $data = new Collection();
        $data["dataType"] = "timeline";
        $data["projId"] = $projId;
        $data->stories = parent::_getAllContentFromProject(Story::class, $projId, onlyColumns:['id', 'title']);
        $data->events = parent::_getAllContentFromProject(Event::class, $projId, orderBy:"starting_time");
        foreach ($data->events as $value) {
            $value->inStory = [];
            array_push($value->inStory, parent::_getRelatedContent(Event::class, $value->id, "story", true)[0]->id);
            $value->characters = parent::_getRelatedContent(Event::class, $value->id, 'character');
            $value->locations = parent::_getRelatedContent(Event::class, $value->id, 'location');
            if($value->parent_id != null){
                $value->parent_name = parent::_get(Event::class, ["id" => $value->parent_id], onlyColumns:['name'], one:true)->name;
            }
        }
        return view('Timeline.timeline',[
            'data' => $data
        ]);
    }
    
}
