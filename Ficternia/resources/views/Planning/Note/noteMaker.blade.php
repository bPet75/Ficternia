@extends('Planning.index')
@section('listerForPlanning')
    @push('styles')
        <link href="{{ asset('css/religionMaker.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="gridContainer">
        {{$isNoteSet=false}}
        @if(!isset($data->note))
            <form action="{{ route('saveNote',[$data["projId"], 'storyId' => $data["storyId"]]) }}" method="POST">
        @else
            <div class="hide">{{$isNoteSet=true}}</div>
            <form action="{{ route('UpdateNote', ['projId'=>$data["projId"], 'storyId' => $data["storyId"] ,'noteId'=>$data->note->id]) }}" method="POST">
        @endif
            @csrf
        <div>
            <x-forms.textarea divClass="my-2 d-flex flex-column w-25" 
            class="formInputElement" name="body" label="{{ __('properties.body') }}" labelClass="h2 mb-3" rows="4" value="{{$isNoteSet ? $data->note->body : ''}}" />
        
        </div>
        <div>
            @if ($isNoteSet)
                @if($data->note->is_project_note == 1)
                    <x-forms.input divClass="my-2 d-flex flex-column w-25" class="checkbox" type="checkbox" 
                    name="is_project_note" value="true" label="{{ __('buttons.create_project_note') }}" labelClass="h3 mb-3 labelWidth" id="is_project_note" checked />
                @else
                    <x-forms.input divClass="my-2 d-flex flex-column w-25" class="checkbox" type="checkbox" 
                    name="is_project_note" value="true" label="{{ __('buttons.create_project_note') }}" labelClass="h3 mb-3 labelWidth" id="is_project_note" />
                @endif
            @else
            <x-forms.input divClass="my-2 d-flex flex-column w-25" class="checkbox" type="checkbox" 
            name="is_project_note" value="true" label="{{ __('buttons.create_project_note') }}" labelClass="h3 mb-3 labelWidth" id="is_project_note" />
        
            @endif
        </div>
            <div class="w-100 my-3">
                <button type="submit" class="btn btn-secondary w-25">{{ __('buttons.save') }}</button>
            </div>
        </form>
    </div>


@endsection