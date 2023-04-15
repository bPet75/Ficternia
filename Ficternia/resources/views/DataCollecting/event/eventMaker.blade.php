@extends('DataCollecting.index')
@section('lister')
@push('styles')
    <link href="{{ asset('css/eventMaker.css') }}" rel="stylesheet" type="text/css" >
@endpush
{{$isEventSet=false}}

@if(!isset($data->event))
    <form action="{{ route('saveEvent', $data["projId"]) }}" method="POST">
@else
<div class="hide">{{$isEventSet=true}}</div>
<form action="{{ route('SaveUpdateEvent', ['projId'=>$data["projId"], 'id'=>$data->event[0]->id]) }}" method="POST" enctype="multipart/form-data">
@endif
        @csrf
        <div class="gridContainer">
            <div class="eventFormElement">
                <div class="my-2 d-flex flex-column w-25">
                    <label class="h3 mb-3 labelWidth" for="name">{{ __('properties.name') }}</label>
                    <input type="text" class="formInput" name="name" value="{{$isEventSet ? $data->event[0]->name : ''}}" 
                    {{$isEventSet ? ($data->event[0]->type == "chapter" ? 'disabled':''):''}}>
                </div>
                
            </div>
            <div class="eventFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="starting_time" label="{{ __('properties.starting_time') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isEventSet ? $data->event[0]->starting_time : ''}}" />
            </div>
            <div class="eventFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="ending_time" label="{{ __('properties.ending_time') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isEventSet ? $data->event[0]->ending_time : ''}}" />
            </div>
            <div class="eventFormElement">
                <x-forms.textarea divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="description" label="{{ __('properties.description') }}" labelClass="h3 mb-3 labelWidth" rows="4" value="{{$isEventSet ? $data->event[0]->description : ''}}" />
            </div>
            <div class="eventFormElement">
                <label for="type">{{ __('properties.type') }}</label>
                <select name="type" id="typeSelector" {{$isEventSet ? ($data->event[0]->type == 'chapter' ? 'disabled':''):''}}>
                    <option value="default" {{$isEventSet ? ($data->event[0]->type == 'default' ? 'selected':''):''}}>{{ __('properties.type_basic') }}</option>
                    <option value="status" {{$isEventSet ? ($data->event[0]->type == 'status' ? 'selected':''):''}}>{{ __('properties.type_status') }}</option>
                    <option value="chapter" disabled {{$isEventSet ? ($data->event[0]->type == 'chapter' ? 'selected':''):''}}>{{ __('properties.type_chapter') }}</option>
                </select>
            </div>
            <div class="eventFormElement">
                <label for="parent_id">{{ __('properties.parent') }}</label>
                <select name="parent_id" id="majorEventSelector" {{$isEventSet ? ($data->event[0]->type == 'chapter' ? 'disabled':''):''}}>
                    <option value="0"></option>
                    @foreach($data->major_events as $key => $eventName)
                        <option value="{{$key}}" {{$isEventSet ? ($key == $data->event[0]->parent_id ? 'selected':''):''}}>
                            {{$data->major_events[$key]}}</option>
                    @endforeach
                </select>
            </div>
            <div class="eventFormElement">
                @foreach(array_keys($data->stories) as $storyID)
                    @if(isset($data->inStory))
                        @if(in_array($storyID, array_keys($data->inStory)))
                            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                            class="checkbox " checked type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                        @else
                            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                            class="checkbox " type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                        @endif
                    @else
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="checkbox" type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                    @endif                
                @endforeach                
            </div>
            <div class="d-flex justify-content-center w-100 my-3">
                <button type="submit" class="btn btn-secondary w-50">{{ __('buttons.save') }}</button>
            </div>
        </div>
    </form>


@endsection