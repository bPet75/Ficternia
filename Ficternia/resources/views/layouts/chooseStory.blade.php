@extends($data["extend"])
@section($data['section'])

@push('styles')
        <link href="{{ asset('css/storyList.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/Planner/storyForPlanning.css') }}" rel="stylesheet" type="text/css" >
@endpush
<div class="listerContainer">
    @if ($data["type"] == "datacollecting")
        <div class="newButtonContainer">
            <a href="{{route('newStory',$data["projId"])}}" class="siteButton mediumMidSizeButton">{{ __('menu.new_st') }}</a>
        </div>
    @endif
    <div class="gridListContainer">
        @foreach ($data->stories as $story)
            <div class="objectCard">
                @if ($data["type"] == "datacollecting")
                    <div class="objectControlButtonContainer">
                        <a href="" class="objectControlButton gridCenterText objectModalButton">&#128065;</a>
                        <a href="{{ route('updateStory', ['projId' => $data["projId"], 'id' => $story->id]) }}" class="objectControlButton gridCenterText updateButton">&#128393;</a>
                        <a href="{{ route('removeStory', ['projId' => $data["projId"], 'id' => $story->id]) }}" class="objectControlButton gridCenterText objectRemoveButton">&#128465;</a>
                    </div>
                @endif
                @if($data["type"] != "datacollecting")
                    <a href="{{$data["type"] == "planning" ? (route('GetDrafts',['projId'=>$data['projId'],'storyId'=>$story->id])):(route("openWritingIndex",['projId'=>$data['projId'],'storyId'=>$story->id]))}}" class="linkColorRemove">
                @endif
                <div class="imageContainer">
                    <img class="picture" src="{{$story->img_path != "" ? asset('images/story/'.$story->img_path):asset('images/default/default2.png') }}" alt="..." width="100%">
                </div>
                <div class="titleContainer">
                    <span class="storyTitle">~{{$story->title}}~</span>
                </div>
                @if ($data['type'] != "datacollecting")
            </a>
                @endif
            </div>
        @endforeach
    </div>
</div>




{{--
<div class="gridContainer">
    @if ($data["type"] == "datacollecting")
    <a class="card addNew addStory" href="{{route('newStory',$data["projId"])}}">
        <div class="card-body">
            <div class="plusSign alt">
                
            </div>
        </div>
    </a>
    @endif
    @foreach ($data->stories as $story)

    @if($data["type"] == "datacollecting")
    <div class="card">
        <div class="card-header gridCardHeaderContainer">
            <div>
                {{$story->title}}
            </div>
            <div class="iconToRight">
                <a href="" class="grid smallButton eye">&#128065;</a>
                <a href="{{ route('updateStory', ['projId' => $data["projId"], 'id' => $story->id]) }}" class="grid smallButton pencil">&#128393;</a>
                <a href="{{ route('removeStory', ['projId' => $data["projId"], 'id' => $story->id]) }}" class="grid smallButton trash">&#128465;</a>
            </div>
        </div>
        <div class="card-body">
            <div class="objectHolder storyHolder">
                <div class="pictureHolder"> 
                    @if ($story->img_path == "")
                    <img class="picture" src="{{ asset('images/default/default2.png') }}" alt="..." width="100%">
                    @else
                    <img class="picture" src="{{ asset('images/story/'.$story->img_path) }}" alt="..." width="100%">
                    @endif
                    </div>
                <div class="storyInfoRow">
                    <div class="storyInfoNameCol">{{ __('properties.genre') }}:</div>
                    <div class="">{{$story->genre_id}}</div>
                    <div class="storyInfoNameCol">{{ __('properties.audience') }}:</div>
                    <div class="">{{$story->audience_id}}</div>
                    <div class="storyInfoNameCol">{{ __('properties.status') }}:</div>
                    <div class="">{{$story->state_id}}</div>
                </div>
                <div class="storyInfoRow descRow">
                    <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                    <div class=" objectDescription">{{$story->description}}</div>
                </div>
            </div>
        </div>
    </div>
    @else
        
    <div class="card">
        <div class="card-header">
                {{$story->title}}
        </div>
        <a class="card-body" href="{{$data["type"] == "planning" ? (route('GetDrafts',['projId'=>$data['projId'],'storyId'=>$story->id])):(route("openWritingIndex",['projId'=>$data['projId'],'storyId'=>$story->id]))}}">
            <div class="objectHolder storyPlanHolder">
                <div class="pictureHolder"> 
                    @if ($story->img_path == "")
                    <img class="picture" src="{{ asset('images/default/default2.png') }}" alt="..." width="100%">
                    @else
                    <img class="picture" src="{{ asset('images/story/'.$story->img_path) }}" alt="..." width="100%">
                    @endif
                    </div>
                <div class="">
                    <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                    <div class=" objectDescription">{{$story->description}}</div>
                </div>
            </div>
        </a>
    </div>
    @endif
    @endforeach
    
</div>
--}}
@endsection