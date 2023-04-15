<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use App\Http\Controllers\ConnectionController;
use App\Models\BookList;
use Illuminate\Support\Facades\Auth;
use App\Models\BooklistBook;
use Illuminate\Support\Collection;

class BookListController extends ConnectionController
{    
    /**
     * Adat lekérése könyvlista létrehozó oldalhoz.
     *
     */
    public static function CreateBooklist(){
        $data = new Collection();
        $data->available_visibilities = parent::getVisibilities();
        // return view("DataCollecting.event.eventMaker",[
        //     'data' => $data
        // ]);
    }
        
    /**
     * Könyvlista mentése
     *
     * @param  Request $request
     * @return void
     */
    public static function store(Request $request){
        parent::_store(BookList::class, [
            'user_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'visibility' => $request->input('visibility')
        ]);
        // return view("DataCollecting.event.eventMaker",[
        //     'data' => $data
        // ]);
    }
        
    /**
     * Sztori hozzáadása könyvlistához.
     *
     * @param  int $booklistId
     * @param  int $bookId
     */
    public static function AddToList($booklistId, $bookId){
        if(Auth::user()->id != parent::_get(Booklist::class, ["id" => $booklistId], onlyColumns:["user_id"])[0]->user_id){
            abort(403);
        }
        parent::_store(BooklistBook::class, [
            'booklist_id' => $booklistId,
            'book_id' => $bookId
        ]);
    }
        
    /**
     * Sztori törlése könyvlistából
     *
     * @param  int $booklistId
     * @param  int $bookId
     */
    public static function RemoveFromList($booklistId, $bookId){
        if(Auth::user()->id != parent::_get(Booklist::class, ["id" => $booklistId], onlyColumns:["user_id"])[0]->user_id){
            abort(403);
        }
        parent::_destroy(BooklistBook::class, [
            'booklist_id' => $booklistId,
            'book_id' => $bookId
        ]);
    }
        
    /**
     * Könyvlista törlése.
     *
     * @param  int $id
     */
    public static function remove($id){
        if(Auth::user()->id != parent::_get(Booklist::class, ["id" => $id], onlyColumns:["user_id"])[0]->user_id){
            abort(403);
        }
        parent::_destroy(BookList::class, ["id" => $id]);
    }
        
    /**
     * Egy felhasználó összes könyvlistájának lekérése
     *
     * @return array
     */
    public static function getAllList(){
        $data = parent::_get(BookList::class, ["user_id" => Auth::user()->id]);
        $booklists = [];
        foreach ($data as $value) {
            $book_ids = parent::_get(BooklistBook::class, ["booklist_id" => $value->id], onlyColumns:['book_id'], limit: 3);
            for ($i=0; $i < count($book_ids); $i++) { 
                $book_ids[$i] = parent::_get(Story::class, ["id" => $book_ids[$i]->book_id], true, withrelations:["genre", "audience", "state"]);
                $book_ids[$i]->genre = $book_ids[$i]->genre->name;
                $book_ids[$i]->audience = $book_ids[$i]->audience->name;
                $book_ids[$i]->state = $book_ids[$i]->state->name;
            }
            $value->books = $book_ids;

        }
        return $data;
    }
        
    /**
     * Egy lista összes könyvének lekérése.
     *
     * @param  int $blId
     * @return Collection
     */
    public static function getListElements($blId){
        if(Auth::user()->id != parent::_get(Booklist::class, ["id" => $blId], onlyColumns:["user_id"])[0]->user_id){
            abort(403);
        }
        $book_ids = parent::_get(BooklistBook::class, ["booklist_id"], onlyColumns:["book_id"]);
        $data = new Collection();
        $data->books = [];
        foreach ($book_ids as $value) {
            $item = parent::_get(Story::class, ["id" => $value->book_id], true, ["genre", "audience", "state"]);
            $item->genre = $item->genre->name;
            $item->audience = $item->audience->name;
            $item->state = $item->state->name;
            array_push($data->books, $item);
        }
        return $data;
    }
}
