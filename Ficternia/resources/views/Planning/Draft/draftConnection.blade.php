@extends('Planning.index')
@section('listerForPlanning')
    @push('styles')
        <link href="{{ asset('css/Planner/draftConnection.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="gridContainer">
        <form action="{{ route('saveDraftConnection',['projId'=>$data["projId"], 'storyId' => $data["storyId"] ,'draftId'=>$data->draft->id]) }}" method="POST">
        @csrf
            <div class="title">{{$data->draft->title}}</div>
            <div class="card collectionContainer">
                <div class="card-header gridCardHeaderContainer" data-bs-toggle="collapse" href="#collapse_characters" role="button">
                    <div class="collectionName" >
                        Karakterek
                    </div>
                </div>
            </div>
            <div class="draftCardContainer collapse" id="collapse_characters">
                @foreach ($data->characters as $character)
                <label class="draftCard">
                    <input type="checkbox" class="draftCardCheckbox" name="character_{{$character->id}}" id="character_{{$character->id}}" 
                    value="{{$character->id}}" {{$character->in_this_collection ? 'checked':''}}>
                    <span>{{$character->name}}</span>
                </label>
                @endforeach
            </div>
            <div class="card collectionContainer">
                <div class="card-header gridCardHeaderContainer" data-bs-toggle="collapse" href="#collapse_locations" role="button">
                    <div class="collectionName" >
                        Helyszínek
                    </div>
                </div>
            </div>
            <div class="draftCardContainer collapse" id="collapse_locations">
                @foreach ($data->locations as $location)
                <label class="draftCard">
                    <input type="checkbox" class="draftCardCheckbox" name="location_{{$location->id}}" id="location_{{$location->id}}" 
                    value="{{$location->id}}" {{$location->in_this_collection ? 'checked':''}}>
                    <span>{{$location->name}}</span>
                </label>
                @endforeach
            </div>
            <div class="card collectionContainer">
                <div class="card-header gridCardHeaderContainer" data-bs-toggle="collapse" href="#collapse_events" role="button">
                    <div class="collectionName" >
                        Események
                    </div>
                </div>
            </div>
            
            <div class="draftCardContainer collapse" id="collapse_events">
                @foreach ($data->events as $event)
                <label class="draftCard">
                    <input type="checkbox" class="draftCardCheckbox" name="event_{{$event->id}}" id="event_{{$event->id}}" 
                    value="{{$event->id}}" {{$event->in_this_collection ? 'checked':''}}>
                    <span>{{$event->name}}</span>
                </label>
                @endforeach
            </div>
            <div class="w-100 my-3">
                <button type="submit" class="btn btn-secondary w-25">Mentés</button>
            </div>
        </form>
    </div>


@endsection