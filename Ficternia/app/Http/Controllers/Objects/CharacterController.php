<?php

namespace App\Http\Controllers\Objects;

use Illuminate\Http\Request;
use App\Models\Character;
use App\Models\Religion;
use App\Models\CharacterProperties;
use Illuminate\Support\Collection;
use App\Http\Controllers\MajorEventController;
use App\Http\Controllers\QuestionController;
use App\Models\MajorEventCharacter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Story;
use App\Http\Controllers\ProjectController;
use App\Models\Content;
use App\Models\Content_to_Content;
use App\Models\Project;
use App\Models\StoryCharacter;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\ConnectionController;

class CharacterController extends ConnectionController
{
    
    /**
     * Lekér egy karaktert a hozzá tartozó vallással és tulajdonságokkal
     *
     * @param int $Id
     * @return Character::class $character
     */
    public static function _getcharacter($id){

        if(!parent::_checkowner(Character::class, $id)){
            abort(403);
        }
        $character = parent::_get(Character::class, ["id" => $id], true);
        $rel = parent::_getRelatedContent(Character::class, $id, 'religion');
        if($rel != []){
            $character->religion_id = $rel[0]->id;
            $character->religion_name = $rel[0]->name;
        }
        else{
            $character->religion_id = 0;
            $character->religion_name = "";
        }
        $character->properties = [];
        foreach (self::RequiredProperties() as $value) {
            $character->properties[$value] = "";
        }

        $prop = parent::_get(CharacterProperties::class, ['character_id' => $id]);

        foreach ($prop as $value) {
            $character->properties[$value->name] = $value->description;
        }

        return $character; 
    }

    /**
     * Eltárolja az adott szereplő adatait.
     *
     * @param Request $request
     * @param int $projId
     */
    public static function store(Request $request, $projId){
        $request->validate([
            'name' => 'required'
        ]);
        $x = new Character();
        $allProp = array_merge($x->getFillable(), self::RequiredProperties());
        $reqProps = [];
        foreach ($request->input() as $key => $value) {
            array_push($reqProps, $key);
        }
        $diff = array_diff($reqProps, $allProp);
        array_shift($diff);

        $request = parent::StoreImg($request, 'character');

        parent::_storeToContent($projId, Character::class, [
            'name' => $request->input('name'),
            'img_path' => $request->input('img_path')
        ]);

        $newId = DB::getPdo()->lastInsertId();
        $ccId = parent::_get(Character::class, ["id" => $newId], true, onlyColumns:['content_id'])->content_id;
        if($request->input('religion_id') != "0"){
            $rcId = parent::_get(Religion::class, ["id" => $request->input('religion_id')], true, onlyColumns:['content_id'])->content_id;
            parent::_store(Content_to_Content::class, ["first_id" => $ccId, "second_id" => $rcId]);
        }


        $inStories = [];
        $questions = [];
        foreach ($request->input() as $key => $value) {
            if(in_array($key, self::RequiredProperties()) && $value != null){
                parent::_store(CharacterProperties::class, [
                    'name' => $key,
                    'description' => $value,
                    'character_id' => $newId
                ]);
            }
            else if(in_array($key, $diff)){
                if(str_contains($key, "story")){
                    array_push($inStories, $value);
                }
                else if(str_contains($key, "custProp_") && $value != null){
                    $propname = $key;
                    parent::_store(CharacterProperties::class, ["name" => $propname, "description" => $value, "character_id" => $newId]);
                }
                else if(str_contains($key, "question") && $value != null){
                    parent::_store(Question::class, [
                        "question_ID"=> str_replace("question", "", $key),
                        "answer" => $value, 
                        "character_id" => $newId
                    ]);
                }
            }
        }
        parent::_updateConnection(Character::class, $newId, $inStories);

        return redirect()->route('characters',$projId);
    }

    /**
     * Frissíti az adott szereplő adatait.
     *
     * @param Request $request
     * @param int $projId
     * @param int $id
     */
    public static function updateCharacter(Request $request, $projId, $id){
        if(!parent::_checkowner(Character::class, $id)){
            abort(403);
        }
        
        $request->validate([
            'name' => 'required'
        ]);

        $x = new Character();
        $allProp = array_merge($x->getFillable(), self::RequiredProperties(), ['religion_id']);
        $reqProps = [];
        foreach ($request->input() as $key => $value) {
            array_push($reqProps, $key);
        }
        $diff = array_diff($reqProps, $allProp);
        array_shift($diff);

        $rawCh = parent::_get(Character::class, ["id" => $id], true, onlyColumns:['content_id', 'img_path']);
        $img_path_legacy = $rawCh->img_path;

        $request = parent::StoreImg($request, 'character');
        parent::_update(Character::class ,$id, [
            'name' => $request->input('name'),
            ]);
        if($request->img_path != ""){
            parent::_update(Character::class ,$id, [
                'img_path' => $request->img_path,
                ]);

            parent::RemoveImg($img_path_legacy, "character");
        }
        $ccId = $rawCh->content_id;
        $rcId = [];
        if($request->input('religion_id') != "0"){
            $rcId = [$request->input('religion_id')];
        }

        parent::_updateConnection(Character::class, $id, $rcId, Religion::class, false);
        
        $inStories = [];
        $questions = [];
        foreach ($request->input() as $key => $value) {
            //Ha az adott elem kulcsa szerepel a kötelező propertyk listájában
            if (in_array($key, self::RequiredProperties()) && $value != "") {
                $prop = parent::_get(CharacterProperties::class, ["name" => $key, "character_id" => $id]);
                if(count($prop) != 0){
                    parent::_update(CharacterProperties::class, $prop[0]->id, ["description" => $value]);
                }
                else{
                    parent::_store(CharacterProperties::class, ["name" => $key, "description" => $value, "character_id" => $id]);
                }
            }
            else if(in_array($key, $diff)){
                //Ha az adott elem kulcsában szerepel a "story" szó
                if(str_contains($key, "story")){
                    array_push($inStories, $value);
                }
                //Ha az adott elem kulcsában szerepel a "custProp_" szó
                else if(str_contains($key, "custProp_") && $value != null){
                    $propname = $key;
                    $prop = parent::_get(CharacterProperties::class, ["name" => $propname, "character_id" => $id]);
                    if(count($prop) != 0){
                        parent::_update(CharacterProperties::class, $prop[0]->id, ["description" => $value]);
                    }
                    else{
                        parent::_store(CharacterProperties::class, ["name" => $propname, "description" => $value, "character_id" => $id]);
                    }
                }
                else if(str_contains($key, "custProp_") && $value == null){
                    $propname = $key;
                    $prop = parent::_get(CharacterProperties::class, ["name" => $propname, "character_id" => $id]);
                    if(count($prop) != 0){
                        parent::_destroy(CharacterProperties::class, ["id" => $prop[0]->id]);
                    }
                    
                }
                //Ha az adott elem kulcsában szerepel a "question" szó
                else if(str_contains($key, "question") && $value != null){
                    $questions[str_replace("question", "", $key)] = $value;

                    $qId = str_replace("question", "", $key);

                    $item = parent::_get(Question::class, ["question_ID" => $qId, "character_id" => $id], true, onlyColumns:['id']);
                    if($item == null){
                        parent::_store(Question::class, [
                            "question_ID"=> str_replace("question", "", $key),
                            "answer" => $value, 
                            "character_id" => $id
                        ]);
                    }
                    else{
                        parent::_update(Question::class, $item->id, ["answer" => $value]);
                    }
                }
                else if(str_contains($key, "question") && $value == null){
                    $qId = str_replace("question", "", $key);

                    $item = parent::_get(Question::class, ["question_ID" => $qId, "character_id" => $id], true, onlyColumns:['id']);
                    if($item != null){
                        parent::_destroy(Question::class, ["id" => $item->id]);
                    }
                }
            }
        }
        parent::_updateConnection(Character::class, $id, $inStories);

        return ProjectController::getAllCharacters($projId);
    }

    /**
     * Törli az adott szereplő adatait.
     *
     * @param int $id
     */
    public static function _removeCharacter($id){
        if(!parent::_checkowner(Character::class, $id)){
            abort(403);
        }
        $item = parent::_get(Character::class, ["id" => $id], true, onlyColumns:['img_path', 'content_id']);
        parent::RemoveImg($item->img_path, "character");
        $ccId = $item->content_id;
        parent::_destroy(Content::class, ["id" => $ccId]);
    }

    /**
     * A törlés használata
     *
     * @param int $projId
     * @param int $id
     */
    public static function removeCharacter($projId, $id){
        self::_removeCharacter($id);
        return redirect()->route('characters',$projId);
    }

    /**
     * Lekéri a szereplőlétrehozó laphoz a szükséges adatokat.
     *
     * @param int $id
     * @return Collection $data
     */
    public static function CreateCharacter($id){
        $stories = ProjectController::_getallstoriesIDTitle($id);
        $data = new Collection();
        $data->stories = $stories;
        $data->questions = self::Questions();
        $data->religions = ProjectController::_getAllReligions($id);
        $data["dataType"] = "character";
        $data["projId"] = $id;
        return view("DataCollecting.character.characterMaker",[
            'data' => $data
        ]);

    }

    /**
     * Lekéri a szereplőfrissítő laphoz a szükséges adatokat.
     *
     * @param int $projId
     * @param int $id
     * @return Collection $data
     */
    public static function getCharacterForUpdate($projId, $id){
        if(!parent::_checkowner(Character::class, $id)){
            abort(403);
        }
        $data = new Collection();

        $data->character = self::_getcharacter($id);
        $data->stories = ProjectController::_getallstoriesIDTitle($projId);
        $data->questions = self::Questions();
        $data->religions = ProjectController::_getAllReligions($projId);
        $answers = QuestionController::_getallquestions($id);
        foreach ($answers as $value) {
            //$data->questions[$value->id]["answer"] = $value->answer;
            foreach ($data->questions as $key2 => $value2) {
                
            }
            for ($i=0; $i < count($data->questions) ; $i++) { 
                if($data->questions[$i]["id"] == $value->question_id){
                    $data->questions[$i]["answer"] = $value->answer;
                }
            }
        }

        $inStory = parent::_getownstory(Character::class, $id);

        $inStories = [];
        foreach ($inStory as $value) {
            $inStories[$value->id] = $value->title;
        }
        $data->inStory = $inStories;
        $data["dataType"] = "character";
        $data["projId"] = $projId;
        return view("DataCollecting.character.characterMaker",[
            'data' => $data
        ]);
    }

    /**
     * A szereplőkhöz tartozó kérdések
     *
     * @return array $questions
     */
    public static function Questions(){
        if(Lang::locale() == "hu"){
            return array(
                ["id" => 1, "question" => "Mi a legnagyobb félelme?", "answer" => ""],
                ["id" => 2, "question" => "Milyen az őt körülvevő világról alkotott képe?", "answer" => ""],
                ["id" => 3, "question" => "Mi volt a legjobb dolog, ami a múltban történet vele?", "answer" => ""],
                ["id" => 4, "question" => "Mi volt a legrosszabb dolog, ami a múltban történt vele?", "answer" => ""],
                ["id" => 5, "question" => "Mitől lesz szerinte értékes egy személy? Mely tulajdonságai miatt tart kevesebbnek másokat?", "answer" => ""],
                ["id" => 6, "question" => "Mi okoz neki örömöt?", "answer" => ""],
                ["id" => 7, "question" => "Mik számára a legértékesebb dolgok az életben?", "answer" => ""],
                ["id" => 8, "question" => "Mivel nincs megelégedve az életében? Mi az, amin változtatni szeretne?", "answer" => ""],
                ["id" => 9, "question" => "Mi az, ami szerinte boldogságot, kiteljesedést hozhat az életébe?", "answer" => ""],
                ["id" => 10, "question" => "Hogyan teheti meg az első lépést a célja/álma felé?", "answer" => ""],
                ["id" => 11, "question" => "Mi tartja vissza ettől a lépéstől?", "answer" => ""],
                ["id" => 12, "question" => "Mi volt az a múltbeli történés, ami a legnagyobb hatást gyakorolta a jellemére?", "answer" => ""],
                ["id" => 13, "question" => "Mit várt ettől a szakasztól az életében, mielőtt elkezdődött, és mi lepte meg a végén?", "answer" => ""],
                ["id" => 14, "question" => "Hogyan próbálta meg megtartani a régi világnézetét?", "answer" => ""],
                ["id" => 15, "question" => "Hogyan változtatta meg ez a történés a világnézetét?", "answer" => ""],
    
    
            );
        }
        else if(Lang::locale() == "en"){
            return array(
                ["id" => 1, "question" => "What is their greatest fear?", "answer" => ""],
                ["id" => 2, "question" => "What are their views about the world around him?", "answer" => ""],
                ["id" => 3, "question" => "What was the best thing that had happened to them in the past?", "answer" => ""],
                ["id" => 4, "question" => "What was the worst thing that had happened to them in the past?", "answer" => ""],
                ["id" => 5, "question" => "What makes a person important by their views? What makes them look down upon certain pople?", "answer" => ""],
                ["id" => 6, "question" => "What makes them happy?", "answer" => ""],
                ["id" => 7, "question" => "What are the most important things in their life?", "answer" => ""],
                ["id" => 8, "question" => "What are they not content with in their life? What are the things that they would like to change?", "answer" => ""],
                ["id" => 9, "question" => "What brings them happiness? What makes them content?", "answer" => ""],
                ["id" => 10, "question" => "What would be their first step towards their dreams or their goal?", "answer" => ""],
                ["id" => 11, "question" => "What holds them back from taking that step?", "answer" => ""],
                ["id" => 12, "question" => "What happened in their past that had the biggest effect on their personality?", "answer" => ""],
                ["id" => 13, "question" => "What were they expecting from their life at the start of the story? What suprised him in the end?", "answer" => ""],
                ["id" => 14, "question" => "How did they try to keep their old views of the world?", "answer" => ""],
                ["id" => 15, "question" => "How did this event change their view on the world?", "answer" => ""],
    
    
            );
        }
        
    }

    /**
     * A szereplőkhöz tartozó kötelező tulajdonságok
     *
     * @return array $questions
     */
    public static function RequiredProperties(){
        return array(
        'species',
        'biological_sex',
        'gender_identity',
        'date_of_birth',
        'age',
        'past',
        'description',
        'characteristics',
        'ideology',
        );
    }
}
