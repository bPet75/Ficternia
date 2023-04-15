<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Objects\CollectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Story;
use App\Models\User;
use App\Models\Character;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Objects\DraftController;
use App\Http\Controllers\Objects\StoryController;
use App\Models\ReadingStatus;
use App\Models\Subscription;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class UserController extends ConnectionController
{

    /**
     * Lekéri a felhasználó összes projektjét
     *
     * @param string $type
     * @return array $data
     */
    public static function getAllProjects($type = 'planning'){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = new Collection();
        $data->projects = parent::_get(Project::class, ["user_id" => Auth::user()->id]);
        $data['type'] = $type;
        return view('layouts.chooseProject',[
            'data' => $data
        ]);
    }

    /**
     * Megvizsgálja, hogy a bejelentkezett felhasználónak van-e projektje.
     *
     * @return bool $have_project
     */
    public static function isHaveProject(){
        if (!Auth::check()) {
            return view('auth.login');
        }
        $data = parent::_get(Project::class, ["user_id" => Auth::user()->id], true, onlyColumns:['id']);
        return view('layouts.projectWorkType',[
            'data' => $data != null
        ]);
    }

    /**
     * Lekéri egy felhasználó adatait, hogy kikre íratkozott fel, és a történeteit.
     *
     * @param int $id
     * @return Collection $data
     */
    public static function getUser($id){
        $data = new Collection();
        $data->user = parent::_get(User::class, ["id" => $id], true);
        unset($data->user->password);
        $data->is_me = $data->user->id == Auth::user()->id;
        if(str_contains(url()->current(), "Settings")){
            return view('Userpages.userPage', [
                "data" => $data
            ]);
        }
        $users_sub_to = parent::_getInRandomOrder(Subscription::class, ["subscriber_id" => Auth::user()->id], withrelations:["subscribed_to"], limit:8);

        for ($i=0; $i < count($users_sub_to); $i++) { 
            $users_sub_to[$i] = $users_sub_to[$i]->subscribed_to[0];
            $item = new Collection();
            $item->id = $users_sub_to[$i]->id;
            $item->username = $users_sub_to[$i]->username;
            $item->img_path = $users_sub_to[$i]->img_path;
            $users_sub_to[$i] = $item;
        }
        $data->users_sub_to = $users_sub_to;
        $data->subscribed = !count(parent::_get(Subscription::class, ["subscriber_id" => Auth::user()->id, "subscribed_to_id" => $id])) == 0;

        $data->user->role = parent::_get(Role::class, ["id" => $data->user->role_id], true)->name;
        unset($data->user->password);
        $data->stories = parent::_getRelated(Story::class, "owner", ["user_id" => $data->user->id], withrelations:['genre', 'audience', 'state']);

        foreach ($data->stories as $value) {
            $value->genre = $value->genre->name;
            $value->audience = $value->audience->name;
            $value->state = $value->state->name;
        }

        $data->booklists = BookListController::getAllList();
        return view('Userpages.publicPage', [
            "data" => $data
        ]);
    }

    /**
     * Felülírja az adott felhasználó adatait.
     *
     * @param Request $request
     */
    public static function update(Request $request){
        $request = parent::StoreImg($request, 'user');
        parent::_update(User::class, Auth::user()->id, [
            'username' => $request->input('username'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'description' => $request->input('description'),
            'password' => Hash::make($request->input('password')),
        ]);
        return redirect()->route('getUserSettings', Auth::User()->id);
    }

    /**
     * Törli az adott felhasználót
     *
     */
    public static function remove(){
        parent::RemoveImg(Auth::user()->img_path, "location");
        $project_ids = parent::_get(Project::class, ["user_id" => Auth::user()->id], onlyColumns:['id']);
        foreach ($project_ids as $value) {
            ProjectController::removeProject($value->id);
        }
        parent::_destroy(User::class, ["id" => Auth::user()->id]);
    }
    public static function setLang($locale){
        if (!in_array($locale, ['en', 'hu'])) {
            abort(400);
        }
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        return redirect()->route('home');
    }
}
