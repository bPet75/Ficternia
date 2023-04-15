@extends('Planning.index')
@section('listerForPlanning')
<div class="listerContainer">
    <div class="newButtonContainer">
        <a href="{{route('addNote', ['projId' => $data['projId'], 'storyId' => $data['storyId']] )}}" class="siteButton mediumMidSizeButton">Új jegyzet</a>
    </div>
    <div class="gridListContainer horizontalListerContainer">
        @foreach ($data->notes as $note)
            <div class="objectCard horizontalCard forNote">
                <div class="objectInfoHolder">
                    <div class="descriptionRow">
                        <div class="objectDescription forNote">{{$note->body != "" ? $note->body:'N/A'}}</div>
                    </div>
                </div>
                <div class="objectControlButtonContainer horizontal">
                    <a href="" class="objectControlButton horizontal gridCenterText objectModalButton">&#128065;</a>
                    <a href="{{route('getDraftForUpdate', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'draftId' => $note->id] )}}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
                    <a href="{{route('removeDraft', ['projId' => $data['projId'], 'storyId' => $data['storyId'], 'draftId' => $note->id] )}}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
                </div>
            </div>
        @endforeach
    </div>
</div>



@endsection