@extends('main')
@push('styles')
        <link href="{{ asset('css/writingIndex.css') }}" rel="stylesheet" type="text/css" >
@endpush
@push('scripts')
    <script src="{{ asset('js/chapterMove.js') }}" defer></script>
@endpush
@section('content')
{{--dd($data)--}}
<div class="pageContainer">
    <div class="titleContainer">
        <div class="title">
            ~{{$data->story->title}}~
        </div>
    </div>
    <div class="splitPageContainer">
        <div class="infoContainer">
            <div class="imageAndMetaContainer">
                <div class="imageContainer">
                    <img src="{{ asset('images/story/'.$data->story->img_path) }}" alt="...">
                </div>
                <div class="metaContainer">
                    <div class="infoName">{{ __('properties.visibility') }}:</div>
                    <div class="infoValue">{{$data->story->visibility}}</div>
                    <div class="infoName">{{ __('properties.status') }}:</div>
                    <div class="infoValue">{{$data->story->state}}</div>
                    <div class="infoName">{{ __('properties.genre') }}:</div>
                    <div class="infoValue">{{$data->story->genre}}</div>
                    <div class="infoName">{{ __('properties.audience') }}:</div>
                    <div class="infoValue">{{$data->story->audience}}</div>
                    <div class="infoName">{{ __('properties.views') }}:</div>
                    <div class="infoValue">{{$data->story->views}}</div>
                    <div class="infoName">{{ __('properties.rating') }}:</div>
                    <div class="infoValue">{{$data->rating["avg"]}} / 5 &#9734;</div>
                </div>
            </div>
            <form action="{{route('changeStoryVisibility', ['projId'=>$data["projId"], 'storyId' => $data["storyId"]])}}" method="POST" class="controlButtonsInnerContainer publicityButtonContainer">
                @csrf
                <select name="visibility" id="">
                    @foreach ($data->visibilities as $key => $value)
                        <option value="{{$value}}" {{$data->story->visibility == $value ? 'selected':''}}>{{$value}}</option>
                    @endforeach
                </select>
                <button type="submit">asdasd</button>
            </form>
            <div class="descContainer">
                {{$data->story->description}}
            </div>
        </div>
        <div class="storyStuffContainer">
            <div class="newChapterButtonContainer">
                <button type="button" class="siteButton midSizeButton" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ __('buttons.create_new_chapter') }}
                </button>
            </div>
            <form action="{{route('operation',['projId'=>$data["projId"], 'storyId' => $data["storyId"]])}}" method="post" class="storyStuffContainer">
                @csrf
                <div class="controlButtonsContainer">
                    <div class="controlButtonsInnerContainer">
                        <button type="submit" name="subButton" value="publish" class="siteButton controlButton normControlButton">{{ __('buttons.set_to_public') }}</button>
                        <button type="submit" name="subButton" value="unpublish" class="siteButton controlButton normControlButton">{{ __('buttons.set_to_private') }}</button>
                        <button type="submit" name="subButton" value="unlist" class="siteButton controlButton normControlButton">{{ __('buttons.set_to_unlisted') }}</button>
                        <button type="submit" name="subButton" value="update" class="siteButton controlButton normControlButton">{{ __('buttons.modify') }}</button>
                        <button type="submit" name="subButton" value="delete" class="siteButton controlButton normControlButton">{{ __('buttons.delete') }}</button>
                        <button type="button" onClick="allowMoving()" class="siteButton controlButton" id="reorderButton">{{ __('buttons.reorder') }}</button>
                        <button type="submit" name="subButton" value="reorder" class="siteButton controlButton hide saveOrder" id="saveOrder" disabled>{{ __('buttons.reorder_save') }}</button>
                    </div>
                </div>
                <div class="chapterListContainer">
                    <div class="chapterListInner">
                        @foreach($data->chapters as $chapter)
                        @if (!$loop->first)
                        @endif
                        <div class="chapterElementContainer nonDraggable" draggable="false">
                                <div class="separator"></div>
                                <div class="chapterElement">
                                    <div class="chapterElementGrabberContainer">
                                        &#8597;
                                    </div>
                                    <div class="chapterElementMiddleContainer">
                                        <div class="chapterElementUpper">
                                            <div class="chapterTitle">
                                                {{$chapter->title}}
                                            </div> 
                                        </div>
                                        <div class="chapterElementLower">
                                            <div>{{ __('properties.visibility') }}: {{$chapter->visibility}}</div>
                                            <div>{{ __('properties.created_at') }}: {{date('Y-m-d H:m',strtotime($chapter->created_at))}}</div>
                                            <div>{{ __('properties.updated_at') }}: {{date('Y-m-d H:m',strtotime($chapter->updated_at))}}</div>
                                            <div>
                                                &#128065; : {{$chapter->views}}
                                            </div>
                                            <div>
                                                &#x1F4AC; : {{$chapter->comments}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="commentChecker">
                                        <input type="checkbox" class="checkbox" name="chapter_{{$chapter->id}}" value="{{$chapter->id}}_{{$chapter->serial}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('menu.choose_draft') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body draftContainer">
            @foreach ($data->drafts as $draft)
                @if (!$draft->have_chapter)
                    <a href="{{route("writeChapter", ["projId" => $data["projId"], "storyId" => $data["storyId"], "id"=>$draft->id, "onlyparts"=>true])}}" class="draft">{{$draft->title}}</a>
                    <div class="horizLine"></div>
                @endif
            @endforeach
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>


{{--
    <div class="writingIndexContainer">
        <div class="storyInfoContainer">
            <div class="storyCover">
                <img src="{{ asset('images/story/'.$data->story->img_path) }}" alt="..." width="325" height="450">
            </div>
            <div class="storyTitle">
                <span class="title">{{$data->story->title}}</span>
            </div>
            <form class="share">
            </form>
            <div class="storyDescription">
                <span class="description">{{$data->story->description}}</span>
            </div>
        </div>
        <div class="chapterListAndDraftButtonContainer">
            <div class="buttonContainer">
                    {{ __('buttons.create_new_chapter') }}
            </div>
            <div class="chapterCardContainer">
                @foreach ($data->chapters as $chapter)    
                    <div class="chapterRow">
                        <div class="chapterName">
                            {{$chapter->title}}
                        </div>
                        <div class="iconToRight">
                            <a href="" class="grid smallButton eye">&#128065;</a>
                            <a href="{{route('getChapterForUpdate', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'id' => $chapter->id] )}}" class="grid smallButton pencil">&#128393;</a>
                            <a href="{{route('removeChapter', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'id' => $chapter->id])}}" class="grid smallButton trash">&#128465;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal -->
    
--}}
@endsection