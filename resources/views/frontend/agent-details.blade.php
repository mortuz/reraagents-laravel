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
                        
                        <h5>{{ $agent->user->name }}</h5>
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

                        <h6>{{ $agent->user->mobile }}</h6>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>

      </div>
    </section>
@endsection