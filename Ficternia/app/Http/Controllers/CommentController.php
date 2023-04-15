<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Chapter;
use Draft;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentController extends ConnectionController
{    
    /**
     * Komment létrehozása.
     *
     * @param  Request $request
     * @param  int $storyId
     * @param  int $chId
     * @param  int $parentId
     */
    public static function store(Request $request, $storyId, $chId, $parentId, $is_last){
        $request->validate([
            'body' => 'required'
        ]);
        $rating = null;
        $parent_id = null;
        if($parentId != 0){
            $parent_id = $parentId;
        }
        if($request->input('rating') > 0 && $request->input('rating') <= 5){
            $rating = $request->input('rating');
            if(count(parent::_get(Comment::class, [["user_id", "=", Auth::user()->id], ["rating", "!=", null]])) > 0){
                abort(400);
            }
        }
        $parent_ch = parent::_get(Chapter::class, ["id" => $chId], onlyColumns:["draft_id"])[0];
        $parent = parent::_get(Comment::class, ["id" => $chId], onlyColumns:["rating"])[0];
        if($parent->rating != null && !parent::_checkowner(Draft::class, $parent_ch->draft_id)){
            abort(403);
        }
        parent::_store(Comment::class, [
            "body" => $request->input('body'),
            "rating" => $rating,
            "user_id" => Auth::user()->id,
            "chapter_id" => $chId,
            "parent_id" => $parent_id

        ]);
        return redirect()->route('chapterPage',["storyId" => $storyId, "chId" => $chId, "is_last" => $is_last]);
    }
        
    /**
     * Gyermekelem nélküli kommentek lekérése.
     *
     * @param  int $chId
     * @return Collection
     */
    public static function _getallcommentswithoutchilds($chId){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = []; 
        $comments = parent::_get(Comment::class, [["chapter_id", "=", $chId]], withrelations:['childs', 'writer']);
        foreach ($comments as $value) {
            if(count($value->childs) == 0){
                $value->writer = $value->writer[0]->username;
                unset($value->childs);
                array_push($data, $value);
            }
        }
        return $data;
    }
        
    /**
     * Egy fejezet kommentjeinek lekérése.
     *
     * @param  int $storyId
     * @param  int $chId
     * @param  array $plus_item
     * @return Collection
     */
    public static function getAllComments($storyId, $chId, $plus_item = []){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $comments = parent::_get(Comment::class, [["chapter_id", "=", $chId]], withrelations:['writer']);
        $new_comments = [];
        for ($i=0; $i < count($comments); $i++) { 
            $comments[$i]->writer = $comments[$i]->writer[0]->username;
            $new_comments[$comments[$i]->id] = $comments[$i];
        }
        $comments = $new_comments;
        $data = new Collection();
        $plus_items = array_merge($plus_item, ["storyId" => $storyId]);
        $data->comments = parent::_getAllObjectRec(self::_getallcommentswithoutchilds($chId), $comments, $plus_items);
        $data->ratings = [];
        $array_unset = [];
        for ($i=0; $i < count($data->comments); $i++) { 
            if($data->comments[$i]->rating != null){
                array_push($data->ratings, $data->comments[$i]);
                array_push($array_unset, $i);
                
            }
        }
        foreach ($array_unset as $value) {
            unset($data->comments[$value]);
        }
        return $data;
    }
        
    /**
     * Komment frissítése.
     *
     * @param  Request $request
     * @param  int $chId
     * @return void
     */
    public static function update(Request $request, $chId){
        $draft_id = parent::_get(Chapter::class, ["id" => $chId], onlyColumns:['id', 'draft_id'])[0]->draft_id;
        if(!parent::_checkowner(Draft::class, $draft_id)){
            abort(403);
        }
        parent::_update(Comment::class, $request->input('id'), ['body' => $request->input('body')]);
    }
        
    /**
     * Adatok lekérése a kommentfrissítő oldal számára.
     *
     * @param  int $commId
     * @param  int $chId
     * @return Collection
     */
    public static function getCommentForUpdate($commId, $chId){
        $comment = parent::_get(Comment::class, ["id" => $commId])[0];
        $data = new Collection();
        $data->comment = $comment;
        $data->chId = $chId;
        return $data;
    }
        
    /**
     * Komment törlése.
     *
     * @param  int $commId
     * @param  int $chId
     */
    public static function removeComment($storyId, $chId, $commId){
        dd($commI);
        $draft_id = parent::_get(Chapter::class, ["id" => $chId], onlyColumns:['id', 'draft_id'])[0]->draft_id;
        if(!parent::_checkowner(Draft::class, $draft_id)){
            abort(403);
        }
        $comment = parent::_get(Comment::class, ['id' => $commId], withrelations:["childs"])[0];
        if($comment->childs != []){
            parent::_update(Comment::class, $commId, ['body' => 'deleted']);
        }
        else {
            parent::_destroy(Comment::class, ['id' => $commId]);
        }
        return redirect()->route('chapterPage', ['storyId' => $storyId, 'chId'=>$chId, "is_last" =>1]);
        
    }
}
