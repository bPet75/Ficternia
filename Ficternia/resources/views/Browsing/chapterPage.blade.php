@extends('main')
@push('styles')
  <link href="{{asset('css/browser/chapterPage.css') }}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
<div class="pageContainer">
    <div class="pageHeader">
        {{$data->chapter->title}}
    </div>
    <div class="contentContainer">
        <div class="contentSide"></div>
        <div class="chapterContent {{$data->i_am_admin ? 'chapterContentAdmin':''}}">
            @if ($data->i_am_admin)
                <div class="adminButton">
                    <a href="{{route('hideChapter', ['storyId' => $data['storyId'], 'cgId'=>$data->chapter->id, 'is_last'=>$$data->chapter->is_last])}}" class="siteButton controlButton">Fejezet elrejtése</a>
                </div>
            @endif
            <div class="Content">

                {!!$data->chapter->body!!}
            </div>
        </div>
        <div class="contentSide"></div>
    </div>
    <div class="pageFooter">
        <ul class="GroupNav" id="navList" role="tablist">
            <li class="groupNavElement">
                <a class="navTab active" data-bs-toggle="tab" href="#rating" role="tab">{{ __('menu.rating') }}</a>
            </li>
            <li class="groupNavElement">
                <a class="navTab" data-bs-toggle="tab" href="#discussion" role="tab">{{ __('menu.discussion') }}</a>
            </li>
        </ul>
        <div class="commentInputContainer tab-content">
            <div class="commentInputContainer tab-pane fade active show" id="rating" role="tabpanel">
                @if(!$data->is_own)
                <form action="{{route('saveComment',["storyId"=>$data["storyId"], "chId"=>$data->chapter->id, "parentId" => 0, "is_last" => $data->is_last])}}" method="post">
                    @csrf
                    <textarea name="body" id="" cols="100" rows="7"></textarea>
                    <div class="ratingAndButtonContainer">
                        <div class="stars">
                            <input type="radio" name="rating" value="1" />
                            <input type="radio" name="rating" value="2" />
                            <input type="radio" name="rating" value="3" />
                            <input type="radio" name="rating" value="4" />
                            <input type="radio" name="rating" value="5" />
                            <i></i>
                        </div>
                        <div class="buttonContainer">
                            <button type="submit">{{ __('buttons.send') }}</button>
                        </div>
                    </div>
                </form>
                @endif

                <div class="commentContainer">
                    @each('components.partials.comment', $data->comments->ratings, 'comment')
                </div>
            </div>
            <div class="commentInputContainer tab-pane fade" id="discussion" role="tabpanel">
                <form action="{{route('saveComment',["storyId"=>$data["storyId"], "chId"=>$data->chapter->id, "parentId" => 0, "is_last" => $data->is_last])}}" method="post">
                    @csrf
                    <textarea name="body" id="" cols="100" rows="7"></textarea>
                    <div class="buttonContainer">
                        <button type="submit">{{ __('buttons.send') }}</button>
                    </div>
                </form>
                <div class="commentContainer">
                    @each('components.partials.comment', $data->comments->comments, 'comment')
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection