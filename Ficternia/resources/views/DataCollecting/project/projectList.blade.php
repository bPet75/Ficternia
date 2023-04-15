@extends('main')
@section('content')
    @push('styles')
        <link href="{{ asset('css/listers/objectLister.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/projectList.css') }}" rel="stylesheet" type="text/css" >
    @endpush

    <div class=" w-100 gridContainer">
        <a class="card addNew" href="{{route('newProject')}}">
            <div class="card-body">
                <div class="plusSign alt">
                    
                </div>
            </div>
        </a>
        @foreach ($data as $proj)
        <div class="card">
            <div class="card-header gridCardHeaderContainer">
                <div>
                    {{$proj->name}}
                </div>
                <div class="iconToRight">
                    <a href="" class="grid smallButton eye">&#128065;</a>
                    <a href="{{ route('updateProject', $proj->id) }}" class="grid smallButton pencil">&#128393;</a>
                    <a href="{{ route('removeProject', ['id' => $proj->id]) }}" class="grid smallButton trash">&#128465;</a>
                </div>
                
            </div>
            <a class="card-body" href="{{route('stories',$proj->id)}}">
                {{$proj->description}}
            </a>
        </div>
        @endforeach
    </div>
@endsection