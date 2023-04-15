@extends('main')
@push('styles')
        <link href="{{ asset('css/user/publicPage.css') }}" rel="stylesheet" type="text/css" >
    @endpush
@section('content')
<div class="pageContainer">
    <div class="titleContainer">
        <div class="title">
            ~Felhasználónév~
        </div>
    </div>
    <div class="splitPageContainer">
        <div class="infoContainer">
            <div class="imageAndMetaContainer">
                <div class="imageContainer">
                    <img src="{{ $data->user->img_path != "" ? asset('images/story/'.$data->user->img_path):asset('images/default/default3.png') }}" alt="..." class="userImage">
                    <div class="infoValue">{{$data->user->username}}</div>
                </div>
                <div class="metaContainer">
                    
                    <div class="infoName">Csatlakozás ideje:</div>
                    <div class="infoValue"> {{date('Y-m-d',strtotime($data->user->created_at))}} </div>
                </div>
            </div>
            @if (!$data->is_me)
            <form action="{{route("setSubscription", $data->user->id)}}" method="POST" class="subscribeButtonContainer">
                @csrf
                <button type="submit" name="subscribeButton" value="{{$data->subscribed ? '1':'0'}}_{{$data->user->id}}" class="siteButton midSizeButton">@if(!$data->subscribed) {{ __('buttons.subscribe')}}@else{{__('buttons.unsubscribe')}}@endif</button>
            </form>
            @endif
            <div class="descContainer">
                <div class="infoValue"> {{$data->user->description}} </div>
            </div>
        </div>
        <div class="pageContentContainer">
            <div class="storyListContainers">
                <div class="containerTitle">
                    Író munkái
                </div>
                <div class="myWorks">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="wideStoryContainer">
                            <div class="imageContainer">
                                <img src="{{ $data->stories[$i]->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$data->stories[$i]->img_path)) }}" alt="">
                            </div>
                            <div class="storyInfoContainer">
                                <div class="storyTitle">{{$data->stories[$i]->title}}</div>
                                <div class="storyInfo">
                                    <div class="smallContainer">
                                        <div class="infoName">Állapot: {{$data->stories[$i]->state}}</div>
                                        <div class="infoName">Zsáner: {{$data->stories[$i]->genre}}</div>
                                    </div>
                                </div>
                                <div class="descContainer">
                                    {{$data->stories[$i]->description}}
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="moreContainer">
                        Több...
                    </div>
                </div>
            </div>
            @foreach ($data->booklists as $list) 
                @if ($list->books->isEmpty())
                    @continue
                @endif
                <div class="storyListContainers">
                    <div class="containerTitle">
                        {{$list->title}}
                    </div>
                    <div class="myWorks">
                        @if (isset($list->books[0]))
                            <div class="wideStoryContainer">
                                <div class="imageContainer">
                                    <img src="{{ $list->books[0]->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$list->books[0]->img_path)) }}" alt="">
                                </div>
                                <div class="storyInfoContainer">
                                    <div class="storyTitle">{{$list->books[0]->title}}</div>
                                    <div class="storyInfo">
                                        <div class="smallContainer">
                                            <div class="infoName">Állapot: {{$list->books[0]->state}}</div>
                                            <div class="infoName">Zsáner: {{$list->books[0]->genre}}</div>
                                        </div>
                                    </div>
                                    <div class="descContainer">
                                        {{$list->books[0]->description}}
                                    </div>
                                </div>
                            </div>
                            @if (isset($list->books[1]))
                                <div class="wideStoryContainer">
                                    <div class="imageContainer">
                                        <img src="{{ $list->books[1]->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$list->books[1]->img_path)) }}" alt="">
                                    </div>
                                    <div class="storyInfoContainer">
                                        <div class="storyTitle">{{$list->books[1]->title}}</div>
                                        <div class="storyInfo">
                                            <div class="smallContainer">
                                                <div class="infoName">Állapot: {{$list->books[1]->state}}</div>
                                                <div class="infoName">Zsáner: {{$list->books[1]->genre}}</div>
                                            </div>
                                        </div>
                                        <div class="descContainer">
                                            {{$list->books[1]->description}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="collapse" id="storyCollapse{{$list->id}}">
                            @for ($i = 2; $i < $list->books->count(); $i++)
                                <div class="wideStoryContainer">
                                    <div class="imageContainer">
                                        <img src="{{ $list->books[$i]->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$list->books[$i]->img_path)) }}" alt="">
                                    </div>
                                    <div class="storyInfoContainer">
                                        <div class="storyTitle">{{$list->books[$i]->title}}</div>
                                        <div class="storyInfo">
                                            <div class="smallContainer">
                                                <div class="infoName">Állapot: {{$list->books[$i]->state}}</div>
                                                <div class="infoName">Zsáner: {{$list->books[$i]->genre}}</div>
                                            </div>
                                        </div>
                                        <div class="descContainer">
                                            {{$list->books[$i]->description}}
                                        </div>
                                    </div>
                                </div>                                
                            @endfor
                        </div>
                        <div class="moreContainer">
                            <a class="siteButton moreButton" data-bs-toggle="collapse" href="#storyCollapse{{$list->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Több...
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="otherUsersContainer">
            @foreach ($data->users_sub_to as $user)
               image {{$user->username}}
            @endforeach
        </div>
    </div>
</div>
@endsection