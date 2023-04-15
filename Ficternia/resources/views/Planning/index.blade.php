@extends('main')
@push('styles')
<link href="{{ asset('css/elements/datacollecting.css') }}" rel="stylesheet" type="text/css" >
    @endpush
@section('content')
<div class="">
    <div class="">
        @include('Planning.sideNav')
    </div>
    <div class="">
            @yield('listerForPlanning')
    </div>
</div>
@endsection