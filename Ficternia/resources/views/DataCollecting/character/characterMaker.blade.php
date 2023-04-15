@extends('DataCollecting.index')
@section('lister')
    @push('styles')
        <link href="{{ asset('css/characterMaker.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/elements/makers.css') }}" rel="stylesheet" type="text/css" >
    
    @endpush
    @push('scripts')
        <script src="{{ asset('js/pictureLoader.js') }}"></script>
        <script src="{{ asset('js/addProperty.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    @endpush
    
    {{$isCharacterSet=false}}
    @if(!isset($data->character))
        <form class="mx-auto" action="{{ route('saveCharacter',$data["projId"]) }}" method="POST" enctype="multipart/form-data">
    @else
        <div class="hide">{{$isCharacterSet=true}}</div>
        <form class="mx-auto" action="{{ route('SaveUpdateCharacter', ['projId'=>$data["projId"], 'id'=>$data->character->id]) }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <ul class="characterGroupNav" id="navList" role="tablist">
            <li class="groupNavElement">
                <a class="navTab active" data-bs-toggle="tab" href="#basicInfo" role="tab">{{ __('menu.base_data') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#descriptions" role="tab">{{ __('menu.descriptions') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#ideologies" role="tab">{{ __('menu.ideologies') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#stories" role="tab">{{ __('menu.stories') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#psychology" role="tab">{{ __('menu.psichology') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#customProps" role="tab">{{ __('menu.other_properties') }}</a>
        </ul>
        <div class="gridContainer tab-content">
            <div class="tab-pane fade active show" id="basicInfo" role="tabpanel">
                <div class="tabContainer">
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="name" label="{{ __('properties.name') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->name : ''}}" />
                    </div>
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="species" label="{{ __('properties.species') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->properties['species'] : ''}}" />
                    </div>
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="biological_sex" label="{{ __('properties.biological_sex') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->properties['biological_sex'] : ''}}" />
                    </div>
                    <div class="characterFormElement mt-3">
                        <label for="imageContainer" class="h3">Karakter kép</label>
                        <div id="imageContainer" class="imageContainer mt-2">
                            <img id="cover" src="{{$isCharacterSet ? (asset('images/character/'.$data->character->img_path.'')):'#'}}" height="515px" width="384px" alt="" />
                        </div>
                        <input type="file" onchange="readURL(this);" name="file" id="newpicture_file"/>
                    </div>
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="gender_identity" label="{{ __('properties.gender_identity') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->properties['gender_identity'] : ''}}" />
                    </div>
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="date_of_birth" label="{{ __('properties.date_of_birth') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->properties['date_of_birth'] : ''}}" />
                    </div>
                    <div class="characterFormElement">
                        <x-forms.input divClass="my-2 d-flex flex-column w-25" 
                        class="formInput" name="age" label="{{ __('properties.age') }}" labelClass="h3 mb-3" type="text" value="{{$isCharacterSet ? $data->character->properties['age'] : ''}}" />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="descriptions" role="tabpanel">
                <div class="descriptionsElement">
                    <x-forms.textarea divClass="my-2 d-flex flex-column" 
                    class="w-100" name="past" label="{{ __('properties.past') }}" labelClass="h3 mb-3" rows="6" cols="150" value="{{$isCharacterSet ? $data->character->properties['past'] : ''}}" />
                </div>
                <div class="descriptionsElement">
                    <x-forms.textarea divClass="my-2 d-flex flex-column" 
                    class="w-100" name="description" label="{{ __('properties.description') }}" labelClass="h3 mb-3" rows="6" value="{{$isCharacterSet ? $data->character->properties['description'] : ''}}" />
                </div>
                <div class="descriptionsElement">
                    <x-forms.textarea divClass="my-2 d-flex flex-column" 
                    class="w-100" name="characteristics" label="{{ __('properties.characteristics') }}" labelClass="h3 mb-3" rows="6" value="{{$isCharacterSet ? $data->character->properties['characteristics'] : ''}}" />
                </div>
            </div>
            <div class="tab-pane fade" id="ideologies" role="tabpanel">
                <div class="characterFormElement">
                    <x-forms.textarea divClass="my-2 d-flex flex-column" 
                    class="w-100" name="ideology" label="{{ __('properties.ideology') }}" labelClass="h3 mb-3" rows="4" cols="150" value="{{$isCharacterSet ? $data->character->properties['ideology'] : ''}}" />
                </div>
                <div class="characterFormElement">
                    <div class="my-2 d-flex flex-column">
                        <label for="religionSelector" class="h3 mb-3">{{ __('properties.religion') }}</label>
                        <select name="religion_id" id="religionSelector" class="formInput w-100">
                            <option value="0"></option>
                            @foreach($data->religions as $religion)
                            <option value="{{$religion->id}}" {{$isCharacterSet ? ($religion->id == $data->character->religion_id ? 'selected':''):''}}>{{$religion->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="stories" role="tabpanel">
                <div class="characterFormElement">
                    @foreach(array_keys($data->stories) as $storyID)
                        @if(isset($data->inStory))
                            @if(in_array($storyID, array_keys($data->inStory)))
                                <x-forms.input divClass="my-2 d-flex flex-column" 
                                class="checkbox" checked type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                            @else
                                <x-forms.input divClass="my-2 d-flex flex-column" 
                                class="checkbox" type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                            @endif
                        @else
                            <x-forms.input divClass="my-2 d-flex flex-column" 
                            class="checkbox" type="checkbox" name="story{{$storyID}}" value="{{$storyID}}" label="{{$data->stories[$storyID]}}" labelClass="h3 mb-3 labelWidth" id="story{{$storyID}}"/>
                        @endif                
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade" id="psychology" role="tabpanel">
                @foreach($data->questions as $question)
                <div class="questionElements">
                    <x-forms.textarea divClass="my-2 d-flex flex-column" 
                    class="w-100" name="question{{$question['id']}}" label="{{$question['question']}}" rows="6" cols="150" labelClass="h3 mb-3" type="text" value="{{$question['answer']}}" />
                </div>
                @endforeach
            </div>
            <div class="tab-pane fade" id="customProps" role="tabpanel">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary newPropertyButton" data-bs-toggle="modal" data-bs-target="#newPropModal">{{ __('buttons.new_property') }}</button>
                </div>
               
                  
                
                <div class="customProps" id="customPropertyContainer">
                    @if($isCharacterSet)
                        @foreach($data->character->properties as $key=>$props)
                            @if(str_contains($key,'custProp_'))
                                <div class="my-2 d-flex flex-column w-25">
                                    <label for="properties_id" class="h3 mb-3"> {{str_replace("custProp_","",$key)}} </label>
                                    <textarea class=" formInput border border-dark customProperty"
                                        name="{{$key}}" rows="4" cols="150">{{$props}}</textarea>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="d-flex justify-content-center w-100 my-3">
                <button type="submit" class="btn btn-secondary w-50">{{ __('buttons.save') }}</button>
            </div>
        </div>
        
    </form>
    <div class="modal fade" id="newPropModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('buttons.new_property') }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body newPropModalBody">
                <label for="newPropertyName">{{ __('properties.name') }}:</label>
                <input type="text" class="formInput w-75" id="newPropertyName">
                <button type="button" class="btn btn-primary" onClick="newProp()" data-bs-dismiss="modal">{{ __('buttons.add_property') }}</button>
            </div>
            
          </div>
        </div>
      </div>
    @endsection