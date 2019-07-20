@extends('layouts.landing')

@section('content')

   {{-- section promote --}}
    {{-- <section id="promote" class="mt-4">
        <div class="container-fluid ">
            <div class="cards-promote">
                <div class="row no-gutters">
                    <div class="col-md-6 col-lg-3 d-flex align-items-center">
                        <div class="card card-promote bx-shadow mx-1">
                            <div class="card-body p-1">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4">
                                        <img class="card-img" src="{{asset('img/img3.jpeg')}}" class="card-img"
                                            alt="...">
                                    </div>
                
                
                                    <div class="col-md-8">
                
                                       <div class="card-content p-2">
                                            <h5 class="card-title mb-1">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text.</p>
                                       </div>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-center">
                        <div class="card card-promote bx-shadow mx-1">
                            <div class="card-body p-1">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4">
                                        <img class="card-img" src="{{ asset('img/img3.jpeg') }}" class="card-img" alt="...">
                                    </div>
                    
                    
                                    <div class="col-md-8">
                    
                                        <div class="card-content p-2">
                                            <h5 class="card-title mb-1">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text.</p>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-center">
                        <div class="card card-promote bx-shadow mx-1">
                            <div class="card-body p-1">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4">
                                        <img class="card-img" src="{{ asset('img/img3.jpeg') }}" class="card-img" alt="...">
                                    </div>
                    
                    
                                    <div class="col-md-8">
                    
                                        <div class="card-content p-2">
                                            <h5 class="card-title mb-1">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text.</p>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-flex align-items-center">
                        <div class="card card-promote bx-shadow mx-1">
                            <div class="card-body p-1">
                                <div class="row no-gutters align-items-center">
                                    <div class="col-md-4">
                                        <img class="card-img" src="{{ asset('img/img3.jpeg') }}" class="card-img" alt="...">
                                    </div>
                    
                    
                                    <div class="col-md-8">
                    
                                        <div class="card-content p-2">
                                            <h5 class="card-title mb-1">Card title</h5>
                                            <p class="card-text">This is a wider card with supporting text.</p>
                                        </div>
                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="container pt-5" id="filterForm">
        <h1 class="d-none">Filter results</h1>
        <div class="row">
            <div class="col-12">
                <form class="form-inline filter-form">
                    <div class="form-group mb-2">
                        <label for="state" class="sr-only">State</label>
                        <select name="state" id="state" class="form-control js-state-field">
                            <option value="0">Choose state</option>
                            @foreach ($states as $state)
                                <option value="{{$state->id}}" @if($filter_state == $state->id) selected @endif>{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="city" class="sr-only">City</label>
                        <select name="city" id="city" class="form-control js-city-field" data-preselect="{{ $filter_city }}">
                            <option value="">Choose city</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filter results</button>
                </form>
            </div>
        </div>
    </section>

    {{-- property list --}}
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8">

                    @if (count($properties))
                        <h3>Property List</h3>

                        @foreach ($properties as $property)
                        
                            @if ($property->premium)
                                <div class="card ml-1 mr-1 bx-shadow mt-3">
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            <div class="premium-img" style="background-image: url('{{ $property->images ? $property->images[0] : asset('img/na.jpeg') }} ')"></div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <p class="card-text">{{ $property->state->name }} >> <span>{{ $property->city ? $property->city->name : null }}</span>
                                                    @if ($property->propertytypes->first())
                                                        >> <span>{{ $property->propertytypes->first()->type }}</span>                                                
                                                    @endif
                                                </p>
                                                <h5 class="card-title card-t1">{{ $property->raw_data->details }}</h5>

                                                <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
                                                    @if($property->areas->first()) 
                                                        {{$property->areas->first()->area}}
                                                    @endif
                                                    @if($property->landmarks->first()) 
                                                        {{$property->landmarks->first()->name}} 
                                                    @endif
                                                </p>
                                                @if($property->prices->first()) 
                                                    <p class="card-text"><i class="fa fa-inr" aria-hidden="true"></i> {{$property->prices->first()->price}}</p>
                                                @endif

                                                <p class="card-text my-3"><span class="card-text">Property Id: 
                                                    <span class="color-red" style="font-weight:bold;">{{ $property->id }}</span> , <span class="color-grey" style="font-weight:bold;">{{ $property->updated_at->format('Y-m-d') }}</span></span>
                                                </p>

                                                <a class="btn btn-primary mt-3 font-weight-normal" style="font-size: 14px" href="{{ route('show.property', ['id' => $property->id]) }}" target="_blank">
                                                    More Information
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card ml-1 mr-1 bx-shadow mt-3">
                                    <div class="card-body">
                                        <p class="card-text">{{ $property->state->name }} >> <span>{{ $property->city ? $property->city->name : null }}</span>
                                            @if ($property->propertytypes->first())
                                                >> <span>{{ $property->propertytypes->first()->type }}</span>                                                
                                            @endif
                                        </p>

                                        <p class="card-text left-info">
                                            Property Id: <span class="color-red" style="font-weight:bold;">{{ $property->id }}</span>,
                                            <span class="color-grey" style="font-weight:bold;">{{ $property->updated_at->format('Y-m-d') }}</span>
                                        </p>
                            
                                        <h5 class="card-title card-t1">{{ $property->raw_data->details }}</h5>
                                        <p class="card-text"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
                                            @if($property->areas->first()) 
                                                {{$property->areas->first()->area}}
                                            @endif
                                            @if($property->landmarks->first()) 
                                                {{$property->landmarks->first()->name}} 
                                            @endif
                                        </p>
                                        @if($property->prices->first()) <p class="card-text"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp; {{$property->prices->first()->price}}</p> @endif
                                        {{-- <p class="card-text"></p> --}}
                                        <a class="btn btn-primary mt-3 font-weight-normal" style="font-size: 14px" href="{{ route('show.property', ['id' => $property->id]) }}" target="_blank">
                                            More Information
                                        </a>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    @else
                        <h2 class="h4 text-center">No results found</h2>
                    @endif

                </div>

                <div class="col-md-4">
                    @if (count($agents))
                        <h3 class="agent-partner">Our Agent Partners</h3>

                        @foreach ($agents as $agent)
                            <a href="{{ route('agent.details', ['id' => $agent->id]) }}">
                                <div class="card ml-1 mr-1 bx-shadow mt-3">
                                    <div class="card-body">
                                        <h5 style="font-size: 16px">{{ $agent->user->name }}</h5>
                                        <p>
                                            {{ $agent->state->name }} <br>
                                            {{ $agent->city->name }} <br>

                                            @if ($agent->landmark)
                                                {{ $agent->landmark->name }} <br>
                                            @endif

                                            @if ($agent->area)
                                                {{ $agent->area->area }}
                                            @endif
                                        </p>

                                        <h6 style="font-size: 14px">{{ $agent->user->mobile }}</h6>

                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @endif

                </div>

                
            </div>

            <div class="mt-3" id="pagination-wrapper">
                {{ $properties->links() }}
            </div>

        </div>
    </section>

    {{-- buy sell --}}
    {{-- <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card ml-1 mr-1 bx-shadow mt-3">
                        <div class="card-body text-center">
                            <img src="{{ asset('img/postreq.png') }}" alt="">
                            <h5 class="card-title mt-3">Post your Requirement</h5>
                            <p class="card-text">Wanted to Property, Just List Requirement with ReraAgetns, we and our
                                agents will take care from showing property till
                                You Selected</p>
                            <button class="btn btn2 my-2 my-sm-0" type="submit">Post Your Requirement</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ml-1 mr-1 bx-shadow mt-3">
                        <div class="card-body text-center">
                            <img src="{{ asset('img/sales.png') }}" alt="">
                            <h5 class="card-title mt-3">Sell Your Property</h5>
                            <p class="card-text">Wanted to Property, Just List Requirement with ReraAgetns, we and our
                                agents will take care
                                from showing property till
                                You Selected</p>
                            <button class="btn btn1 my-2 my-sm-0" type="submit">Sell Your Property</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
@endsection

@section('javascripts')
    <script>
        var shouldScroll = {{ $shouldScroll }};

        if (shouldScroll) {
                $('html, body').animate({
                    scrollTop: $("#filterForm").offset().top
                }, 100);

        }
        // (function($){
        //     window.onbeforeunload = function(e) {
        //      window.name += ' [' + location.pathname + '[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString();
        //     };
        //     $.maintainscroll = function() {
        //         if(window.name.indexOf('[') > 0) {
        //             var parts = window.name.split('['); 
        //             window.name = $.trim(parts[0]);
        //             if( parts[parts.length - 3] == location.pathname ) {
        //                 window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
        //             } else {
        //                 window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
        //             }
        //         }
        //     };  
        //     $.maintainscroll();
        // })(jQuery);
    </script>
@endsection