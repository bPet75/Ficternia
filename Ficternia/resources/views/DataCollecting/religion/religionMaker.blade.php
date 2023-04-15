@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/religionMaker.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="gridContainer">
        {{$isReligionSet=false}}
        @if(!isset($data->religion))
            <form action="{{ route('saveReligion',$data["projId"]) }}" method="POST">
        @else
            <div class="hide">{{$isReligionSet=true}}</div>
            <form action="{{ route('SaveUpdateReligion', ['projId'=>$data["projId"], 'id'=>$data->religion->id]) }}" method="POST">
        @endif
            @csrf
        <div>
            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
            class="formInput" name="name" label="{{ __('properties.name') }}" labelClass="h2 mb-3" type="text" value="{{$isReligionSet ? $data->religion->name : ''}}" />
        
        </div>
        <div>
            <x-forms.textarea divClass="my-2 d-flex flex-column w-25" 
            class="formInputElement" name="description" label="{{ __('properties.description') }}" labelClass="h2 mb-3" rows="4" value="{{$isReligionSet ? $data->religion->description : ''}}" />
        
        </div>
        
            <div class="w-100 my-3">
                <button type="submit" class="btn btn-secondary w-25">{{ __('buttons.save') }}</button>
            </div>
        </form>
    </div>


@endsection