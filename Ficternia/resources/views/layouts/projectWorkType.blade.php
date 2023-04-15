@extends('main')
@section('content')
@push('styles')
        <link href="{{ asset('css/projectWorkType.css') }}" rel="stylesheet" type="text/css" >
@endpush
<div class="bgColor mt-4">
    <div class="buttonContainer">
        <div class="buttonHolder"><a class="btn btn-secondary workTypeButton" href="{{route('chooseProject', ["type"=>"datacollecting"])}}">{{ __('buttons.building') }}</a></div>
        <div class="buttonHolder"><a class="btn btn-secondary workTypeButton" href="{{route('chooseProject', ["type"=>"planning"])}}">{{ __('buttons.planning') }}</a></div>
        <div class="buttonHolder"><a class="btn btn-secondary workTypeButton" href="{{route('chooseProject', ["type"=>"writing"])}}">{{ __('buttons.writing') }}</a></div>
    </div>
</div>
@endsection