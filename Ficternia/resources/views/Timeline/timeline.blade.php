@extends('DataCollecting.index')
@push('styles')
    <link href="{{ asset('css/timeline.css') }}" rel="stylesheet" type="text/css" >
@endpush
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endpush
@section('lister')

        <div class="timelineContainer py-5">
            <div class="main-timeline" role="tablist">
                @foreach ($data->events as $event)
                    {{-- data-bs-toggle="modal" data-bs-target="#majorEventModal{{$d->ID}}"     onClick="showMinorEventsAndAddModal({{$d->ID}})"--}}
                    <div class="timeline {{--$loop->index % 2 ? 'right':'left'--}} left {{isset($event->parent_id) ? 'childEvent':''}} {{$loop->index == 0 ? 'active':''}} "  data-bs-toggle="tab" data-bs-target="#eventInfo{{$event->id}}" role="presentation">
                        <div id="{{$event->id}}" class="card {{isset($event->parent_id) ? 'childEventCard':'eventCard'}}" role="tab">
                            <div class="card-body p-4">
                                <h5><b>{{isset($event->parent_id) ? $event->parent_name." >":''}}  {{$event->name}}</b></h5>
                                <p class="mb-0 eventDescription">{{$event->description}}</p>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div role="tab-content">
                @foreach($data->events as $event)
                {{--dd($event)--}}
                <div class="tab-pane fade {{$loop->index == 0 ? 'show active':''}}" id="eventInfo{{$event->id}}" role="tabpanel">
                    <div class="eventInfoContainer" >
                        <div class="eventTitleContainer gridColSpan2 h3">
                            {{$event->name}}
                        </div>
                        <div class="eventTimeContainer">
                            <label for="startContainer" class="h5 fw-bold">{{ __('properties.starting_time') }}</label>
                            <div id="startContainer" class="border border-dark border-3 rounded-3 my-2 bg-light p-3 d-flex justify-content-center">
                                {{$event->starting_time}}
                            </div>
                        </div>
                        <div class="eventTimeContainer">
                            <label for="endContainer" class="h5 fw-bold">{{ __('properties.ending_time') }}</label>
                            <div id="endContainer" class="border border-dark border-3 rounded-3 my-2 bg-light p-3 d-flex justify-content-center">
                                {{$event->ending_time}}
                            </div>
                        </div>     
                        <div class="gridColSpan2 eventDescriptionContainer">
                            <label for="descriptionContainer" class="h5 fw-bold">{{ __('properties.description') }}</label>
                            <div id="descriptionContainer" class="border border-dark border-3 rounded-3 my-2 bg-light p-3">
                                {{$event->description}}
                            </div>
                        </div> 
                    </div>
                </div>
                @endforeach
            </div>
        </div> 
@endsection