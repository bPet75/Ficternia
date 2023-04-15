<?php

namespace App\Http\Controllers;

use Collator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;
use App\Http\Controllers\Objects\CharacterController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Adatbázismodellek tisztítása
     *
     * @param  Request $request
     * @return Collection
     */
    public static function ClearModelCollection($request){
        $data = null;
        if (gettype($request) == "object") {
            $data = new Collection();
            foreach ($request->getAttributes() as $key => $value) {
                $data->$key = $value;
            }
        }
        elseif (gettype($request) == "array") {
            $data = [];
            foreach ($request as $item) {
                if ($item == null) {
                    continue;
                }
                $col = new Collection();
                foreach ($item->getAttributes() as $key => $value) {
                    $col->$key = $value;
                }
                array_push($data, $col);
            }
        }
        return $data;
    }
}
