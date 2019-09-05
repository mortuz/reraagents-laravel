@extends('layouts.frontend-master')

@section('content')
    <section class="" style="min-height:500px">
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

          @if (count($otherOffices))
              <div class="row mt-5">
                
                    
                  <div class="col-md-12">
                    <h3 class="agent-partner h5 ml-2">More agent partners</h3>
                  </div>

                    @foreach ($otherOffices as $office)
                      <div class="col-md-4 col-sm-6">
                        <a href="{{ route('office.details', ['id' => $office->id]) }}">
                          <div class="card ml-1 mr-1 bx-shadow mt-3">
                            <div class="card-body">
                                @if ($office->logo)
                                    <img src="{{ asset($office->logo) }}" alt="{{ $office->name }}" style="height: 50px; margin-bottom: 15px;">
                                @endif

                                <h5 style="font-size: 16px">{{ $office->name }}</h5>
                                <p>
                                    {{ $office->city->name }} <br>
                                    {{ $office->state->name }} <br>
                                </p>

                            </div>
                          </div>
                        </a>
                      </div>
                    @endforeach
              </div>
          @endif
      </div>
    </section>
@endsection