@extends('layouts.frontend-master')

@section('content')
    <section class="" style="min-height:500px">
      <div class="container">
          <div class="row pt-5">  
              <div class="col-12">
                <div class="card bx-shadow">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                          <p class="card-text">{{ $property->state->name }} >> <span class="color-dark">{{ $property->city->name }}</span>
                            @if ($property->propertytypes->first())
                                >> <span class="color-dark">{{ $property->propertytypes->first()->type }}</span>                                                
                            @endif
                              <span class="card-text left-info">
                                  Property Id: <span class="color-red" style="font-weight:bold;">{{ $property->id }}</span>,
                                  <span class="color-grey" style="font-weight:bold;">{{ $property->updated_at->format('Y-m-d') }}</span>
                              </span>
                          </p>
                          <h4 class="card-t1">{{ $property->raw_data->details }}</h4>
                      </div>
                      <div class="col-md-6 mt-4">
                        <div class="">
                            <p>
                              <img class="icons-property" src="{{ asset('img/icons/placeholder.svg') }}" alt=""> &nbsp; Area : 
                              <span class="font-weight-bold">{{ $property->areas->first() ? $property->areas->first()->area : '' }} @if($property->landmarks->first()) , {{$property->landmarks->first()->name}} @endif</span>
                            </p>
                            <p><img class="icons-property" src="{{ asset('img/icons/price-tag.svg') }}" alt=""> &nbsp; Price : 
                              <span class="font-weight-bold">{{ $property->prices->first() ? $property->prices->first()->price : '' }}</span></p>
                            <p><img class="icons-property" src="{{ asset('img/icons/tools-and-utensils.svg') }}" alt=""> &nbsp; Measurement : 
                              <span style="font-weight:bold;">{{ $property->raw_data->measurement }}</span></p>
                        </div>
                      </div>  
                      
                      <div class="col-md-6 mt-4">
                          <div class="">
                              <p><img class="icons-property" src="{{ asset('img/icons/compass.svg') }}" alt=""> &nbsp; Face : 
                                @foreach ($property->faces as $face)
                                    <button class="btn btn-outline-primary btn-sm">{{ $face->face }}</button>
                                @endforeach
                              </p>

                              <p><img class="icons-property" src="{{ asset('img/icons/hotel.svg') }}" alt=""> &nbsp; Rooms : 
                                @foreach ($property->rooms as $room)
                                  <button class="btn btn-outline-primary btn-sm">{{ $room->type }}</button>
                                @endforeach
                              </p>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>

          @if ($office)
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title">This property is available at:</div>

                      <p class="font-weight-bold">
                        {!! nl2br(e($office->address)) !!}
                      </p>
                      @if ($office->map)
                        <a href="{{ $office->map }}" target="_blank" class="btn btn-light">View on Map</a>
                      @endif
                  </div>
                </div>
              </div>
            </div>
          @endif

          <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-title">To call the property owner download our mobile app.</div>

                  <a href="https://play.google.com/store/apps/details?id=in.idevia.reraagents" target="_blank">
                    <img src="{{ asset('img/download-on-the-app-store-icon-0.png') }}" alt="" class="playstore-img">
                  </a>
                    
                </div>
              </div>
            </div>
          </div>
      </div>
    </section>

    @if (count($premiumProperties))
        <section id="premium-properties" class="mt-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h3 class="h5 ml-2">You might also like</h3>
                @foreach ($premiumProperties as $property)
                  @if ($property->premium)
                    <div class="col-md-6">
                      <div class="card ml-1 mr-1 bx-shadow mt-3">
                          <div class="row no-gutters">
                              <div class="col-md-4">
                                  <div class="premium-img" style="background-image: url('{{ $property->firstImage }} ')"></div>
                              </div>
                              <div class="col-md-8">
                                  <div class="card-body">
                                      <p class="card-text">{{ $property->state->name }} >> <span>{{ $property->city ? $property->city->name : null }}</span>
                                          @if ($property->propertytypes->first())
                                              >> <span>{{ $property->propertytypes->first()->type }}</span>                                                
                                          @endif
                                      </p>
                                      <h5 class="card-title card-t1 text-truncate">{{ $property->decoded_raw_data->details }}</h5>

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

                                      <a class="btn btn-primary font-weight-normal" style="font-size: 14px" href="{{ route('show.property', ['id' => $property->id]) }}" target="_blank">
                                          More Information
                                      </a>

                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  @else
                    <div class="col-md-6">
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
                  
                              <h5 class="card-title card-t1 text-truncate">{{ $property->decoded_raw_data->details }}</h5>
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
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </section>
    @endif
@endsection