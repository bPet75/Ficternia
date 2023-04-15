@extends('main')
@section('content')
    @push('styles')
        <link href="{{ asset('css/elements/makers.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <form action="{{ isset($data) ? route('SaveUpdateProject',$data->id):route('saveProject') }}" method="POST" class="gridRow">
        @csrf
        <div class="titleContainer">
            <input type="text" class="title titleInput" name="name" value="{{isset($data->name) ? $data->name:__('properties.title')}}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
        </div>
        <div class="gridRow bigInputContainer">
            <label for="description" class="inputName">{{ __('properties.description') }}</label>
            <textarea name="description" rows="10" class="">{{isset($data->description) ? $data->description:''}}</textarea>
        </div>
        <div class="buttonContainer">
            <button type="submit" class="siteButton midSizeButton">{{ __('buttons.save') }}</button>
        </div>
    </form>
@endsection