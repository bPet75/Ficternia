@extends('Planning.index')
@section('listerForPlanning')
    @push('styles')
        <link href="{{ asset('css/Planner/draftMaker.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/elements/makers.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <form action="{{isset($data->draft) ? route('UpdateDraft',['projId'=>$data["projId"], 'storyId' => $data["storyId"] ,'draftId'=>$data->draft->id]):route('saveDraft',['projId'=>$data["projId"], 'storyId' => $data["storyId"]]) }}" method="POST" class="gridRow">
        @csrf
        <div class="titleContainer">
            <input type="text" class="title titleInput" name="title" value="{{isset($data->draft) ? $data->draft->title:__('properties.title')}}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
        </div>
        
        <div class="gridRow bigInputContainer">
            <label for="synopsis" class="inputName">{{ __('properties.synopsis') }}</label>
            <textarea name="synopsis" rows="10" class="">{{isset($data->draft) ? $data->draft->synopsis : ''}}</textarea>
        </div>
        <div class="gridRow bigInputContainer">
            <label for="description" class="inputName">{{ __('properties.description') }}</label>
            <textarea name="description" rows="10" class="">{{isset($data->draft) ? $data->draft->body : ''}}</textarea>
        </div>
        @if(isset($data->draft))
        <div class="checkBoxContainer">
            <input type="checkbox" class="eventCheckbox" name="with_event" 
                value="true" data-bs-toggle="collapse" data-bs-target="#eventCollapse" {{is_null($data->chapter_event) ? '':'checked'}}/>
            <label for="with_event">{{ __('buttons.create_draft_event') }}</label>
        </div>
        <div class="gridTwoCol bigInputContainer">
            <div class="titleContainer">
                <label for="description" class="inputName">{{ __('properties.starting_time') }}</label>
                <input type="text" class="title" name="event_starting_time" value="{{!is_null($data->chapter_event) ? $data->chapter_event->starting_time:''}}">
            </div>
            <div class="titleContainer">
                <label for="description" class="inputName">{{ __('properties.ending_time') }}</label>
                <input type="text" class="title" name="event_ending_time" value="{{!is_null($data->chapter_event) ? $data->chapter_event->ending_time:''}}">
            </div>
        </div>
        <div class="gridRow bigInputContainer">
            <label for="event_description" class="inputName">{{ __('properties.description') }}</label>
            <textarea name="event_description" rows="10" class="">{{!is_null($data->chapter_event) ? $data->chapter_event->description : ''}}</textarea>
        </div>
        
        @endif
        <div class="buttonContainer">
            <button type="submit" class="siteButton midSizeButton">{{ __('buttons.save') }}</button>
        </div>
    </form>
@endsection


