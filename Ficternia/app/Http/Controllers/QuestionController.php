<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class QuestionController extends ConnectionController
{    
    /**
     * Egy szereplő válaszainak lekérése.
     *
     * @param  int $id
     * @return array
     */
    public static function _getallquestions($id){
        $raw = parent::_get(Question::class, ['character_id' => $id]);
        $output = array();
        $i = 0;
        foreach ($raw as $key => $value) {
            $x = new Collection();
            $x->id = $value->id;
            $x->question_id = $value->question_ID;
            $x->answer = $value->answer;
            $output[$i] = $x;
            $i+=1;
        }
        return $output;
    }
}
