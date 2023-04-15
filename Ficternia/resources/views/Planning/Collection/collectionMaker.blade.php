@extends('Planning.index')
@section('listerForPlanning')
    @push('styles')
        <link href="{{ asset('css/Planner/collectionMaker.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="gridContainer">
        {{$isCollectionSet=false}}
        @if(!isset($data->collection))
            <form action="{{ route('saveCollection',['projId' => $data["projId"], 'storyId' => $data["storyId"] ]) }}" method="POST">
        @else
            <div class="hide">{{$isCollectionSet=true}}</div>
            <form action="{{ route('UpdateCollection', ['projId'=>$data["projId"], 'storyId' => $data["storyId"], 'collectionId'=>$data->collection->id]) }}" method="POST">
        @endif
            @csrf
        <div class="nameContainer">
            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
            class="formInput" name="name" label="{{__('Gyűjtemény neve')}}" labelClass="h2 mb-3" type="text" value="{{$isCollectionSet ? $data->collection->name : ''}}" />
            <div class="colorPickerContainer">
                <x-forms.input divClass="my-2 d-flex flex-column" class="" name="color" label="{{__('Gyűjtemény színe')}}" 
                labelClass="h2 mb-3" type="color" value="{{$isCollectionSet ? $data->collection->color : ''}}" />
            </div>
        </div>
        <div class="draftCardContainer">
            @foreach ($data->avilable_drafts as $draft)
            <label class="draftCard">
                <input type="checkbox" class="draftCardCheckbox" name="draft_{{$draft["id"]}}" id="draft_{{$draft["id"]}}" 
                value="{{$draft["id"]}}" {{$isCollectionSet ? ($draft["in_this_collection"] ? 'checked':''):''}}>
                <span>{{$draft["title"]}}</span>
            </label>
            @endforeach
        </div>
            <div class="w-100 my-3">
                <button type="submit" class="btn btn-secondary w-25">Mentés</button>
            </div>
        </form>
    </div>


@endsection