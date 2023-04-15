<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audience;

class AudienceController extends ConnectionController
{    
    /**
     * Közönségtípus mentése.
     *
     * @param  Request $request
     */
    public static function store(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        $data = ["audiences" => $request->audiences,
                 "name" => $request->name];
        parent::_store(Audience::class, $data);
    }
    
    /**
     * Közönségtípus mentése.
     *
     * @param  Request $request
     * @param  int $id
     */
    public static function update(Request $request, $id){
        $request->validate([
            'name' => 'required'
        ]);
        parent::_update($request,$id,"audiences", [
            'name']);
            return view('Dummy');
    }
    
    /**
     * Közönségtípus törlése
     *
     * @param  int $id
     */
    public static function destroy($id){
        parent::_destroy($id, "audiences");        
        return view('Dummy');
    }
}
