@extends('DataCollecting.index')
@section('lister')
    @push('styles')

        <link href="{{ asset('css/characterList.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="listerContainer">
        <div class="newButtonContainer">
            <a href="{{route('newCharacter' ,$data["projId"])}}" class="siteButton mediumMidSizeButton">{{ __('menu.new_ch') }}</a>
        </div>
        <div class="gridListContainer horizontalListerContainer">
            @foreach ($data->characters as $chara)
                <div class="objectCard horizontalCard">
                    <div class="objectHolder horizontal">
                        <div class="imageContainer characterImage">
                            <img class="picture" src="{{$chara->img_path != "" ? asset('images/character/'.$chara->img_path):asset('images/default/default2.png') }}" alt="..." width="100%">
                        </div>
                        <div class="objectInfoHolder horizontal">
                            <div class="objectName horizontal">{{$chara->name}}</div>
                            <div class="twoObjectInfo">
                                <div>{{ __('properties.species') }}: {{isset($chara->properties["species"]) ? $chara->properties["species"]:'N/A'}}</div>
                                <div>{{ __('properties.age') }}: {{isset($chara->properties["age"]) ? $chara->properties["age"]:'N/A'}}</div>
                            </div>
                            <div class="descriptionRow">
                                <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                <div class="objectDescription">{{isset($chara->properties["description"]) ? $chara->properties["description"]:'N/A'}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="objectControlButtonContainer horizontal">
                        <a href="" class="objectControlButton horizontal gridCenterText objectModalButton" data-bs-toggle="modal" data-bs-target="#">&#128065;</a>
                        <a href="{{ route('updateCharacter', ['projId' => $data["projId"], 'id' => $chara->id]) }}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                        <a href="{{ route('removeCharacter', ['projId' => $data["projId"], 'id' => $chara->id]) }}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection