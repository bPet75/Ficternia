
<div class="objectCard horizontalCard {{$event->type == "chapter" ? 'chapterEvent':''}}{{$event->type == "default" ? 'defaultEvent':''}}{{$event->type == "status" ? 'statusEvent':''}}">
    <div class="objectInfoHolder horizontal">
        <div class="objectName horizontal">{{$event->name}}</div>
        <div class="twoObjectInfo">
            <div>{{ __('menu.timeline') }}: {{$event->starting_time}} - {{$event->ending_time}}</div>
        </div>
        <div class="descriptionRow">
            <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
            <div class="objectDescription">{{$event->description !="" ? $event->description:'N/A'}}</div>
        </div>
    </div>
    <div class="objectControlButtonContainer horizontal">
        <a href="" class="objectControlButton horizontal gridCenterText objectModalButton" data-bs-toggle="modal" data-bs-target="#">&#128065;</a>
        <a href="{{ route('updateEvent', ['projId' => $event->plus_content["projId"], 'id' => $event->id, 'type' => 'major']) }}" class="objectControlButton horizontal gridCenterText updateButton">&#128393;</a>
        <a href="{{ route('removeEvent', ['projId' => $event->plus_content["projId"], 'id' => $event->id]) }}" class="objectControlButton horizontal gridCenterText objectRemoveButton">&#128465;</a>
    </div>
</div>


{{--

 
                <div class="eventInfoRow descRow">
                    <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                    <div class="objectDescription">{{$event->description}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
@isset($event->childs)
    
@each('components.partials.eventCard', $event->childs, 'event')
@endisset