<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Objects\ReligionController;
use App\Http\Controllers\Objects\StoryController;
use App\Http\Controllers\Objects\LocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Objects\CharacterController;
use App\Http\Controllers\Objects\EventController;
use App\Http\Controllers\Objects\DraftController;
use App\Http\Controllers\Objects\NoteController;
use App\Http\Controllers\Objects\CollectionController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\BookListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();



Route::get('/', [ReadingController::class, 'getAllStoriesForReading'])->name('home')->middleware('auth')->middleware('lang');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/test/{id}', [ProjectController::class, 'getAllMajorEvents']);
Route::get('/setLang/{lang}', [UserController::class, 'setLang'])->name('setLanguage');

//Route::get('/test/{id}', [App\Http\Controllers\CharacterController::class, 'getAllMajorEventsByCharacter']);


/*
|--------------------------------------------------------------------------
| PROJECT SITE
|--------------------------------------------------------------------------
|
 */


Route::get('/WorkType', [UserController::class, 'isHaveProject'])->name('workType')->middleware('auth')->middleware('lang');



//-------------------------------------------DATA COLLECTING-------------------------------------------

//Project CRUD
Route::get('/MyProjects/NewProject', [ProjectController::class, 'createProject'])->name('newProject')->middleware('auth')->middleware('lang');
Route::Post('/MyProjects/NewProject', [ProjectController::class, 'store'])->name('saveProject')->middleware('auth')->middleware('lang');
Route::get('/MyProjects/UpdateProject/{id}', [ProjectController::class, 'getProjectForUpdate'])->name('updateProject')->middleware('auth')->middleware('lang');
Route::Post('/MyProjects/UpdateProject/{id}', [ProjectController::class, 'updateProject'])->name('SaveUpdateProject')->middleware('auth')->middleware('lang');
Route::get('/MyProjects/removeProject/{id}', [ProjectController::class, 'removeProject'])->name('removeProject')->middleware('auth')->middleware('lang');

//Listings
Route::get('/{projId}/DataCollecting/stories', [ProjectController::class, 'getAllStories'])->name('stories')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/religions', [ProjectController::class, 'getAllReligions'])->name('religions')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/characters', [ProjectController::class, 'getAllCharacters'])->name('characters')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/locations', [ProjectController::class, 'getAllLocations'])->name('locations')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/events', [ProjectController::class, 'getAllEvents'])->name('events')->middleware('auth')->middleware('lang');

//Creating Editing Removing

Route::get('/{projId}/DataCollecting/NewStory', [StoryController::class, 'CreateStory'])->name('newStory')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/NewStory', [StoryController::class, 'store'])->name('saveStory')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/UpdateStory/{id}', [StoryController::class, 'getStoryForUpdate'])->name('updateStory')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/UpdateStory/{id}', [StoryController::class, 'update'])->name('SaveUpdateStory')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/RemoveStory/{id}', [StoryController::class, 'removeStory'])->name('removeStory')->middleware('auth')->middleware('lang');

Route::get('/{projId}/DataCollecting/NewCharacter', [CharacterController::class, 'CreateCharacter'])->name('newCharacter')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/NewCharacter', [CharacterController::class, 'store'])->name('saveCharacter')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/UpdateCharacter/{id}', [CharacterController::class, 'getCharacterForUpdate'])->name('updateCharacter')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/UpdateCharacter/{id}', [CharacterController::class, 'updateCharacter'])->name('SaveUpdateCharacter')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/RemoveCharacter/{id}', [CharacterController::class, 'removeCharacter'])->name('removeCharacter')->middleware('auth')->middleware('lang');

Route::get('/{projId}/DataCollecting/NewLocation', [LocationController::class, 'CreateLocation'])->name('newLocation')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/NewLocation', [LocationController::class, 'store'])->name('saveLocation')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/UpdateLocation/{id}', [LocationController::class, 'getLocationForUpdate'])->name('updateLocation')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/UpdateLocation/{id}', [LocationController::class, 'updateLocation'])->name('SaveUpdateLocation')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/RemoveLocation/{id}', [LocationController::class, 'removeLocation'])->name('removeLocation')->middleware('auth')->middleware('lang');

Route::get('/{projId}/DataCollecting/NewReligion', [ReligionController::class, 'CreateReligion'])->name('newReligion')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/NewReligion', [ReligionController::class, 'store'])->name('saveReligion')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/UpdateReligion/{id}', [ReligionController::class, 'getReligionForUpdate'])->name('updateReligion')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/UpdateReligion/{id}', [ReligionController::class, 'updateReligion'])->name('SaveUpdateReligion')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/RemoveReligion/{id}', [ReligionController::class, 'removeReligion'])->name('removeReligion')->middleware('auth')->middleware('lang');

Route::get('/{projId}/DataCollecting/NewEvent', [EventController::class, 'CreateEvent'])->name('newEvent')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/NewEvent', [EventController::class, 'store'])->name('saveEvent')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/UpdateEvent/{id}/{type}', [EventController::class, 'getEventForUpdate'])->name('updateEvent')->middleware('auth')->middleware('lang');
Route::Post('/{projId}/DataCollecting/UpdateEvent/{id}', [EventController::class, 'updateEvent'])->name('SaveUpdateEvent')->middleware('auth')->middleware('lang');
Route::get('/{projId}/DataCollecting/RemoveEvent/{id}', [EventController::class, 'removeEvent'])->name('removeEvent')->middleware('auth')->middleware('lang');

//-----------------------------------------DATA COLLECTING END---------------------------------------------------

//-----------------------------------------------PLANNING--------------------------------------------------------

Route::get('/{type}/Projects', [UserController::class, 'getAllProjects'])->name('chooseProject')->middleware('auth')->middleware('lang');
Route::get('/{type}/{id}/Stories', [ProjectController::class, 'getAllStories'])->name('chooseStory')->middleware('auth')->middleware('lang');


Route::get('/planning/{projId}/{storyId}/Draft', [StoryController::class, 'getAllDrafts'])->name('GetDrafts')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Draft/Result', [StoryController::class, 'filterDrafts'])->name('filterDrafts')->middleware('auth')->middleware('lang');

Route::get('/planning/{projId}/{storyId}/Draft/NewDraft', [DraftController::class, 'createDraft'])->name('addDraft')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Draft/NewDraft', [DraftController::class, 'store'])->name('saveDraft')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Draft/{draftId}/{onlyparts}/Connections', [DraftController::class, 'GetDraftForConnect'])->name("draftConnections")->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Draft/{draftId}/Connections', [DraftController::class, 'updateConnection'])->name('saveDraftConnection')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Draft/{draftId}', [DraftController::class, 'GetDraftForUpdate'])->name('getDraftForUpdate')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Draft/{draftId}', [DraftController::class, 'update'])->name('UpdateDraft')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Draft/Remove/{draftId}', [DraftController::class, 'removeDraft'])->name('removeDraft')->middleware('auth')->middleware('lang');

Route::get('/planning/{projId}/{storyId}/Note', [StoryController::class, 'getAllNotes'])->name('GetNotes')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Note/NewNote', [NoteController::class, 'createNote'])->name('addNote')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Note/NewNote', [NoteController::class, 'store'])->name('saveNote')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Note/{noteId}', [NoteController::class, 'GetNoteForUpdate'])->name('getNoteForUpdate')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Note/{noteId}', [NoteController::class, 'update'])->name('UpdateNote')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Note/Remove/{noteId}', [NoteController::class, 'removeNote'])->name('removeNote')->middleware('auth')->middleware('lang');

Route::get('/planning/{projId}/{storyId}/Collection', [StoryController::class, 'getAllCollections'])->name('GetCollections')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Collection/NewCollection', [CollectionController::class, 'createCollection'])->name('addCollection')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Collection/NewCollection', [CollectionController::class, 'store'])->name('saveCollection')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Collection/{collectionId}', [CollectionController::class, 'GetCollectionForUpdate'])->name('getCollectionForUpdate')->middleware('auth')->middleware('lang');
Route::Post('/planning/{projId}/{storyId}/Collection/{collectionId}', [CollectionController::class, 'update'])->name('UpdateCollection')->middleware('auth')->middleware('lang');
Route::get('/planning/{projId}/{storyId}/Collection/Remove/{collectionId}', [CollectionController::class, 'removeCollection'])->name('removeCollection')->middleware('auth')->middleware('lang');

//---------------------------------------------PLANNING END------------------------------------------------------

//---------------------------------------------WRITING START------------------------------------------------------


Route::get('/Writing/{projId}/{storyId}/', [StoryController::class, 'getAllDraftsForWriting'])->name('openWritingIndex')->middleware('auth')->middleware('lang');
Route::Post('/Writing/{projId}/{storyId}/', [ChapterController::class, 'chapterModifySwitch'])->name('operation')->middleware('auth')->middleware('lang');
Route::Post('/Writing/{projId}/{storyId}/visibility', [StoryController::class, 'ChangeVisibility'])->name('changeStoryVisibility')->middleware('auth')->middleware('lang');

Route::get('/Writing/{projId}/{storyId}/{id}', [ChapterController::class, 'createChapter'])->name('writeChapter')->middleware('auth')->middleware('lang');
Route::Post('/Writing/{projId}/{storyId}/{id}', [ChapterController::class, 'store'])->name('saveChapter')->middleware('auth')->middleware('lang');
Route::get('/Writing/{projId}/{storyId}/Update/{id}', [ChapterController::class, 'GetChapterForUpdate'])->name('getChapterForUpdate')->middleware('auth')->middleware('lang');
Route::Post('/Writing/{projId}/{storyId}/Update/{id}', [ChapterController::class, 'update'])->name('updateChapter')->middleware('auth')->middleware('lang');
Route::get('/Writing/{projId}/{storyId}/Remove/{id}', [ChapterController::class, 'removeChapter'])->name('removeChapter')->middleware('auth')->middleware('lang');
//---------------------------------------------WRITING END------------------------------------------------------

//---------------------------------------------BROWSING START------------------------------------------------------
Route::get('/Browse/{storyId}', [ReadingController::class, 'getStoryForReading'])->name('storyPage')->middleware('auth')->middleware('lang');
Route::get('/Browse/{storyId}/hide', [StoryController::class, 'hideStory'])->name('hideStory')->middleware('auth')->middleware('lang');
Route::Post('/Browse/{storyId}', [SubscriptionController::class, 'setSubscription'])->name('setSubscription')->middleware('auth')->middleware('lang');
Route::get('/Browse/{storyId}/{chId}/{is_last}', [ReadingController::class, 'getChapterForReading'])->name('chapterPage')->middleware('auth')->middleware('lang');
Route::get('/Browse/{storyId}/{chId}/hide', [ReadingController::class, 'hideChapter'])->name('hideChapter')->middleware('auth')->middleware('lang');
Route::Post('/Browse/{storyId}/{chId}/{parentId}/{is_last}', [CommentController::class, 'store'])->name('saveComment')->middleware('auth')->middleware('lang');
Route::Post('/Browse/{storyId}/{chId}/{commentId}/remove', [CommentController::class, 'removeComment'])->name('removeComment')->middleware('auth')->middleware('lang');

//---------------------------------------------BROWSING END------------------------------------------------------

Route::get('/MyPage', [BookListController::class, 'getAllList'])->name('myBookLists')->middleware('auth')->middleware('lang');
Route::get('/userPage/{userId}', [UserController::class, 'getUser'])->name('userPage')->middleware('auth')->middleware('lang');
Route::Post('/userPage/{userId}', [SubscriptionController::class, 'setSubscription'])->name('userPage')->middleware('auth')->middleware('lang');
Route::Post('/Results', [ReadingController::class, 'getStoriesFiltered'])->name('filterStories')->middleware('auth')->middleware('lang');
Route::get('/Settings/{id}', [UserController::class, 'getUser'])->name('getUserSettings')->middleware('auth')->middleware('lang');
Route::Post('/Settings/{id}', [UserController::class, 'update'])->name('updateUser')->middleware('auth')->middleware('lang');




Route::get('/{projId}/timeline', [ProjectController::class, 'assembleTimeline'])->name('timeline');