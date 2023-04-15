@extends('main')
@push('styles')
<link href="{{ asset('css/browser/index.css') }}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
<div class="pageContainer">
    <div class="titleContainer">
        <div class="title">
        </div>
    </div>
    {{dd($data)}}
    <div class="searchContainer">
        @if (isset($data->filter_data))
              <form action="{{route('filterStories')}}" method="POST" class="searchBarContainer">
                @csrf
                <input type="text" name="title" placeHolder="cím">
                <div class="searchFilters ">
                  <div class="filtersInnerContainer">
                    <div class="filters">
                      <input type="text" name="owner">
                      <select name="genre_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                        @endforeach
                      </select>
                      <select name="audience_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->audiences as $gaudience)
                            <option value="{{$gaudience->id}}">{{$gaudience->name}}</option>
                        @endforeach
                      </select>
                      <select name="state_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->state as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="buttonContainer">
                      <button type="submit">asdasdas</button>
                    </div>
                  </div>
                </div>
              </form>
            @endif
    </div>
    <div class="resultContainer">
        @foreach ($data as $story)
            <div class="storyCardWrapper">
              <a class="storyCard" href="{{route('storyPage',$story->id)}}">
                <div class="cardLeft">
                  <div class="storyCover">
                    <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                  </div>
                </div>
                <div class="cardRight">
                  <div class="storyTitle">
                    {{$story->title}}
                  </div>
                  <div class="general">
                    <div> {{$story->genre}} </div>
                    <div> {{$story->audience}} </div>
                    <div> {{$story->state}} </div>
                    <div> {{$story->views}} </div>
                  </div>
                  <div class="description">
                    {{$story->description}}
                  </div>
                </div>
              </a> 
            </div>
      @endforeach
    </div>
</div>
@endsection