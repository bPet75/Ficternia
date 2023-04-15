@extends('main')
@section('content')
@push('styles')
    <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/projectList.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/elements/datacollecting.css') }}" rel="stylesheet" type="text/css" >
@endpush



<div class="listerContainer">
    @if ($data["type"] == "datacollecting")
        <div class="newButtonContainer">
            <a href="{{route('newProject')}}" class="siteButton mediumMidSizeButton">Új project</a>
        </div>
    @endif
    <div class="gridListContainer">
        @foreach ($data->projects as $project)
            <div class="objectCard">
                <a href="{{$data["type"] == "planning" ? (route('chooseStory', ["type" => "planning", "id" =>$project->id])):($data["type"] == "datacollecting" ? route('chooseStory',["type"=>"datacollecting","id" =>$project->id]) : route('chooseStory',["type"=>"writing","id" =>$project->id]))}}" class="titleDescContiner linkColorRemove">
                    <div class="titleContainer">
                        <span class="storyTitle">~{{$project->name}}~</span>
                    </div>
                    <div class="descriptionContainer">
                        {{$project->description}}
                    </div>
                </a>
                @if ($data["type"] == "datacollecting")
                    <div class="objectControlButtonContainer horizontal">
                        <a href="" class="objectControlButton horizontal gridCenterText objectModalButton" data-bs-toggle="modal" data-bs-target="#projectModal{{$project->id}}">&#128065;</a>
                        <a href="{{ route('updateProject', $project->id) }}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                        <a href="{{ route('removeProject', ['id' => $project->id]) }}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@foreach ($data->projects as $project)
    <div class="modal fade" id="projectModal{{$project->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{$project->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{$project->description}}
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
@endforeach
@endsection