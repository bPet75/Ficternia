<div class="subNavContainer">
    <a href="{{route('chooseStory',["type"=>"datacollecting","id" =>$data["projId"]])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'story' ? 'active':''}}">{{ __('menu.stories') }}</a>
    <a href="{{route('characters',$data["projId"])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'character' ? 'active':''}}">{{ __('menu.characters') }}</a>
    <a href="{{route('locations',$data["projId"])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'location' ? 'active':''}}">{{ __('menu.locations') }}</a>
    <a href="{{route('religions',$data["projId"])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'religion' ? 'active':''}}">{{ __('menu.religions') }}</a>
    <a href="{{route('events',$data["projId"])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'event' ? 'active':''}}">{{ __('menu.events') }}</a>
    <a href="{{route('timeline',$data["projId"])}}" 
        class="subNavButton navButton {{$data["dataType"] == 'timeline' ? 'active':''}}">{{ __('menu.timeline') }}</a>
</div>