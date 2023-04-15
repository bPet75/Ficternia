<div class="comment">
    <div class="commentHead">
        <div class="commentWriter">
            {{$comment->writer}}
        </div>
        @if (isset($comment->rating))
            <div class="rating">
                <div class="stars ratedStars">
                    <input type="radio" name="rating" value="1" disabled {{$comment->rating == '1' ? 'checked':''}}/>
                    <input type="radio" name="rating" value="2" disabled {{$comment->rating == '2' ? 'checked':''}}/>
                    <input type="radio" name="rating" value="3" disabled {{$comment->rating == '3' ? 'checked':''}}/>
                    <input type="radio" name="rating" value="4" disabled {{$comment->rating == '4' ? 'checked':''}}/>
                    <input type="radio" name="rating" value="5" disabled {{$comment->rating == '5' ? 'checked':''}}/>
                    <i></i>
                </div>
            </div>
        @endif
        <div class="commentTime">
            {{$comment->created_at}}
        </div>
        @if (($comment->plus_content["i_am_admin"] || $comment->plus_content["auth_id"] == $comment->user_id) && $comment->body != "deleted")
            <form action="{{route('removeComment', ["storyId"=>$comment->plus_content["storyId"], "chId"=>$comment->chapter_id, "commentId" => $comment->id])}}" method="POST" class="commentDeleteButtonContainer">
                @csrf
                <button class="deleteButton" type="submit">Törlés</button>
            </form>
        @endif
    </div>
    <div class="commentBody">
        {{$comment->body}}
    </div>
    @if ($comment->plus_content["is_own"])
    <div class="commentFooter">
        <a data-bs-toggle="collapse" href="#replyCollapse{{$comment->id}}" role="button" class="replyButton">{{ __('buttons.answer') }}</a>
    </div>
    @endif
    <div class="collapse" id="replyCollapse{{$comment->id}}">
        <form action="{{route('saveComment',["storyId"=>$comment->plus_content["storyId"], "chId"=>$comment->chapter_id, "parentId" => $comment->id , "is_last" => $comment->plus_content['is_last']])}}" method="POST" class="replyForm" >
            @csrf
            <div class="textAreaContainer">
                <textarea name="body" placeholder="{{ __('menu.answer_to') }}{{$comment->writer}}" rows="5"></textarea>
            </div>
            <div class="replyButtonsContainer">
                <button type="submit" class="replyControlButtons">{{ __('buttons.send') }}</button>
                <a data-bs-toggle="collapse" href="#replyCollapse{{$comment->id}}" role="button" class="replyControlButtons">{{ __('buttons.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
<div class="children">
    @if (isset($comment->childs))
        @each('components.partials.comment', $comment->childs, 'comment')
    @endif
</div>
