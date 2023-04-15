@extends('main')
@section('content')
    @push('styles')
        <link href="{{ asset('css/writer/chapterMaker.css') }}" rel="stylesheet" type="text/css" >
    @endpush
    @push('scripts')
    <script src="https://cdn.tiny.cloud/1/fvjnmg0d6hha5khs2kkmnebqtod48nk9ed2vv7kj6dmqqwcs/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
          selector: 'textarea',
          plugins: 'anchor image wordcount searchreplace',
          menubar: false,
          toolbar: 'blocks fontfamily fontsize | bold italic underline strikethrough | align | indent outdent | removeformat',
          height: '70vh',
        });
      </script>
    @endpush
    <div class="gridContainer">
        {{$isChapterSet=false}}
        @if(!isset($data->chapter))
            <form action="{{ route('saveChapter',['projId'=>$data["projId"], 'storyId' => $data["storyId"], "id"=>$data->draft->id]) }}" method="POST">
        @else
            <div class="hide">{{$isChapterSet=true}}</div>
            <form action="{{ route('updateChapter',['projId'=>$data["projId"], 'storyId' => $data["storyId"] ,'id'=>$data->chapter->id]) }}" method="POST">
        @endif
            @csrf
            <div class="formContent">
                <div class="contentContainer">
                    <div class="draftContainer">
                        <div class="draftInfoContainer">
                            <label for="synopsis">{{ __('properties.synopsis') }}</label>
                            <span name="synopsis">
                                {{$data->draft->synopsis}}
                            </span>
                        </div>
                        <div class="draftInfoContainer">
                            <label for="draftBody">{{ __('properties.draft') }}</label>
                            <span name="draftBody">
                                {{$data->draft->body}}
                            </span>
                        </div>
                    </div>
                    <div class="writerContainer">
                        <div class="chapterTitle">
                            <label for="title">{{ __('properties.title') }}</label>
                            <input type="text" name="title" value="{{$isChapterSet ? ($data->chapter->title):($data->draft->title)}}">
                        </div>
                        <textarea name="body">
                            {{$isChapterSet ? ($data->chapter->body):''}}
                         </textarea>
                         
                    </div>
                    <div class="objectContainers">
                        <div class="objectContainer">
                            <a class="collapseButtons" data-bs-toggle="collapse" href="#charactersCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('menu.characters') }}
                            </a>
                            <div class="collapse" id="charactersCollapse">
                                <div class="listContainer">
                                    @foreach ($data->characters as $character)
                                        <div class="characterContainer">
                                            <a class="characterCollapseButtons" data-bs-toggle="collapse" href="#characterCollapse{{$character->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                {{$character->name}}
                                            </a>
                                            <div class="collapse" id="characterCollapse{{$character->id}}">
                                                <div class="characterDescription">
                                                    {{$character->description}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="objectContainer">
                            <a class="collapseButtons" data-bs-toggle="collapse" href="#locationCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('menu.locations') }}
                            </a>
                            <div class="collapse" id="locationCollapse">
                                <div class="listContainer">
                                    @foreach ($data->locations as $location)
                                        <div class="characterContainer">
                                            <a class="characterCollapseButtons" data-bs-toggle="collapse" href="#locationCollapse{{$location->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                {{$location->name}}
                                            </a>
                                            <div class="collapse" id="locationCollapse{{$location->id}}">
                                                <div class="characterDescription">
                                                    {{$location->description}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="objectContainer">
                            <a class="collapseButtons" data-bs-toggle="collapse" href="#eventCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('menu.events') }}
                            </a>
                            <div class="collapse" id="eventCollapse">
                                <div class="characterListContainer">
                                    @foreach ($data->events as $event)
                                        <div class="characterContainer">
                                            <a class="characterCollapseButtons" data-bs-toggle="collapse" href="#eventCollapse{{$event->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                {{$event->name}}
                                            </a>
                                            <div class="collapse" id="eventCollapse{{$event->id}}">
                                                <div class="characterDescription">
                                                    {{$event->description}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="objectContainer">
                            <a class="collapseButtons" data-bs-toggle="collapse" href="#noteCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('menu.notes') }}
                            </a>
                            <div class="collapse" id="noteCollapse">
                                <div class="characterListContainer">
                                    @foreach ($data->notes as $note)
                                        <div class="characterContainer">
                                            <a class="characterCollapseButtons noteCollapse" data-bs-toggle="collapse" href="#noteCollapse{{$note->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                {{$note->body}}
                                            </a>
                                            <div class="collapse" id="noteCollapse{{$note->id}}">
                                                <div class="characterDescription">
                                                    {{$note->body}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottomContent">
                    <div>
                        <label for="visibility">{{ __('properties.visibility') }}</label>
                        <select name="visibility" id="">
                            @foreach ($data->available_visibilities as $key => $item)
                                <option value="{{$key}}" {{$isChapterSet ? ($data->chapter->visibility == $item ? 'selected':''):''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit">{{ __('buttons.save') }}</button>
                    </div>
                    
                    
                </div>
            </div>
        </form>
    </div>


@endsection