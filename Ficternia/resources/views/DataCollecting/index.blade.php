@extends('main')
@push('styles')
@endpush
@section('content')
<div class="">
    <div class="">
        @include('DataCollecting.sideNav')
    </div>
    <div class="">
            @yield('lister')
    </div>
</div>
@endsection