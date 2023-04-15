<div class="subNavContainer">
    <a class="subNavButton navButton " href="{{url()->previous()}}"> &#x2190; </a>
    <a class="subNavButton navButton {{$data["dataType"] == 'draft' ? 'active':''}}" href="{{route('GetDrafts', ['projId'=>$data['projId'],'storyId'=>$data['storyId']])}}"> {{ __('menu.drafts') }} </a>
    <a class="subNavButton navButton {{$data["dataType"] == 'note' ? 'active':''}}" href="{{route('GetNotes', ['projId'=>$data['projId'],'storyId'=>$data['storyId']])}}"> {{ __('menu.notes') }} </a>
    <a class="subNavButton navButton {{$data["dataType"] == 'collection' ? 'active':''}}" href="{{route('GetCollections', ['projId'=>$data['projId'],'storyId'=>$data['storyId']])}}"> {{ __('menu.collections') }} </a>
    <a class="subNavButton navButton {{$data["dataType"] == 'timeline' ? 'active':''}}" href="{{route('timeline',$data["projId"])}}"> {{ __('menu.timeline') }} </a>
    
</div>