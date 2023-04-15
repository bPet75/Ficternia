@extends('DataCollecting.index')
@section('lister')
@push('styles')
    <link href="{{ asset('css/locationMaker.css') }}" rel="stylesheet" type="text/css" >
@endpush
@push('scripts')
    <script src="{{ asset('js/pictureLoader.js') }}"></script>
@endpush
{{$isLocationSet=false}}
@if(!isset($data->location))
    <form action="{{ route('saveLocation',$data["projId"]) }}" method="POST" enctype="multipart/form-data">
@else
    <div class="hide">{{$isLocationSet=true}}</div>
    <form action="{{ route('SaveUpdateLocation',['projId'=>$data["projId"], 'id'=>$data->location->id]) }}" method="POST" enctype="multipart/form-data">
@endif
        @csrf
        
        <div class="gridContainer">
            <div class="locationFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="name" label="{{ __('properties.name') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isLocationSet ? $data->location->name : ''}}" />
            </div>
            <div class="locationFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="state" label="{{ __('properties.state') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isLocationSet ? $data->location->state : ''}}" />
            </div>
            <div class="locationFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="ruler" label="{{ __('properties.ruler') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isLocationSet ? $data->location->ruler : ''}}" />
            </div>
            <div class="locationFormElement mt-3">
                <label for="imageContainer" class="h3">{{ __('properties.image') }}</label>
                <div id="imageContainer" class="imageContainer mt-2">
                    <img id="cover" src="{{$isLocationSet ? (asset('images/location/'.$data->location->img_path.'')):'#'}}" height="250px" width="500px" alt="" />
                </div>
                <input type="file" onchange="readLocURL(this);" name="file" id="newpicture_file"/>
            </div>
            
            <div class="locationFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="founder_name" label="{{ __('properties.founder_name') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isLocationSet ? $data->location->founder_name : ''}}" />
            </div>
            <div class="locationFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="date_of_founding" label="{{ __('properties.date_of_founding') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isLocationSet ? $data->location->date_of_founding : ''}}" />
            </div>
            <div class="locationFormElement">
                <x-forms.textarea divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="history" label="{{ __('properties.past') }}" labelClass="h3 mb-3 labelWidth" rows="4" value="{{$isLocationSet ? $data->location->history : ''}}"/>
            </div>
            <div class="locationFormElement">
                <x-forms.textarea divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="description" label="{{ __('properties.description') }}" labelClass="h3 mb-3 labelWidth" rows="4" value="{{$isLocationSet ? $data->location->description : ''}}"/>
            </div>
            <div class="locationFormElement">
                
                @foreach(array_keys($data->stories) as $storyID)
                    @if(isset($data->inStory))
                        @if(in_array($storyID, array_keys($data->inStory)))
                            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                            class="checkbox" checked type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                        @else
                            <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                            class="checkbox" type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                        @endif
                    @else
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="checkbox" type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                    @endif                
                @endforeach
            </div>
        </div>
        <div class="d-flex justify-content-center w-100 my-3">
            <button type="submit" class="btn btn-secondary w-50">{{ __('buttons.save') }}</button>
        </div>
    </form>


@endsection