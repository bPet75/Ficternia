<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Objects\StoryController;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Story;
use App\Models\Genre;
use App\Models\State;
use App\Models\Draft;
use App\Models\Content;
use App\Models\User;
use App\Models\Chapter;
use App\Models\ReadingStatus;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class ReadingController extends ConnectionController
{    
    /**
     * Lekéri a publikus történeteket különböző csoportokban, az olvasó indexoldal számára
     *
     */
    public static function getAllStoriesForReading(){
        $data = new Collection();

        //Alerted sztorik
        $alerted = parent::_get(ReadingStatus::class, ["user_id" => Auth::user()->id, "status_update" => "alert"], onlyColumns:["story_id"]);
        $alerted_arr = [];
        for ($i=0; $i < count($alerted); $i++) { 
            array_push($alerted_arr, $alerted[$i]->story_id);
        }
        $alerted = array_unique($alerted_arr);
        $data->alerted_stories = [];
        foreach ($alerted as $value) {
            $item = parent::_get(Story::class, ["id" => $value], true,
            withrelations:['genre', 'audience', 'state'], 
            onlyColumns:['id','title', 'views','description','img_path', 'genre_id', 'audience_id', 'state_id'], limit:6);
            array_push($data->alerted_stories, $item);
        }
        $data->alerted_stories = self::StoryCleaner($data->alerted_stories);
        //Követett userek sztoriai
        $sub = parent::_getInRandomOrder(Subscription::class, ["subscriber_id" => Auth::user()->id], limit: 3);
        if(count($sub) == 3){
            for ($i=1; $i <=count($sub) ; $i++) { 
                $name1 = "sub_stories".$i;
                $name2 = "sub".$i;
                $data-> $name1 = [];
                $data->$name2 = parent::_get(User::class, ["id" => $sub[$i-1]->subscribed_to_id], true)->username;
    
                $items = parent::_getInRandomOrder(Story::class, 
                whereRelation:["owner", "user_id", "=", $sub[$i-1]->subscribed_to_id], 
                withrelations:['genre', 'audience', 'state'], 
                onlyColumns:['id','title', 'views','description','img_path', 'genre_id', 'audience_id', 'state_id'], limit:6);

                $items = self::StoryCleaner($items);
                $data->$name1 = $items;
            }
        }
        
        //Random sztorik
        $randomStories = parent::_getInRandomOrder(Story::class, 
        ["visibility" => ConnectionController::getVisibilities()[1]], 
        ['genre', 'audience', 'state'], 
        ['id','title', 'views','description','img_path', 'genre_id', 'audience_id', 'state_id'], 11);
        $randomStories = self::StoryCleaner($randomStories);
        $data->stories = $randomStories;

        //Három random zsáner
        $genre_Ids = [];

        for ($i=1; $i <= 3;) {
            //$randomGenre = Genre::inRandomOrder()->limit(1)->get();
            $randomGenre = parent::_getInRandomOrder(Genre::class, limit:1);
            $arrayName = "rand_genre".$i;
            $data->$arrayName = $randomGenre[0]->name;
            if(!in_array($randomGenre[0]->id, $genre_Ids)){
                array_push($genre_Ids, $randomGenre[0]->id);
            }
            else{
                continue;
            }
            $randomStoriesByGenre = parent::_getInRandomOrder(Story::class, 
            ["visibility" => ConnectionController::getVisibilities()[1], "genre_id" => $randomGenre[0]->id], 
            ['genre', 'audience', 'state'], 
            ['id','title', 'views','description','img_path', 'genre_id', 'audience_id', 'state_id'], 11);

            $randomStoriesByGenre = self::StoryCleaner($randomStoriesByGenre);

            $arrayName = "stories_by_genre".$i;
            if($randomStoriesByGenre != []){
                $data->$arrayName = $randomStoriesByGenre;
                $i+=1;
            }
            
        }
        

        //hidden gems
        $data->hidden_gems = [];
        $newstories = parent::_get(Story::class, 
        ["visibility" => ConnectionController::getVisibilities()[1]], orderBy: 'views', 
        withrelations:['genre', 'audience', 'state'], 
        onlyColumns: ['id','title', 'views','description','img_path', 'genre_id', 'audience_id', 'state_id'], limit:30);

        foreach ($newstories as $value) {
            $value->genre = $value->genre->name;
            $value->audience = $value->audience->name;
            $value->state = $value->state->name;
            $item = StoryController::getStoryRating($value->id);
            if($item["avg"] >= 4 && $item["num"] >= 3){
                array_push($data->hidden_gems, $item);
            }
        }
        $data->filter_data = self::getFilterData();
        return view('Browsing.index',[
            'data' => $data
        ]);
    }
        
    /**
     * Sztorik adatszerkezeteinek egybeolvasztása a kapcsolt táblákkal és kitakarítása.
     *
     * @param  Story::class $data
     * @return Collection
     */
    public static function StoryCleaner($data){
        $out = [];
        try {
            foreach ($data as $value) {
                $item = new Collection();
                $item->id = $value->id;
                $item->views = $value->views;
                $item->title = $value->title;
                $item->description = $value->description;
                $item->img_path = $value->img_path;
                $item->visibility = $value->visibility;
                $item->genre = $value->getRelations()["genre"]->name;
                $item->audience = $value->getRelations()["audience"]->name;
                $item->state = $value->getRelations()["state"]->name;
                array_push($out, $item);
            }
        } catch (\Throwable $th) {
            foreach ($data as $value) {
                $item = new Collection();
                $item->id = $value->id;
                $item->views = $value->views;
                $item->title = $value->title;
                $item->description = $value->description;
                $item->img_path = $value->img_path;
                $item->visibility = $value->visibility;
                $item->genre = $value->genre->name;
                $item->audience = $value->audience->name;
                $item->state = $value->state->name;
                array_push($out, $item);
            }
        }
        
        return $out;
    }
        
    /**
     * Egy sztori és a hozzá tartozó adatok lekérése olvasáshoz.
     *
     * @param  int $storyId
     */
    public static function getStoryForReading($storyId){
        $data = new Collection();
        $data->story = parent::_get(Story::class, ["id" => $storyId], true, withrelations:['genre', 'audience', 'state', 'content']);

        if(!parent::_checkowner(Story::class, $data->story->id)){
            parent::_update(Story::class, $data->story->id, [
                "views" => $data->story->views +1
            ]);
        }
        $owner = parent::_get(Content::class, ["id" => $data->story->content->id], withrelations:["owner"])[0]->owner;
        $data->subscribed = false;
        if(count(parent::_get(Subscription::class, ["subscriber_id" => Auth::user()->id, "subscribed_to_id" => $owner->id])) != 0){
            $data->subscribed = true;
        }
        $data->owner = new Collection();
        $data->owner->id = $owner->id;
        $data->owner->username = $owner->username;
        $is_mine = false;
        if($data->owner->id == Auth::user()->id){
            $is_mine = true;
        }
        $data->i_am_admin = Auth::user()->role_id == 1;
        $data->owner->is_mine = $is_mine;

        $data->story = self::StoryCleaner([$data->story])[0];
        $data->chapters = [];
        $drafts = parent::_getRelatedContent(Story::class, $storyId, "draft", onlyColumns:["id", "title"]);
        $data->drafts = $drafts;
        foreach ($drafts as $value) {
            $chapter = parent::_get(Chapter::class, [["draft_id","=", $value->id],
            ["visibility", "!=", ConnectionController::getVisibilities()[0]]], 
            onlyColumns:['id', 'title', 'visibility', 'views', "created_at", "updated_at", "serial"], withrelations:["comments"]);
            if(count($chapter) != 0){
                $chapter = $chapter[0];
                $chapter->commentCount = count($chapter->comments);
                unset($chapter->comments);
                array_push($data->chapters, $chapter);
                $value->have_chapter = true;
            }
            else{
                $value->have_chapter = false;
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
        for ($i=0; $i < count($data->chapters); $i++) { 
            $data->chapters[$i]->is_last = false;
            if($i == count($data->chapters)-1){
                $data->chapters[$i]->is_last = true;
            }
        }
        $data->filter_data = self::getFilterData();
        $data->rating = StoryController::getStoryRating($storyId);
        $data["storyId"] = $storyId;
        return view('Browsing.storyPage',[
            'data' => $data
        ]);
    }
        
    /**
     * Egy fejezet lekérése olvasáshoz
     *
     * @param  int $storyId
     * @param  int $chId
     * @param  bool $is_last
     */
    public static function getChapterForReading($storyId, $chId, $is_last){
        $data = new Collection();
        $data->chapter = parent::_get(Chapter::class, ["id" => $chId], onlyColumns:["id", "draft_id", "views"]);
        $is_own = parent::_checkowner(Draft::class, $data->chapter[0]->draft_id);
        if(!$is_own){
            parent::_update(Chapter::class, $data->chapter[0]->id, [
                "views" => $data->chapter[0]->views +1
            ]);
            ReadingStatusController::UpdateReadingStatus($storyId, $chId, $is_last);
        }
        $data->i_am_admin = Auth::user()->role_id == 1;
        $data->comments = CommentController::getAllComments($storyId, $chId, ["is_own" => $is_own,"auth_id" => Auth::user()->id, "i_am_admin" => $data->i_am_admin, "is_last" => $is_last]);
        $data->chapter = parent::_get(Chapter::class, ["id" => $chId])[0];
        $data->is_own = $is_own;
        $data->is_last = $is_last;
        $data["storyId"] = $storyId;
        $data->filter_data = self::getFilterData();
        return view('Browsing.chapterPage',[
            'data' => $data
        ]);
    }
        
    /**
     * Sztorik szűrése
     *
     * @param  Request $request
     */
    public static function getStoriesFiltered(Request $request){
        $input_arr = [];
        $owner_place = 0;
        $have_owner = false;
        $request = $request->input();
        unset($request["_token"]);
        $null_vals = [];
        $used_filters = [];
        foreach ($request as $key => $value) {
            if($value == null){
                array_push($null_vals, $key);
            }
        }
        foreach ($null_vals as $value) {
            unset($request[$value]);
        }
        foreach ($request as $key => $value) {
            if(str_contains($key, "_id")){
                array_push($input_arr, [$key, '=', $value]);
                $used_filters[$key] = $value;
            }
            else{
                array_push($input_arr, [$key, 'LIKE', '%'.$value.'%']);
                $used_filters[$key] = $value;
            }
            if($key != "owner" && !$have_owner){
                $owner_place++;
            }
            else{
                $have_owner = true;
            }
        }
        $data = new Collection;
        $data->used_filters = $used_filters;
        if($have_owner){
            $input_arr[$owner_place][0] = "username";
            $user = parent::_get(User::class, [$input_arr[$owner_place]], true);
            unset($input_arr[$owner_place]);
            if($user != null){
                $data->stories = parent::_getRelated(Story::class, "owner", ["user_id" => $user->id], $input_arr, ["genre", "audience", "state"]);
            }
        }
        else{
            $data->stories = parent::_get(Story::class, $input_arr, withrelations:["genre", "audience", "state"]);
        }

        $data->stories = self::StoryCleaner($data->stories);
        $data->filter_data = self::getFilterData();
        return view('Browsing.searchResult',[
            'data' => $data
        ]);
    }
 
    /**
     * Adatok lekérése a szűrő számára
     *
     * @return Collection
     */
    public static function getFilterData(){
        $data = new Collection();
        $data->genres = parent::_get(Genre::class);
        $data->audiences = parent::_get(Audience::class);
        $data->state = parent::_get(State::class);
        return $data;
    }
    
    /**
     * Fejezet elrejtése admin gomb által
     *
     * @param  int $storyId
     * @param  int $chId
     */
    public static function hideChapter($storyId, $chId){
        parent::_changeVisibility(Chapter::class, $chId, parent::getVisibilities()[0]);
        return redirect()->route('chapterPage', ['storyId' => $storyId, 'cgId'=>$chId]);
        
    }

    /**
     * A lehetséges szűrési szempontok
     *
     * @return array $questions
     */
    public static function getFilters(){
        if(Lang::locale() == "hu"){
            return array("title" => "Cím", "owner" => "Író", "genre_id" => "Zsáner", "audience_id" => "Közönség", "state_id" => "Állapot");
        }
        else if(Lang::locale() == "en"){
            return array("title" => "Title", "owner" => "Writer", "genre_id" => "Genre", "audience_id" => "Audience", "state_id" => "State");
        }
        
    }
}
