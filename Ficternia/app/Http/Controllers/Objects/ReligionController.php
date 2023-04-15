<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Http\Request;
use App\Models\Religion;
use App\Models\Content;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Collection;
use Collator;
use App\Http\Controllers\ConnectionController;


class ReligionController extends ConnectionController
{    
    /**
     * Vallás létrehozása
     *
     * @param  Request $request
     * @param  int $id
     */
    public static function store(Request $request, $id){
        $request->validate([
            'name' => 'required'
        ]);
        parent::_storeToContent($id, Religion::class, [
            "name" => $request->input('name'), 
            "description" => $request->input('description')
        ]);
        return redirect()->route('religions',$id);
    }
        
    /**
     * Az adtott vallás frissítése
     *
     * @param  Request $request
     * @param  int $projId
     * @param  int $id
     */
    public static function updateReligion(Request $request,$projId, $id){
        $request->validate([
            'name' => 'required'
        ]);
        parent::_update(Religion::class,$id, [
            "name" => $request->input('name'), 
            "description" => $request->input('description')
        ]);
        return redirect()->route('religions',$projId);
    }
        
    /**
     * Vallás törlése.
     *
     * @param  int $projId
     * @param  int $id
     */
    public static function removeReligion($projId, $id){
        if(!parent::_checkowner(Religion::class, $id)){
            return -1;
        }
        $rcId = parent::_get(Religion::class, ["id" => $id], true, onlyColumns:['content_id'])->content_id;
        parent::_destroy(Content::class, ["id" => $rcId]);
   
        return redirect()->route('religions',$projId);
    }
    
    /**
     * Valláslekérő oldal megnyitása
     *
     * @param  int $id
     */
    public static function CreateReligion($id){
        $data = new Collection();
        $data["dataType"] = "religion";
        $data["projId"] = $id;
        return view("DataCollecting.religion.religionMaker",[
            'data' => $data
        ]);
    }
        
    /**
     * Adatok lekérése a vallásfrissítő oldal számára
     *
     * @param  int $projId
     * @param  int $id
     */
    public static function getReligionForUpdate($projId, $id){
        $data = new Collection();
        $data->religion = parent::_get(Religion::class, ["id" => $id], true);
        $data["dataType"] = "religion";
        $data["projId"] = $projId;
        return view("DataCollecting.religion.religionMaker",[
            'data' => $data
        ]);
    }
}
