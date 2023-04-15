@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/eventList.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="listerContainer">
        <div class="newButtonContainer">
            <a href="{{route('newCharacter' ,$data["projId"])}}" class="siteButton mediumMidSizeButton">{{ __('menu.new_ev') }}</a>
        </div>
        <div class="gridListContainer horizontalListerContainer">
            @each('components.partials.eventCard', $data->events, 'event')
           
        </div>
    </div>
@endsection
        
