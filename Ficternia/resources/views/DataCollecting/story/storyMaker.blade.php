@extends('DataCollecting.index')
@section('lister')
@push('styles')
    <link href="{{ asset('css/storyMaker.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/elements/makers.css') }}" rel="stylesheet" type="text/css" >
    
@endpush
@push('scripts')
    <script src="{{ asset('js/pictureLoader.js') }}"></script>
@endpush
{{$isStorySet=false}}

<form action="{{isset($data->story) ? route('SaveUpdateStory',['projId'=>$data["projId"],'id'=>$data->story->id]):route('saveStory',$data["projId"])}}" method="POST" class="gridRow">
    @csrf
    <div class="titleContainer">
        <input type="text" class="title titleInput" name="title" value="{{ isset($data->story) ? $data->story->title:__('properties.title')}}" autofocus onfocus="var temp_value=this.value; this.value=''; this.value=temp_value">
    </div>
    <div class="objectInputContainer">
        <div class="selectorContainer">
            <div class="gridRow inputContiner">
                <label for="genre_id" class="inputName">{{ __('properties.genre') }}</label>
                <select name="genre_id">
                    @foreach ($data->genres as $gOption)
                        <option value="{{$gOption->id}}" {{isset($data->story) ? ($data->story->genre_id == $gOption->id ? 'selected':''):''}}>{{$gOption->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="gridRow inputContiner">
                <label for="audience_id" class="inputName">{{ __('properties.audience') }}</label>
                <select name="audience_id">
                    @foreach ($data->audiences as $aOption)
                        <option value="{{$aOption->id}}" {{isset($data->story) ? ($data->story->audience_id == $aOption->id ? 'selected':''):''}}>{{$aOption->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="gridRow inputContiner">
                <label for="state_id" class="inputName">{{ __('properties.status') }}</label>
                    <select name="state_id">
                        @foreach ($data->states as $sOption)
                            <option value="{{$sOption->id}}" {{isset($data->story) ? ($data->story->state_id == $sOption->id ? 'selected':''):''}}>{{$sOption->name}}</option>
                        @endforeach
                    </select>
            </div>
        </div>
        <div id="imageContainer" class="imageContainer mt-2">
            <input type="file" onchange="readURL(this);" name="file" id="newpicture_file" style="display: none"/>
            <button type="button" value="Browse..." onclick="document.getElementById('newpicture_file').click();" class="imageContainer buttonImageContainer">
                <img id="cover" src="{{isset($data->story) ? (asset('images/story/'.$data->story->img_path.'')):(asset('images/default/default3.png'))}}" alt="" />
            </button>
        </div>
    </div>
    <div class="gridRow bigInputContainer">
        <label for="description" class="inputName">{{ __('properties.description') }}</label>
        <textarea name="description" rows="10" class="">{{isset($data->story) ? $data->story->description:''}}</textarea>
    </div>
    <div class="buttonContainer">
        <button type="submit" class="siteButton midSizeButton">{{ __('buttons.save') }}</button>
    </div>
</form>

{{--

            
            <div class="storyFormElement">
                <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                class="formInput" name="description" label="{{ __('properties.description') }}" labelClass="h3 mb-3 labelWidth" type="text" value="{{$isStorySet ? $data->story->description : ''}}" />
            </div>
            <div class="storyFormElement mt-3">
                
            </div>
            <div class="d-flex justify-content-center w-100 my-3">
                
            </div>
        </div>
    </form>

--}}
@endsection