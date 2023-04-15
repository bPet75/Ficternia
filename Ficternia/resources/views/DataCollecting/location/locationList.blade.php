@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/locationList.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="listerContainer">
        <div class="newButtonContainer">
            <a href="{{route('newLocation' ,$data["projId"])}}" class="siteButton mediumMidSizeButton">{{ __('menu.new_loc') }}</a>
        </div>
        <div class="gridListContainer">
            @foreach ($data->locations as $location)
            <div class="objectCard">
                <div class="objectControlButtonContainer">
                    <a href="" class="objectControlButton gridCenterText objectModalButton" data-bs-toggle="modal" data-bs-target="#">&#128065;</a>
                    <a href="{{ route('updateLocation', ['projId' => $data["projId"], 'id' => $location->id]) }}" class="objectControlButton gridCenterText updateButton">&#128393;</a>
                    <a href="{{ route('removeLocation', ['projId' => $data["projId"], 'id' => $location->id]) }}" class="objectControlButton gridCenterText objectRemoveButton">&#128465;</a>
                </div>
                <div class="objectHolder">
                    <div class="imageContainer">
                        <img class="picture" src="{{$location->img_path != "" ? asset('images/location/'.$location->img_path):asset('images/default/default2.png') }}" alt="..." width="100%">
                    </div>
                    <div class="objectInfoHolder">
                        <div class="objectName">{{$location->name}}</div>
                        <div class="twoObjectInfo">
                            <div>{{ __('properties.state') }}: {{$location->state != "" ? $location->state:'N/A'}}</div>
                            <div>{{ __('properties.ruler') }}: {{$location->ruler != "" ? $location->ruler:'N/A'}}</div>
                        </div>
                        <div class="descriptionRow">
                            <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                            <div class="objectDescription">{{$location->description != "" ? $location->description:'N/A'}}</div>
                        </div>
                    </div>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>


@endsection