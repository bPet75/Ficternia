<?php

namespace App\Http\Controllers\Objects;

use App\Http\Controllers\ConnectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use App\Models\Story;
use App\Models\Content;

class NoteController extends ConnectionController
{    
    /**
     * Adatok lekérése a jegyzetfrissítő oldal számára
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function GetNoteForUpdate($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Note::class, $id)){
            abort(403);
        }
        $data = new Collection;
        $data->note = parent::_get(Note::class, ["id" => $id], true);
        $inStories = parent::_getRelatedContent(Note::class, $id, 'story', true);
        $data->inStories = [];
        foreach ($inStories as $value) {
            array_push($data->inStories, $value->id);
        }
        $data["projId"] = $projId;
        $data["dataType"] = "note";
        $data["storyId"] = $storyId;
        return view("Planning.Note.noteMaker",[
            'data' => $data
        ]);
    }
    
    /**
     * Jegyzet törlése
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function removeNote($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Note::class, $id)){
            abort(403);
        }
        $item = parent::_get(Note::class, ["id" => $id], true, onlyColumns:['content_id']);
        parent::_destroy(Content::class, ["id" => $item->content_id]);
   
        return redirect()->route('GetNotes',[$projId, $storyId]);
    }
        
    /**
     * Átirányítás a jegyzetlétrehozó oldalra.
     *
     * @param  int $projId
     * @param  int $storyId
     */
    public static function createNote($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        return view("Planning.Note.noteMaker",[
            'data' => ["projId" => $projId, "storyId" => $storyId, "dataType" =>"note"]
        ]);
    }
  
    /**
     * Jegyzet mentése.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     */
    public static function store(Request $request, $projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $request->validate([
            'body' => 'required'
        ]);
        $is_project_note = false;
        $inStories = [$storyId];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "story") && !str_contains($key, "history")){
                //array_push($inStories, $value);
            }
            else if(str_contains($key, "is_project_note")){
                $is_project_note = true;
            }
        }
        parent::_storeToContent($projId, Note::class, [
            "body" => $request->input('body'),
            "is_project_note" => $is_project_note,
        ]);
        $newId = DB::getPdo()->lastInsertId();

        
        parent::_updateConnection(Note::class, $newId, $inStories);

        return redirect()->route('GetNotes',["projId" => $projId, "storyId" => $storyId]);
    }
        
    /**
     * Frissíti az adott jegyzetet.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function update(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId, Note::class, $id)){
            abort(403);
        }
        $request->validate([
            'body' => 'required'
        ]);
        $is_project_note = false;
        $inStories = [$storyId];
        foreach ($request->input() as $key => $value) {
            if(str_contains($key, "story") && !str_contains($key, "history")){
                //array_push($inStories, $value);
            }
            else if(str_contains($key, "is_project_note")){
                $is_project_note = true;
            }
        }
        parent::_update(Note::class,$id,[
            "body" => $request->input('body'),
            "is_project_note" => $is_project_note,
        ]);
        parent::_updateConnection(Note::class, $id, $inStories);

        return redirect()->route('GetNotes',["projId" => $projId, "storyId" => $storyId]);
    }
}
