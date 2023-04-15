@extends('main')
@push('styles')
        <link href="{{ asset('css/writingIndex.css') }}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
<div class="pageContainer">
    <div class="titleContainer">
        <div class="title">
            ~{{$data->story->title}}~
        </div>
        @if ($data->i_am_admin)
            <div class="hideButtonBontainer">
                <a href="{{route('hideStory', ['storyId' => $data->story->id])}}" class="sitebutton controlButton">Történet elrejtése</a>
            </div>
        @endif
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
            <a href="{{route('userPage', ['userId' => $data->owner->id])}}" class="userName">{{$data->owner->username}}</a>
           
            <div class="descContainer">
                {{$data->story->description}}
            </div>
        </div>
        <div class="storyStuffContainer">
            <div class="storyStuffContainer">
                <div class="chapterListContainer">
                    <div class="chapterListInner">
                        @foreach($data->chapters as $chapter)
                        @if (!$loop->first)
                        @endif
                            <a href="{{ route('chapterPage', ['storyId' => $data->story->id, 'chId'=>$chapter->id, 'is_last'=> $chapter->is_last ? '1':'0']) }}" class="chapterElementContainer readPage nonDraggable">
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
                                            <div>{{ __('properties.created_at') }}: {{date('Y-m-d H:m',strtotime($chapter->created_at))}}</div>
                                            <div>{{ __('properties.updated_at') }}: {{date('Y-m-d H:m',strtotime($chapter->updated_at))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection