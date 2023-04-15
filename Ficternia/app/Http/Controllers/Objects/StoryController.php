<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\StoryLocation;
use App\Http\Controllers\LocationController;
use App\Models\Story;
use App\Models\Genre;
use App\Models\Audience;
use App\Models\State;
use App\Models\StoryEvent;
use App\Models\Event;
use App\Models\Collection as DataCollection;
use App\Models\MinorEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\Content;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\StateController;
use App\Models\Character;
use App\Models\Chapter;
use App\Models\Note;
use App\Http\Controllers\ReadingStatusController;
use App\Http\Controllers\ConnectionController;
use App\Models\Comment;

class StoryController extends ConnectionController
{    
    /**
     * Egy referencialista alapján megszűri a forráslista tartalmát
     *
     * @param  Collection $source
     * @param  Collection $array
     * @return Collection
     */
    public static function _datafilterbyidarray($source, $array){
        $data = new Collection();
        foreach ($source as $item) {
            $contains = false;
            foreach ($array as $item2) {
                if ($item2->ID == $item->ID) {
                    $contains = true;
                }
            }
            if ($contains==true) {
                $data = $data->add($item);
            }
        }
        return $data;
    }

    /**
     * Lekéri a sztori azon eseményeit, melyeknek nincs szülőeleme.
     *
     * @param  int $id
     * @return array
     */
    public static function _getallmajoreventIDtitles($id){
        $events = parent::_getRelatedContent(Story::class, $id, 'event', onlyColumns:['id','name', 'type', 'parent_id']);
        $data = [];
        foreach ($events as $value) {
            if($value->parent_id == null && $value->type != EventController::getEventTypes()[1]){
                $data[$value->id] = $value->name;
            }
        }
        return $data;
    }
    
    /**
     * Sztori létrehozás.
     *
     * @param  Request $request
     * @param  int $id
     */
    public static function store(Request $request, $id){
        $request->validate([
            'title' => 'required'
        ]);
        parent::StoreImg($request, 'story');

        $inputArray = $request->input();
        unset($inputArray["_token"]);

        parent::_storeToContent($request["projId"], Story::class, $inputArray);

        return redirect()->route('chooseStory',[
            "id" =>$id,
            "type" => "datacollecting"
        ]);
    }
        
    /**
     * Sztori frissítés.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $id
     */
    public static function update(Request $request, $projId, $id){
        $request->validate([
            'title' => 'required'
        ]);
        $rawStor = parent::_get(Story::class, ["id" => $id], true, onlyColumns:['img_path']);
        $img_path_legacy = $rawStor->img_path;

        $request = parent::StoreImg($request, 'story');

        parent::_update(Story::class,$id,
        [
        'title' => $request->input("title"),
        'genre_id' => $request->input("genre_id"),
        'audience_id' => $request->input("audience_id"),
        'state_id' => $request->input()["state_id"],
        'description' => $request->input("description"),
        ]);

        if($request->img_path != ""){
            parent::_update(Story::class,$id,[
                 'img_path' => $request->img_path,
                ]);

            parent::RemoveImg($img_path_legacy, "story");
        }
        ReadingStatusController::SetStatusToAlert($id);

        return redirect()->route('chooseStory',[
            "id" =>$projId,
            "type" => "datacollecting"
        ]);
    }
    
    /**
     * Lekéri a sztorikészítőhöz szükséges adatokat
     *
     * @param  int $id
     * @return Collection
     */
    public function CreateStory($id){

        $data = new Collection();
        // $data->genres = GenreController::getall();
        // $data->audiences = AudienceController::getall();
        // $data->states = StateController::getall();
        $data->genres = parent::_get(Genre::class);
        $data->audiences = parent::_get(Audience::class);
        $data->states = parent::_get(State::class);
        $data->available_visibilities = parent::getVisibilities();
        $data["dataType"] = "story";
        $data["projId"] = $id;
        return view("DataCollecting.story.storyMaker",[
            'data' => $data
        ]);

    }
        
    /**
     * Lekéri a sztorifrissítőhöz szükséges adatokat.
     *
     * @param  mixed $projId
     * @param  mixed $id
     * @return void
     */
    public static function getStoryForUpdate($projId, $id){
        if(!parent::_checkowner(Story::class, $id)){
            abort(403);
        }
        $data = new Collection();
        $data->story = parent::_get(Story::class, ["ID" => $id], true);
        $data->genres = parent::_get(Genre::class);
        $data->audiences = parent::_get(Audience::class);
        $data->states = parent::_get(State::class);
        $data->available_visibilities = parent::getVisibilities();
        $data["dataType"] = "story";
        $data["projId"] = $projId;
        return view("DataCollecting.story.storyMaker",[
            'data' => $data
        ]);
    }
        
    /**
     * Sztori törlése
     *
     * @param  int $id
     */
    public static function _removeStory($id){
        if(!parent::_checkowner(Story::class, $id)){
            abort(403);
        }
        $item = parent::_get(Story::class, ["id" => $id], true, onlyColumns:['content_id', 'img_path']);
        parent::RemoveImg($item->img_path, "story");
        $scId = $item->content_id;

        parent::_destroy(Content::class, ["id" => $scId]);
    }
    
    /**
     * Sztori törlése és átirányítás
     *
     * @param  int $projId
     * @param  int $id
     */
    public static function removeStory($projId, $id){
        self::_removeStory($id);
        return redirect()->route('chooseStory',[
            "id" =>$projId,
            "type" => "datacollecting"
        ]);
    }
    
    /**
     * Lekéri a sztorihoz tartozó jegyzetet.
     *
     * @param  int $projId
     * @param  int $storyId
     * @return array
     */
    public static function getAllNotes($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $data->notes = parent::_getRelatedContent(Story::class, $storyId, "note");
        $proj_notes = parent::_getAllContentFromProject(Note::class, $projId, ["is_project_note" => 1]);
        array_merge($data->notes, $proj_notes);
        $data["storyId"] = $storyId;
        $data["dataType"] = "note";
        $data["projId"] = $projId;
        return view('Planning.Note.noteLister',[
            'data' => $data
        ]);
    }

    /**
     * Lekéri a sztorihoz tartozó vázlatot.
     *
     * @param  int $storyId
     * @return array
     */
    private static function _getAllDrafts($storyId){

        return parent::_getRelatedContent(Story::class, $storyId, "draft");
    }

    /**
     * Lekéri a sztorihoz tartozó vázlatot.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  string $filter
     * @return array
     */
    public static function getAllDrafts($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $data->drafts = self::_getAllDrafts($storyId);
        $data["storyId"] = $storyId;
        $data["dataType"] = "draft";
        $data["projId"] = $projId;
        return view('Planning.Draft.draftLister',[
            'data' => $data
        ]);
    }

    /**
     * Lekéri az írófelülethez a vázlatokat
     *
     * @param  int $projId
     * @param  int $storyId
     * @return Collection
     */
    public static function getAllDraftsForWriting($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $data->story = parent::_get(Story::class, ["id" => $storyId], withrelations:['genre', 'audience', 'state'])[0];
        $data->story->genre = $data->story->genre->name;
        $data->story->audience = $data->story->audience->name;
        $data->story->state = $data->story->state->name;
        $data->drafts = parent::_getRelatedContent(Story::class, $storyId, "draft", onlyColumns:["id", "title"]);
        $draft_IDs = [];
        for ($i=0; $i < count($data->drafts); $i++) { 
            array_push($draft_IDs, $data->drafts[$i]->id);
        }
        $data->chapters = parent::_get(Chapter::class, multiParamArray:["draft_id", $draft_IDs], onlyColumns:['id', 'title', 'visibility', 'views', "created_at", "updated_at", "serial", "draft_id"]);
        $data->visibilities = parent::getVisibilities();
        foreach ($data->drafts as $value) {
            $value->have_chapter = false;
            foreach ($data->chapters as $value2) {
                if($value->id == $value2->draft_id){
                    $value->have_chapter = true;
                    continue;
                }
            }
        }
        for ($j=0; $j < count($data->chapters)-1; $j++) { 
            for ($i=0; $i < count($data->chapters)-1-$j; $i++) { 
                if($data->chapters[$i]->serial > $data->chapters[$i+1]->serial){
                    $item = $data->chapters[$i+1];
                    $data->chapters[$i+1] = $data->chapters[$i];
                    $data->chapters[$i] = $item;
                }
            }
        }
        foreach ($data->chapters as $value) {
            $value->comments = parent::_getCount(Comment::class, ["chapter_id" => $value->id]);
        }
        $data->rating = self::getStoryRating($storyId);
        $data["storyId"] = $storyId;
        $data["projId"] = $projId;
        return view('Writer.writingIndex',[
            'data' => $data
        ]);
    }
        
    /**
     * Lekéri a sztorihoz tartozó összes kollekciót.
     *
     * @param  int $projId
     * @param  int $storyId
     * @return array
     */
    public static function getAllCollections($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $data->collections = parent::_getRelatedContent(Story::class, $storyId, "collection");
        foreach ($data->collections as $value) {
            $content = parent::_getRelatedContent(DataCollection::class, $value->id, 'draft', onlyColumns:['id', 'title']);
            $value->content = [];
            foreach ($content as $item) {
                array_push($value->content, ["id" => $item->id, "title" => $item->title]);
            }
    
        }
        $data["storyId"] = $storyId;
        $data["dataType"] = "collection";
        $data["projId"] = $projId;
        return view('Planning.Collection.collectionLister',[
            'data' => $data
        ]);
    }
        
    /**
     * Lekéri a sztorihoz tartozó összes fejezetet.
     *
     * @param  int $projId
     * @param  int $storyId
     * @return Collection
     */
    public static function getAllChapters($projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $data = new Collection();
        $draft_contents = parent::_getRelatedContent(Story::class, $storyId, "draft", onlyContent:true);
        $chapters = [];
        foreach ($draft_contents as $value) {
            $draft = parent::_get(Draft::class, ["content_id" => $value->id], withrelations:["chapter"], onlyColumns:["id"]);
            array_push($chapters, $draft[0]->chapter);
        }
        $data->chapters = $chapters;
        $data["storyId"] = $storyId;
        $data["projId"] = $projId;
        return view('Planning.Draft.draftLister',[
            'data' => $data
        ]);
    }
        
    /**
     * Láthatóság megváltoztatása a sztorin.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     */
    public static function ChangeVisibility(Request $request, $projId, $storyId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        if($request->input("visibility") == "public"){
            ReadingStatusController::SetStatusToAlert($storyId);
        }
        parent::_changeVisibility(Story::class, $storyId, $request->input("visibility"));
        return redirect()->route('openWritingIndex', ['projId'=>$projId, 'storyId' => $storyId]);
    }
    

    /**
     * Kiszámolja a sztori összértékelését és ezt visszaadja az értékelések számával együtt.
     *
     * @param  int $storyId
     * @return array
     */
    public static function getStoryRating($storyId){
        $ratingSum = 0;
        $ratingNum = 0;
        $drafts = parent::_getRelatedContent(Story::class, $storyId, "draft");
        if(count($drafts) != 0){
            for ($i=0; $i < count($drafts); $i++) { 
                $drafts[$i] = $drafts[$i]->id;
            }
            $chapters = parent::_get(Chapter::class, multiParamArray:["draft_id", $drafts], onlyColumns:["id"]);
            $array = [];
            for ($i=0; $i < count($chapters); $i++) { 
               array_push($array, $chapters[$i]->id); 
            }
            $chapters = $array;
            $comments = parent::_get(Comment::class, [["rating", "!=", null]], multiParamArray: ["chapter_id",$chapters], onlyColumns:["rating"]);
            foreach ($comments as $value) {
                $ratingSum += $value->rating;
                $ratingNum += 1;
            }
        }
        if($ratingSum == 0 || $ratingNum == 0){
            return ["avg" => 0, "num" => $ratingNum];
        }
        else{
            return ["avg" => $ratingSum / $ratingNum, "num" => $ratingNum];
        }
    } 

    /**
     * Admin számára függvény arra, hogy elrejtse a történetet.
     *
     * @param  int $storyId
     */
    public static function hideStory($storyId){
            parent::_changeVisibility(Story::class, $storyId, parent::getVisibilities()[0]);
            return redirect()->route('getStoryForReading', ['storyId' => $storyId]);
    }
    
    /**
     * Vázlatok visszaadása szűrés alapján
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     */
    public static function filterDrafts(Request $request, $projId, $storyId){

        $data = self::_getAllDrafts($storyId);
        $del = [];
        for ($i=0; $i < count($data); $i++) { 
            if(!str_contains($data[$i]->title, $request->input('filter'))){
                array_push($del, $i);
            }
        }
        for ($i=0; $i < count($del); $i++) { 
            unset($data[$i]);
        }

        $data["storyId"] = $storyId;
        $data["projId"] = $projId;
        $data["filter"] = $request->input('filter');
        return view('Planning.Draft.draftLister',[
            'data' => $data
        ]);
    
    }
}

