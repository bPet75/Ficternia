@extends('Planning.index')
@section('listerForPlanning')
@push('styles')
        <link href="{{ asset('css/Planner/collectionLister.css') }}" rel="stylesheet" type="text/css" >
@endpush
<div class="listerContainer">
    <div class="newButtonContainer">
        <a href="{{route('addCollection', ['projId' => $data['projId'], 'storyId' => $data['storyId']] )}}" class="siteButton mediumMidSizeButton">Új gyűjtemény</a>
    </div>
    <div class="collectionContainer">
        @foreach ($data->collections as $collection)
        <div class="collectionBar"  style="--collectionColor: {{$collection->color}}">
            <div class="titleContainer" data-bs-toggle="collapse" href="#collapse_{{$collection->id}}" role="button"><span class="title small" >{{$collection->name}}</span></div>
            <div>
                <div class="objectControlButtonContainer collection">
                    <a href="{{route('getCollectionForUpdate', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'collectionId' => $collection->id] )}}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                    <a href="{{route('removeCollection', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'collectionId' => $collection->id] )}}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                </div>
            </div>
        </div>
        <div class="collapse draftCardInCollection" id="collapse_{{$collection->id}}">
            @foreach($collection->content as $draft)
                <div class="draftCard">
                    <span>{{$draft["title"]}}</span>
                </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endsection