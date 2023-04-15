<?php

namespace App\Http\Controllers;

use App\Models\ReadingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingStatusController extends ConnectionController
{    
    /**
     * Olvasás állapotának bejegyzése vagy frissítése
     *
     * @param  int $storyId
     * @param  int $chId
     * @param  bool $is_last
     * @return void
     */
    public static function UpdateReadingStatus($storyId, $chId, $is_last = false){
        $item = parent::_get(ReadingStatus::class, [
            "user_id" => Auth::user()->id,
            "story_id" => $storyId,
        ]);
        
        if(count($item) == 0){
            parent::_store(ReadingStatus::class, [
                "user_id" => Auth::user()->id,
                "story_id" => $storyId,
                "current_chapter_id" => $chId
            ]);
        }
        else{
            if($item[0]->status_update == self::getStatuses()[0]){
                self::RemoveStatusAlert($storyId, Auth::user()->id);
            }
            if($is_last && $item[0]->is_done == 0){
                parent::_update(ReadingStatus::class, $item[0]->id, [
                    "current_chapter_id" => $chId,
                    "is_done" => $is_last
                ]);
            }
            else {
                parent::_update(ReadingStatus::class, $item[0]->id, [
                    "current_chapter_id" => $chId,
                ]);
            }
        }
    }
        
    /**
     * Olvasási állapot alertre állítása egy sztori esetében.
     *
     * @param  int $storyId
     * @return void
     */
    public static function SetStatusToAlert($storyId){
        $items = parent::_get(ReadingStatus::class, ["story_id" => $storyId]);
        $status = self::getStatuses()[0];
        foreach ($items as $value) {
            parent::_update(ReadingStatus::class, $value->id, [
                "status_update" => $status,
            ]);
        }
    }
        
    /**
     * Alert eltávolítása egy fejezetről
     *
     * @param  int $storyId
     * @param  int $uId
     * @return void
     */
    public static function RemoveStatusAlert($storyId, $uId){
        $item = parent::_get(ReadingStatus::class, ["story_id" => $storyId, "user_id" => $uId]);
        parent::_update(ReadingStatus::class, $item->id, [
            "status_update" => null,
        ]);
    }
        
    /**
     * Olvasási állapot törlése
     *
     * @param  int $id
     * @return void
     */
    public static function RemoveReadingStatus($id){
        if(Auth::user()->id != parent::_get(ReadingStatus::class, ["id" => $id], onlyColumns:["user_id"])[0]->user_id){
            abort(403);
        }
        parent::_destroy(ReadingStatus::class, ["id" => $id]);
    }

    /**
     * Lehetséges olvasási állapot alertek visszaadása
     *
     * @return array
     */
    public static function getStatuses(){
        return [
            "alert",
        ];
    }
}
