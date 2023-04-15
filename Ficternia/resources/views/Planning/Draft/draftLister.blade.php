@extends('Planning.index')
@section('listerForPlanning')
@push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/religionList.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    <div class="listerContainer">
        <div class="newButtonContainer">
            <a href="{{route('addDraft', ['projId' => $data['projId'], 'storyId' => $data['storyId']] )}}" class="siteButton mediumMidSizeButton">Új vázlat</a>
        </div>
        {{--
        <div class="searchContainer">
            <form action="{{route('filterDrafts', ['projId' => $data['projId'], 'storyId'=> $data['storyId']])}}" method="post">
                @csrf
                <input type="text" name="filter">
                <button type="submit">Keresés</button>
            </form>
        </div>--}}
        <div class="gridListContainer horizontalListerContainer">
            @foreach ($data->drafts as $draft)
                <div class="objectCard horizontalCard forDraft">
                    <div class="objectControlButtonContainer forDraft">
                        <a href="" class="objectControlButton horizontal gridCenterText objectModalButton">&#128065;</a>
                        <a href="{{route('draftConnections', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'draftId' => $draft->id, 'onlyparts' => 0])}}" class="objectControlButton horizontal gridCenterText connectionsButton">C</a>
                        <a href="{{route('getDraftForUpdate', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'draftId' => $draft->id] )}}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                        <a href="{{route('removeDraft', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'draftId' => $draft->id] )}}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                    </div>
                    <div class="objectInfoHolder">
                        <div class="objectName forDraft">{{$draft->title}}</div>
                        <div class="descriptionRow">
                            <div class="objectDescription">{{$draft->synopsis != "" ? $draft->synopsis:'N/A'}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



@endsection