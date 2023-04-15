@extends('main')
@push('styles')
    <link href="{{ asset('css/user/userPage.css') }}" rel="stylesheet" type="text/css" >
@endpush
@section('content')
<div class="">
    <div class="gridRow userPageContent">
        <div class="titleContainer"><span class="title">~Settings~</span></div>
        <form action="{{route('updateUser', $data->user->id)}}" method="post">
            @csrf
            <div class="infoWithImageContainer">
                <div class="gridRow firstCol">
                    <div class="textBoxContainer">
                        <label for="last_name">Vezetéknév</label>
                        <input type="text" name="last_name" value="{{$data->user->last_name}}">
                    </div>
                    <div class="textBoxContainer">
                        <label for="username">Felhasználónév</label>
                        <input type="text" name="username" value="{{$data->user->username}}">
                    </div>
                </div>
                <div class="gridRow secondCol">
                    <div class="textBoxContainer">
                        <label for="first_name">Keresztnév</label>
                        <input type="text" name="first_name" value="{{$data->user->first_name}}">
                    </div>
                </div>
                <div class="imageCol">
                    <div class="imageContainer">
                        <img src="{{ $data->user->img_path != "" ? asset('images/user/'.$data->user->img_path):asset('images/default/default3.png') }}" alt="..." class="userImage">
                    </div>
                    <div class="imageInput">
                        <input type="file" class="mx-auto" name="img_path" id="">
                    </div>
                </div>
            </div>
            <div class="userInfoContainer">
                <label for="email">Leírás</label>
                <input type="text" name="description" value="{{$data->user->description}}">
                <label for="email">Email cím</label>
                <input type="email" name="email" value="{{$data->user->email}}">
                <label for="password">Jelszó</label>
                <input type="text" name="password">
                <label for="re_password">Jelszó újra</label>
                <input type="text" name="re_password">
            </div>
            <button type="submit">Mentés</button>
        </form>
    </div>
</div>


@endsection