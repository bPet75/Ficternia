@extends('main')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" integrity="sha512-eMxdaSf5XW3ZW1wZCrWItO2jZ7A9FhuZfjVdztr7ZsKNOmt6TUMTQgfpNoVRyfPE5S9BC0A4suXzsGSrAOWcoQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('css/browser/index.css') }}" rel="stylesheet" type="text/css" >
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js" integrity="sha512-j+F4W//4Pu39at5I8HC8q2l1BNz4OF3ju39HyWeqKQagW6ww3ZF9gFcu8rzUbyTDY7gEo/vqqzGte0UPpo65QQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('js/indexSliders.js')}}"></script>

@endpush
@section('content')
    <div class="indexContainer">
      @if (count($data->alerted_stories) > 0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">Új fejezet érkezett!</div>
              <div class="{{count($data->alerted_stories) > 0 ? 'storyContainer':'hide'}}">
                @foreach ($data->alerted_stories as $story)
                  @if ($loop->first || $loop->index == 6)
                  <div class="slide slideFade ">
                    <div class="slideInner">
                  @endif
                    <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                      <div class="objectHolder horizontal">
                          <div class="imageContainer characterImage">
                            <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                          </div>
                          <div class="objectInfoHolder horizontal">
                              <div class="objectName horizontal">{{$story->title}}</div>
                              <div class="twoObjectInfo">
                                  <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                                  <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                                  <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                              </div>
                              <div class="descriptionRow">
                                  <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                  <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                              </div>
                          </div>
                      </div>
                    </a>
                  @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                    @if($loop->last)
                      @if($loop->index == 0)
                        
                        <div></div>
                        <div></div>
                      @elseif($loop->index == 1)
                        <div></div>
                      @endif
                    @endif
                    </div>
                  </div>
                  @endif
              @endforeach
              </div>
          </div>
        </div>
      @endif
      @if (count($data->stories) > 0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">{{ __('static_text.check_out_these') }}</div>
              <div class="storyContainer">
                @foreach ($data->stories as $story)
                  @if ($loop->first || $loop->index == 6)
                  <div class="slide slideFade">
                    <div class="slideInner">
                  @endif
                    <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                      <div class="objectHolder horizontal">
                          <div class="imageContainer characterImage">
                            <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                          </div>
                          <div class="objectInfoHolder horizontal">
                              <div class="objectName horizontal">{{$story->title}}</div>
                              <div class="twoObjectInfo">
                                  <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                                  <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                                  <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                              </div>
                              <div class="descriptionRow">
                                  <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                  <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                              </div>
                          </div>
                      </div>
                    </a>
                  @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                    @if($loop->last)
                      @if($loop->index == 0)
                        
                        <div></div>
                        <div></div>
                      @elseif($loop->index == 1)
                        <div></div>
                      @endif
                    @endif
                    </div>
                  </div>
                  @endif
              @endforeach
              </div>
          </div>
        </div>
      @endif
      @if (count($data->stories_by_genre1) >0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">{{$data->rand_genre1 }}</div>
              <div class="storyContainer">
                @foreach ($data->stories_by_genre1 as $story)
                  @if ($loop->first || $loop->index == 6)
                  <div class="slide slideFade">
                    <div class="slideInner">
                  @endif
                    <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                      <div class="objectHolder horizontal">
                          <div class="imageContainer characterImage">
                            <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                          </div>
                          <div class="objectInfoHolder horizontal">
                              <div class="objectName horizontal">{{$story->title}}</div>
                              <div class="twoObjectInfo">
                                  <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                                  <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                                  <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                              </div>
                              <div class="descriptionRow">
                                  <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                  <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                              </div>
                          </div>
                      </div>
                    </a>
                  @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                    @if($loop->last)
                      @if($loop->index == 0)
                        
                        <div></div>
                        <div></div>
                      @elseif($loop->index == 1)
                        <div></div>
                      @endif
                    @endif
                    </div>
                  </div>
                  @endif
              @endforeach
              </div>
          </div>
        </div>
      @endif
      @if (count($data->hidden_gems) >0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">Rejtett gyöngyszemek</div>
            <div class="storyContainer">
              @foreach ($data->hidden_gems as $story)
                @if ($loop->first || $loop->index == 6)
                <div class="slide slideFade">
                  <div class="slideInner">
                @endif
                <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                  <div class="objectHolder horizontal">
                      <div class="imageContainer characterImage">
                        <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                      </div>
                      <div class="objectInfoHolder horizontal">
                          <div class="objectName horizontal">{{$story->title}}</div>
                          <div class="twoObjectInfo">
                              <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                              <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                              <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                          </div>
                          <div class="descriptionRow">
                              <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                              <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                          </div>
                      </div>
                  </div>
                </a>
                @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                  @if($loop->last)
                    @if($loop->index == 0)
                      
                      <div></div>
                      <div></div>
                    @elseif($loop->index == 1)
                      <div></div>
                    @endif
                  @endif
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      @endif
      @if (count($data->stories_by_genre2) >0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">{{$data->rand_genre2 }}</div>
              <div class="storyContainer">
                @foreach ($data->stories_by_genre2 as $story)
                  @if ($loop->first || $loop->index == 6)
                  <div class="slide slideFade">
                    <div class="slideInner">
                  @endif
                    <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                      <div class="objectHolder horizontal">
                          <div class="imageContainer characterImage">
                            <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                          </div>
                          <div class="objectInfoHolder horizontal">
                              <div class="objectName horizontal">{{$story->title}}</div>
                              <div class="twoObjectInfo">
                                  <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                                  <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                                  <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                              </div>
                              <div class="descriptionRow">
                                  <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                  <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                              </div>
                          </div>
                      </div>
                    </a>
                  @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                    @if($loop->last)
                      @if($loop->index == 0)
                        
                        <div></div>
                        <div></div>
                      @elseif($loop->index == 1)
                        <div></div>
                      @endif
                    @endif
                    </div>
                  </div>
                  @endif
              @endforeach
              </div>
          </div>
        </div>
      @endif
      @if (count($data->stories_by_genre3) > 0)
        <div class="section">
          <div class="storySlider">
            <div class="sliderTitle">{{$data->rand_genre3 }}</div>
              <div class="storyContainer">
                @foreach ($data->stories_by_genre3 as $story)
                  @if ($loop->first || $loop->index == 6)
                  <div class="slide slideFade">
                    <div class="slideInner">
                  @endif
                    <a class="objectCard horizontalCard browsing linkColorRemove" href="{{route('storyPage',$story->id)}}">
                      <div class="objectHolder horizontal">
                          <div class="imageContainer characterImage">
                            <img class="picture" src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="100%">
                          </div>
                          <div class="objectInfoHolder horizontal">
                              <div class="objectName horizontal">{{$story->title}}</div>
                              <div class="twoObjectInfo">
                                  <div>{{ __('properties.genre') }}: {{$story->genre != "" ? $story->genre:'N/A'}}</div>
                                  <div>{{ __('properties.state') }}: {{$story->state != "" ? $story->state:'N/A'}}</div>
                                  <div>{{ __('properties.views') }}: {{$story->views != "" ? $story->views:'N/A'}}</div>
                              </div>
                              <div class="descriptionRow">
                                  <div class="objectInfoNameCol">{{ __('properties.description') }}:</div>
                                  <div class="objectDescription">{{isset($story->description) ? $story->description:'N/A'}}</div>
                              </div>
                          </div>
                      </div>
                    </a>
                  @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                    @if($loop->last)
                      @if($loop->index == 0)
                        
                        <div></div>
                        <div></div>
                      @elseif($loop->index == 1)
                        <div></div>
                      @endif
                    @endif
                    </div>
                  </div>
                  @endif
                  
              @endforeach
              </div>
          </div>
        </div>
      @endif


      {{--
      <div class="storySlider ">
        <div class="sliderTitle">{{ __('static_text.check_out_these') }}</div>
        <div id="carouselExampleIndicators" class="carousel slide storySlideInner" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($data->stories as $story)
              @if ($loop->first || $loop->index == 6)
                <div class="carousel-item {{$loop->first ? 'active':''}} ItemContainer">
                  <div class="storyCardWrapper">
              @endif
                    <a class="storyCard" href="{{route('storyPage',$story->id)}}">
                      <div class="cardLeft">
                        <div class="storyCover">
                          <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                        </div>
                      </div>
                      <div class="cardRight">
                        <div class="storyTitle">
                          {{$story->title}}
                        </div>
                        <div class="general">
                          <div> {{$story->genre}} </div>
                          <div> {{$story->audience}} </div>
                          <div> {{$story->state}} </div>
                          <div> {{$story->views}} </div>
                        </div>
                        <div class="description">
                          {{$story->description}}
                        </div>
                      </div>
                    </a> 
              @if ($loop->index == 5 || $loop->index == 10 || $loop->last)
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          
        </div>
        
      </div>
      --}}



      {{--
      <div class="storySlider ">
        <div class="sliderTitle">{{$data->rand_genre1}}</div>
        <div id="carouselExampleIndicators" class="carousel slide storySlideInner" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($data->stories_by_genre1 as $story)
              @if ($loop->first || $loop->index == 6)
                <div class="carousel-item {{$loop->first ? 'active':''}} ItemContainer">
                  <div class="storyCardWrapper">
              @endif
                    <a class="storyCard" href="{{route('storyPage',$story->id)}}">
                      <div class="cardLeft">
                        <div class="storyCover">
                          <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                        </div>
                      </div>
                      <div class="cardRight">
                        <div class="storyTitle">
                          {{$story->title}}
                        </div>
                        <div class="general">
                          <div> {{$story->genre}} </div>
                          <div> {{$story->audience}} </div>
                          <div> {{$story->state}} </div>
                          <div> {{$story->views}} </div>
                        </div>
                        <div class="description">
                          {{$story->description}}
                        </div>
                      </div>
                    </a> 
              @if ($loop->index == 5 || $loop->index == 10)
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          
        </div>
        
      </div>
      <div class="storySlider ">
        <div class="sliderTitle">{{$data->rand_genre2}}</div>
        <div id="carouselExampleIndicators" class="carousel slide storySlideInner" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($data->stories_by_genre2 as $story)
              @if ($loop->first || $loop->index == 6)
                <div class="carousel-item {{$loop->first ? 'active':''}} ItemContainer">
                  <div class="storyCardWrapper">
              @endif
                    <a class="storyCard" href="{{route('storyPage',$story->id)}}">
                      <div class="cardLeft">
                        <div class="storyCover">
                          <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                        </div>
                      </div>
                      <div class="cardRight">
                        <div class="storyTitle">
                          {{$story->title}}
                        </div>
                        <div class="general">
                          <div> {{$story->genre}} </div>
                          <div> {{$story->audience}} </div>
                          <div> {{$story->state}} </div>
                          <div> {{$story->views}} </div>
                        </div>
                        <div class="description">
                          {{$story->description}}
                        </div>
                      </div>
                    </a> 
              @if ($loop->index == 5 || $loop->index == 10)
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          
        </div>
        
      </div>
      <div class="storySlider ">
        <div class="sliderTitle">{{$data->rand_genre3}}</div>
        <div id="carouselExampleIndicators" class="carousel slide storySlideInner" data-bs-ride="carousel">
          <div class="carousel-inner">
            @foreach ($data->stories_by_genre3 as $story)
              @if ($loop->first || $loop->index == 6)
                <div class="carousel-item {{$loop->first ? 'active':''}} ItemContainer">
                  <div class="storyCardWrapper">
              @endif
                    <a class="storyCard" href="{{route('storyPage',$story->id)}}">
                      <div class="cardLeft">
                        <div class="storyCover">
                          <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                        </div>
                      </div>
                      <div class="cardRight">
                        <div class="storyTitle">
                          {{$story->title}}
                        </div>
                        <div class="general">
                          <div> {{$story->genre}} </div>
                          <div> {{$story->audience}} </div>
                          <div> {{$story->state}} </div>
                          <div> {{$story->views}} </div>
                        </div>
                        <div class="description">
                          {{$story->description}}
                        </div>
                      </div>
                    </a> 
              @if ($loop->index == 5 || $loop->index == 10)
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          
        </div>
        
      </div>
       --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


      {{--
        <div class="swiper mySwiper">
          <div class="swiper-wrapper">
            @foreach ($data->stories as $story)
                <div class="swiper-slide">
                  <div class="storyCard">
                    <div class="cardLeft">
                      <div class="storyCover">
                        <img src="{{ $story->img_path=="" ? (asset('images/default/default.png')):(asset('images/story/'.$story->img_path)) }}" alt="" width="175" height="250">
                      </div>
                    </div>
                    <div class="cardRight">
                      <div class="storyTitle">
                        {{$story->title}}
                      </div>
                      <div class="general">
                        <div> {{$story->genre}} </div>
                        <div> {{$story->audience}} </div>
                        <div> {{$story->state}} </div>
                        <div> {{$story->views}} </div>
                      </div>
                      <div class="description">
                        {{$story->description}}
                      </div>
                    </div>
                  </div> 
                </div>
            @endforeach
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
          <div class="autoplay-progress">
            <svg viewBox="0 0 48 48">
              <circle cx="24" cy="24" r="20"></circle>
            </svg>
            <span></span>
          </div>
        </div>
        <div class="StoriesContainer">
          <div class="StoriesSlide">
            @foreach ($data->stories_by_genre as $stories)
                
            @endforeach
          </div>
        </div>
        --}}
    </div>

@endsection