@extends('layouts.frontend-master')

@section('content')
  <section class="">
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">
              <div class="card">
                <div class="card-body">

                  <div class="row align-items-center">
                    <div class="col-md-4 order-2">
                      @if ($office->logo)
                        <img src="{{asset($office->logo)}}" alt="{{$office->name}}" class="my-3" style="width: 100%">
                      @endif
                    </div>

                    <div class="col-md-8 order-1">
                      <h5>{!!$office ? $office->name . '<br>' : '' !!}</h5>
                      <h4 class="card-t1">
                        {!! nl2br(e($office->address)) !!}
                      </h4>

                      @if ($office->terms)
                        <p class="mb-0 text-danger mt-3">Terms and conditions:</p>
                        <h5 class=" h6 mt-1">
                          {!! nl2br(e($office->terms)) !!}
                        </h5>
                      @endif

                      @if ($office->map)
                        <a href="{{ $office->map }}" target="_blank" class="btn btn-light">View on Map</a>
                      @endif
                    </div>
                  </div>
                    
                </div>
              </div>
            </div>
          </div>
    </div>
  </section>

  @if (count($office->properties))
        <section id="premium-properties" class="mt-5">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h3 class="h5 ml-2">Listed properties</h3>
              </div>

              @foreach ($office->properties as $property)
                  @if ($property->premium)
                    <div class="col-md-6">
                      <div class="card ml-1 mr-1 mt-3 bx-shadow">
                          <div class="row no-gutters">
                              <div class="col-md-3">
                                  <div class="premium-img" style="background-image: url('{{ $property->firstImage }} ')"></div>
                              </div>
                              <div class="col-md-9">
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

                                      <p class="card-text mb-3"><span class="card-text">Property Id: 
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
        </section>
    @endif

@endsection