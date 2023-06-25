<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\ConnectionController;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Story;
use App\Models\Draft;
use App\Models\Content;
use App\Models\Location;
use App\Models\Event;
use App\Models\CharacterProperties;
use Illuminate\Support\Collection;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Objects\StoryController;

class DraftController extends ConnectionController
{
    /**
     * Lekéri a jegyzetfrissítő laphoz a szükséges adatokat.
     *
     * @param int $projId
     * @param int $storyId
     * @param int $id
     * @return Collection $data
     */
    public static function GetDraftForUpdate($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        $data = new Collection;
        $data->draft = parent::_get(Draft::class, ["id" => $id], true);
        $inStories = parent::_getRelatedContent(Draft::class, $id, 'story', true);
        $draft_events = parent::_getRelatedContent(Draft::class, $id, 'event');
        $data->chapter_event = null;
        foreach ($draft_events as $value) {
            if($value->type == "chapter"){
                $data->chapter_event = $value;
                break;
            }
        }
        $data->inStories = [];
        foreach ($inStories as $value) {
            array_push($data->inStories, $value->id);
        }
        $data["projId"] = $projId;
        $data["dataType"] = "draft";
        $data["storyId"] = $storyId;
        return view("Planning.Draft.draftMaker",[
            'data' => $data
        ]);
    }

    /**
     * Lekéri a jegyzetlétrehozó laphoz a szükséges adatokat.
     *
     * @param int $projId
     * @param int storyId
     * @return Collection $data
     */
    public static function createDraft($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $data["projId"] = $projId;
        $data->chapter_event = null;
        $data["dataType"] = "draft";
        $data["storyId"] = $storyId;
        return view("Planning.Draft.draftMaker",[
            'data' => $data
        ]);
    }

    /**
     * Törli az adott jegyzet adatait.
     *
     * @param int $projId
     * @param int $storyId
     * @param int $id
     */
    public static function removeDraft($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        $item = parent::_get(Draft::class, ["id" => $id], true, onlyColumns:['content_id']);
        parent::_destroy(Content::class, ["id" => $item->content_id]);
   
        return redirect()->route('GetDrafts',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Eltárolja az adott jegyzet adatait.
     *
     * @param Request $request
     * @param int $projId
     * @param int $storyId
     */
    public static function store(Request $request, $projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        if($request->input('with_event') == true){
            $request->validate([
                'event_starting_time' => 'required'
            ]);
            
        }
        $inStories = [$storyId];
        $last_serial = parent::_getRelatedContent(Story::class, $storyId, "draft", orderBy:"serial", sort: "desc");
        if($last_serial != []){
            $last_serial = $last_serial[0]->serial;
        }
        else{
            $last_serial = -1;
        }
        parent::_storeToContent($projId, Draft::class, [
            "title" => $request->input('title'),
            "synopsis" => $request->input('synopsis'),
            "body" => $request->input('body'),
            "serial" => $last_serial+1
        ]);
        $newId = DB::getPdo()->lastInsertId();
        parent::_updateConnection(Draft::class, $newId, $inStories);

        //ha a drafthoz egyből eventet kötünk
        if($request->input('with_event') == true){
            $parent_id = $request->input('event_parent_id');
            $ending_time = $request->input('event_ending_time');
            if($ending_time == null || $ending_time > $request->input('event_starting_time')){
                $ending_time = $request->input('event_starting_time');
            }
            if($parent_id == "0"){
                $parent_id = null;
            }
            parent::_storeToContent($projId, Event::class, [
                'name' => $request->input('title'),
                'starting_time' => $request->input('event_starting_time'),
                'ending_time' => $ending_time,
                'type' => EventController::getEventTypes()[1],
                'description' => $request->input('event_description'),
                'parent_id' => $parent_id
                ]);
            $newEventId = DB::getPdo()->lastInsertId();

            parent::_updateConnection(Event::class, $newEventId, [$storyId]);
            parent::_updateConnection(Event::class, $newEventId, [$newId], Draft::class);
        }

        return redirect()->route('GetDrafts',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Frissíti az adott jegyzet adatait.
     *
     * @param Request $request
     * @param int $projId
     * @param int $storyId
     * @param int $id
     */
    public static function update(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        parent::_update(Draft::class,$id,[
            "title" => $request->input('title'),
            "synopsis" => $request->input('synopsis'),
            "body" => $request->input('body'),
        ]);

        //ha a drafthoz egyből eventet kötünk
        if($request->input('with_event') == true){
            $ending_time = $request->input('event_ending_time');
            if($ending_time == null || $ending_time > $request->input('event_starting_time')){
                $ending_time = $request->input('event_starting_time');
            }

            parent::_update(Event::class, $request->input('event_id'), [
                'starting_time' => $request->input('event_starting_time'),
                'ending_time' => $ending_time,
                'description' => $request->input('event_description'),
                ]);
        }

        return redirect()->route('GetDrafts',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Frissíti az adott jegyzethez tartozó kapcsolatokat.
     *
     * @param Request $request
     * @param int $projId
     * @param int $storyId
     * @param int $id
     */
    public static function updateConnection(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        $characters = [];
        $locations = [];
        $events = [];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "character_")){
                array_push($characters, $value);
            }
            else if(str_contains($key, "location_")){
                array_push($locations, $value);
            }
            else if(str_contains($key, "event_")){
                $item = parent::_get(Event::class, ["id" => $id], onlyColumns:["id", "type"]);
                if($item[0]->type != EventController::getEventTypes()[1]){
                    array_push($events, $value);
                }

            }
            //vizsgálni kell azt az eshetőséget, hogy az event kötés tömbben szerepel a chapter event id is, amihez kötni akarok
            // $arr = [1,2,3];
            // unset($arr[array_search(1, $arr)]);
        }
        $events_legacy = parent::_getRelatedContent(Draft::class, $id, "event", onlyColumns:['id', "type"]);
        foreach ($events_legacy as $key => $value) {
            if($value->type == EventController::getEventTypes()[1] && !in_array($value->id, $events)){
                array_push($events, $value->id);
            }
        }
        parent::_updateConnection(Draft::class, $id, $characters, Character::class, false);
        parent::_updateConnection(Draft::class, $id, $locations, Location::class, false);
        parent::_updateConnection(Draft::class, $id, $events, Event::class, false);

        return redirect()->route('GetDrafts',["projId" => $projId, "storyId" => $storyId]);
    }

    /**
     * Lekéri a jegyzetkötőhöz szükséges összes adatot és objektumot
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     * @param  bool $onlyparts
     * @return Collection $data
     */
    public static function _GetDraftForConnect($projId, $storyId, $id, $onlyparts = false){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        $data = new Collection;
        if($onlyparts == false){
            $data->draft = parent::_get(Draft::class, ["id" => $id], true, onlyColumns:['id', 'title']);
        }
        else{
            $data->draft = parent::_get(Draft::class, ["id" => $id], true);
        }
        $data->notes = parent::_getRelatedContent(Story::class, $storyId, "note");
        $data->characters = [];
        $data->locations = [];
        $data->events = [];
        $characters_part_of = [];
        $locations_part_of = [];
        $events_part_of = [];
            $items = parent::_getRelatedContent(Draft::class, $id, "_ALL_");
            foreach ($items as $value) {
                $out = new Collection();
                switch ($value->item_type) {
                   case 'character':
                        if($onlyparts == false){
                            array_push($characters_part_of, $value->id);
                        }
                        else{
                            $out->id = $value->id;
                            $out->name = $value->name;
                            $out->description = parent::_get(CharacterProperties::class, ['name' => 'description', 'character_id'=>$value->id], true)->description;
                            array_push($characters_part_of, $out);
                        }
                       break;
                    case 'location':
                        if($onlyparts == false){
                            array_push($locations_part_of, $value->id);
                        }
                        else{
                            $out->id = $value->id;
                            $out->name = $value->name;
                            $out->description = $value->description;
                            array_push($locations_part_of, $out);
                        }
                        break;
                    case 'event':
                        if($onlyparts == false){
                            array_push($events_part_of, $value->id);
                        }
                        else{
                            $out->id = $value->id;
                            $out->name = $value->name;
                            $out->description = $value->description;
                            array_push($events_part_of, $out);
                        }
                        break;
                    default:
                     # code...
                        break;
                }
            }
            if($onlyparts == false){
                $items = parent::_getRelatedContent(Story::class, $storyId, "_ALL_");
                foreach ($items as $value) {
                    $out = new Collection();
                    $out->id = $value->id;
                    $out->in_this_collection = false;
                    switch ($value->item_type) {
                        case 'character':
                            $out->name = $value->name;
                            if(in_array($value->id, $characters_part_of)){
                                $out->in_this_collection = true;
                            }
                            array_push($data->characters, $out);
                            break;
                        case 'location':
                            if(in_array($value->id, $locations_part_of)){
                                $out->in_this_collection = true;
                            }
                            $out->name = $value->name;
                            array_push($data->locations, $out);
                            break;
                        case 'event':
                            if(in_array($value->id, $events_part_of)){
                                $out->in_this_collection = true;
                            }
                            $out->name = $value->name;
                            if($value->item_type == EventController::getEventTypes()[1]){
                                $chEvent = parent::_getRelatedContent(Event::class, $value->id, "draft", true, onlyColumns:['id']);
                                if($chEvent[0]->id == $id){
                                    array_push($data->events, $out);
                                }
                            }
                            else{
                                array_push($data->events, $out);
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            else{
                $data->characters = $characters_part_of;
                $data->locations = $locations_part_of;
                $data->events = $events_part_of;
            }
            
        $data["dataType"] = "draft";
        $data["projId"] = $projId;
        $data["storyId"] = $storyId;
        return $data;
    }
  
    /**
     * Adatok lekérése és átirányítás a jegyzetkötőre, vagy a fejezetlétrehozóra.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     * @param bool $onlyparts
     * @return Collection $data
     */
    public static function GetDraftForConnect($projId, $storyId, $id, $onlyparts){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $id)){
            abort(403);
        }
        if($onlyparts){
            return view('Writer.chapterMaker', ["data" => self::_GetDraftForConnect($projId, $storyId, $id, true)]);
        }
        else{
            return view('Planning.Draft.draftConnection', ["data"=>self::_GetDraftForConnect($projId, $storyId, $id)]);
        }
    }
}
