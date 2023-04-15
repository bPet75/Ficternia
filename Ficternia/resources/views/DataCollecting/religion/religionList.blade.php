@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/religionList.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="listerContainer">
        <div class="newButtonContainer">
            <a href="{{route('newReligion' ,$data["projId"])}}" class="siteButton mediumMidSizeButton">{{ __('menu.new_rel') }}</a>
        </div>
        <div class="gridListContainer horizontalListerContainer">
            @foreach ($data->religions as $religion)
                <div class="objectCard horizontalCard">
                    <div class="objectInfoHolder horizontal">
                            <div class="objectName horizontal">{{$religion->name}}</div>
                            <div class="descriptionRow">
                                <div class="objectDescription">{{$religion->description != "" ? $religion->description:'N/A'}}</div>
                            </div>
                        </div>
                    <div class="objectControlButtonContainer horizontal">
                        <a href="" class="objectControlButton horizontal gridCenterText objectModalButton" data-bs-toggle="modal" data-bs-target="#">&#128065;</a>
                        <a href="{{ route('updateReligion', ['projId' => $data["projId"], 'id' => $religion->id]) }}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                        <a href="{{ route('removeReligion', ['projId' => $data["projId"], 'id' => $religion->id]) }}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection










{{--@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/religionList.css') }}" rel="stylesheet" type="text/css" >
    @endpush

    <div class=" w-100 gridContainer">
        <a class="card addNew" href="{{route('newReligion',$data["projId"])}}">
            <div class="card-body">
                <div class="plusSign alt">
                    
                </div>
            </div>
        </a>
        @foreach ($data->religions as $religion)
        
        <div class="card">
            <div class="card-header gridCardHeaderContainer">
                <div>
                    {{$religion->name}}
                </div>
                <div class="iconToRight">
                    <a href="" class="grid smallButton eye">&#128065;</a>
                    <a href="{{ route('updateReligion', ['projId' => $data["projId"], 'id' => $religion->id]) }}" class="grid smallButton pencil">&#128393;</a>
                    <a href="{{ route('removeReligion', ['projId' => $data["projId"], 'id' => $religion->id]) }}" class="grid smallButton trash">&#128465;</a>
                </div>
            </div>
            <div class="card-body">
                <div class="objectHolder">
                    <div class="religionInfoRow descRow">
                        <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                        <div class="objectDescription">{{$religion->description}}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection--}}