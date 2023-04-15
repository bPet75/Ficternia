<nav class="navbar navbar-expand-lg bg-black text-light px-5">
    <div class="container-fluid ">
        <a href="{{route('home')}}" class="navbar-brand text-uppercase text-light">Fictiernia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active text-light" aria-current="page" href="{{route('home')}}">{{ __('menu.home_page') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="">{{ __('menu.genres') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="">{{ __('menu.search') }}</a>
              </li>
              <li class="nav-item dropdown">
                <button class="btn btn-link text-decoration-none text-reset dropdown-toggle" type="button" id="navbarDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                  {{ __('menu.my_reading_lists') }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li class="dropdown-item dropend">
                    <button type="button" class="btn btn-link text-decoration-none text-reset dropdown-toggle" id="navbarReadingListButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Another action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarReadingListButton">
                      <li><a class="dropdown-item" href="#">a</a></li>
                      <li><a class="dropdown-item" href="#">a</a></li>
                      <li><a class="dropdown-item" href="#">a</a></li>
                    </ul>
                  </li>
                  <li class="dropdown-item dropend">
                    <button type="button" class="btn btn-link text-decoration-none text-reset dropdown-toggle" id="navbarReadingListButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Another action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarReadingListButton">
                      <li><a class="dropdown-item" href="#">a</a></li>
                      <li><a class="dropdown-item" href="#">a</a></li>
                      <li><a class="dropdown-item" href="#">a</a></li>
                    </ul>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">{{ __('menu.add_new_list') }}</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="">{{ __('menu.my_books') }}</a>
              </li>
            </ul>
            @if (isset($data->filter_data))
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
              {{ __('buttons.filter') }}
            </a>
            <div class="collapse"  id="filterCollapse">

              <form action="{{route('filterStories')}}" method="POST" class="searchBarContainer "">
                @csrf
                <div class="searchFilters">
                  <input type="text" name="title" placeHolder="cím" >
                  <div class="filtersInnerContainer">
                    <div class="filters">
                      <input type="text" name="owner">
                      <select name="genre_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->genres as $genre)
                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                        @endforeach
                      </select>
                      <select name="audience_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->audiences as $gaudience)
                            <option value="{{$gaudience->id}}">{{$gaudience->name}}</option>
                        @endforeach
                      </select>
                      <select name="state_id" id="">
                        <option></option>
                        @foreach ($data->filter_data->state as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="buttonContainer">
                      <button type="submit">asdasdas</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            @endif
            <a href="{{route('setLanguage', "en")}}" class="btn btn-secondary me-3">{{ __('buttons.lang_en') }}</a>
            <a href="{{route('setLanguage', "hu")}}" class="btn btn-secondary me-3">{{ __('buttons.lang_hu') }}</a>
             @if(!Auth::user())
              <div class="d-flex">
                <a href="{{route('register')}}" class="btn btn-secondary me-2">{{ __('menu.register') }}</a>
                <a href="{{route('login')}}" class="btn btn-secondary">{{ __('menu.login') }}</a>
              </div>
            @else
              <div class="d-flex">
                <a href="{{route('userPage', ['userId' => Auth::User()->id])}}" class="btn btn-secondary me-3">{{ __('buttons.my_page') }}</a>
                <a href="{{route('home')}}" class="btn btn-secondary me-3">{{ __('menu.reading') }}</a>
                <a href="{{route('workType')}}" class="btn btn-secondary me-3">{{ __('menu.writing') }}</a>
                <a href="{{route('getUserSettings', Auth::User()->id)}}" class="btn btn-secondary me-3">{{ __('buttons.my_data') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-secondary" type="submit">{{ __('menu.log_out') }}</button>
                </form>
              </div>
            @endif
            
          </div>
    </div>
</nav>