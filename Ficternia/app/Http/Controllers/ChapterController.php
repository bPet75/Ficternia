<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\Objects\DraftController;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Draft;
use Illuminate\Support\Collection;
use App\Models\Story;
use Illuminate\Http\Request;

class ChapterController extends ConnectionController
{    
    /**
     * Fejezet törlése.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     * @param  bool $doReturn
     */
    public static function removeChapter($projId, $storyId, $id, $doReturn = true){
        $item = parent::_get(Chapter::class, ["id" => $id], onlyColumns:['draft_id'])[0];
        $draftId = parent::_get(Draft::class, ["id" => $item->draft_id], onlyColumns:['id'])[0]->id;
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $draftId)){
            abort(403);
        }
        parent::_destroy(Chapter::class, ["id" => $id]);
        $story = parent::_get(Story::class, ["id" => $storyId], onlyColumns:['id', 'title'])[0];
        parent::_update(Story::class, $storyId, ["title" => $story->title]);
        if($doReturn){
            return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
        }
    }
        
    /**
     * Fejezet mentése.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     * @param  int $draftId
     */
    public static function store(Request $request, $projId, $storyId, $draftId){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        if(count(parent::_get(Chapter::class, ['draft_id' => $draftId], onlyColumns:['id'])) != 0){
            abort(400);
        }
        ReadingStatusController::SetStatusToAlert($storyId);
        $drafts = parent::_getRelatedContent(Story::class, $storyId, "draft");
        $max_serial = 0;
        foreach ($drafts as $value) {
            $item = parent::_get(Chapter::class, ['draft_id' => $value->id], onlyColumns:['id', 'serial']);
            if(count($item) != 0){
                if($item[0]->serial > $max_serial){
                    $max_serial = $item[0]->serial > $max_serial;
                }
            }
            
        }
        $vis = 'private';
        if($request->input('visibility') == 1){
            $vis = 'public';
        }
        parent::_store(Chapter::class, [
            "title" => $request->input('title'),
            "serial" => $max_serial+=1,
            "body" => $request->input('body'),
            "visibility" => $vis,
            "draft_id" => $draftId,
        ]);
        $story = parent::_get(Story::class, ["id" => $storyId], onlyColumns:['id', 'title'])[0];
        parent::_update(Story::class, $storyId, ["title" => $story->title]);
        return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
    }
        
    /**
     * Adatok lekérése fejezetkészítő oldalhoz.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $draftId
     */
    public static function createChapter($projId, $storyId, $draftId){
        if(!parent::_checkowner_Planning($projId, $storyId, Draft::class, $draftId)){
            abort(403);
        }
        $data = DraftController::_GetDraftForConnect($projId, $storyId, $draftId, true);
        $data->available_visibilities = ConnectionController::getVisibilities();
        return view('Writer.chapterMaker', ["data" => $data]);
    }

    /**
     * Adatok lekérése fejezetkészítő oldalhoz.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function GetChapterForUpdate($projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        $chapter = parent::_get(Chapter::class, ["id" => $id], true);
        $data = DraftController::_GetDraftForConnect($projId, $storyId, $chapter->draft_id, true);
        $data->chapter = $chapter;
        $data->available_visibilities = parent::getVisibilities();
        $data["projId"] = $projId;
        $data["storyId"] = $storyId;
        return view('Writer.chapterMaker',[
            'data' => $data
        ]);
    }
        
    /**
     * update
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function update(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        ReadingStatusController::SetStatusToAlert($storyId);
        $vis = 'private';
        if($request->input('visibility') == 1){
            $vis = 'public';
        }
        parent::_update(Chapter::class, $id, [
            "title" => $request->input('title'),
            "body" => $request->input('body'),
            "visibility" => $vis
        ]);
        $story = parent::_get(Story::class, ["id" => $storyId], onlyColumns:['id', 'title'])[0];
        parent::_update(Story::class, $storyId, ["title" => $story->title]);
        return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
    }
        
    /**
     * Fejezet láthatóságának megváltoztatása.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     * @param  int $id
     */
    public static function ChangeVisibility(Request $request, $projId, $storyId, $id){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        if($request->input("visibility") == "public"){
            ReadingStatusController::SetStatusToAlert($storyId);
        }
        parent::_changeVisibility(Chapter::class, $id, $request->input("visibility"));
    }
        
    /**
     * Adott fejezet értékelésének és azok számának lekérése.
     *
     * @param  int $chId
     * @return array
     */
    public static function getChapterRating($chId){
        $comments = parent::_get(Comment::class, [["chapter_id",'=',$chId],["rating", "!=", null]]);
        $starsSum = 0;
        $starsNum = 0;
        foreach ($comments as $value) {
            $starsSum += $value->rating;
            $starsNum += 1;
        }
        if($starsSum == 0 || $starsNum == 0){
            return [
                "avg" => 0,
                "num" => $starsNum
            ];
        }
        else{
            return [
                "avg" => $starsSum / $starsNum,
                "num" => $starsNum
            ];
        }
    }
        
    /**
     * Fejezetmódosító elosztó.
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $storyId
     */
    public static function chapterModifySwitch(Request $request, $projId, $storyId){
        switch ($request->input('subButton')) {
            case 'publish':
                self::_chapterModifyPublish($projId, $storyId, $request->input(), parent::getVisibilities()[1]);
                return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
                break;
            case 'unpublish':
                self::_chapterModifyPublish($projId, $storyId, $request->input(), parent::getVisibilities()[0]);
                return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
                break;
            case 'unlist':
                self::_chapterModifyPublish($projId, $storyId, $request->input(), parent::getVisibilities()[0]);
                return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
                break;
            case 'update':
                $chId = -1;
                foreach ($request->input() as $key => $value) {
                    if(str_contains($key, "chapter_")){
                        $chId = $value;
                        break;
                    }
                }
                return self::GetChapterForUpdate($projId, $storyId, $chId);
                break;
            case 'delete':
                self::_chapterModifyDelete($projId, $storyId, $request->input());
                return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
                break;
            case 'reorder':
                $array = [];
                foreach ($request->input() as $key => $value) {
                    if(str_contains($key, "chapter_")){
                        $item = explode("_", $value);
                        $array[$item[0]] = $item[1];
                    }
                }
                self::_chapterModifyReorder($projId, $storyId, $array);
                return redirect()->route('openWritingIndex',["projId" => $projId, "storyId" => $storyId]);
                break;
            default:
                # code...
                break;
        }
        $story = parent::_get(Story::class, ["id" => $storyId], onlyColumns:['id', 'title'])[0];
        parent::_update(Story::class, $storyId, ["title" => $story->title]);
    }

    /**
     * Fejezetmódosító elosztó - törlés.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  array $content
     */
    private static function _chapterModifyDelete($projId, $storyId, $content){
        foreach ($content as $key => $value) {
            if(str_contains($key, "chapter_")){
                self::removeChapter($projId, $storyId, explode("_", $value)[0], false);
            }
        }
    }

    /**
     * Fejezetmódosító elosztó - publikálás.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  array $content
     * @param  string $vis
     */
    private static function _chapterModifyPublish($projId, $storyId, $content, $vis){
        if(!parent::_checkowner_Planning($projId, $storyId)){
            abort(403);
        }
        foreach ($content as $key => $value) {
            if(str_contains($key, "chapter_")){
                parent::_update(Chapter::class, explode("_", $value)[0], [
                    "visibility" => $vis
                ]);
            }
        }
    }
    
    /**
     * Fejezetmódosító elosztó - átrendezés.
     *
     * @param  int $projId
     * @param  int $storyId
     * @param  array $array
     */
    private static function _chapterModifyReorder($projId, $storyId, $array){
        $data = [];
        foreach ($array as $key => $value) {
            array_push($data, ["id" => $key, "serial" => $value]);
        }
        for ($j=0; $j < count($data)-1; $j++) { 
            for ($i=0; $i < count($data)-1-$j; $i++) { 
                if($data[$i]["serial"] > $data[$i+1]["serial"]){
                    self::_update(Chapter::class, $data[$i]["id"], ["serial" => $data[$i+1]["serial"]]);
                    self::_update(Chapter::class, $data[$i+1]["id"], ["serial" => $data[$i]["serial"]]);
                    $swap = $data[$i]["serial"];
                    $data[$i]["serial"] = $data[$i+1]["serial"];
                    $data[$i+1]["serial"] = $swap;
                }
            }
        }
    }
    
}
