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

          @if (count($premiumAgents))
              <div class="row mt-5">
                
                    
                  <div class="col-md-12">
                    <h3 class="agent-partner h5 ml-2">More agents</h3>
                  </div>

                    @foreach ($premiumAgents as $a)
                      <div class="col-md-4 col-sm-6">
                        <a href="{{ route('agent.details', ['id' => $a->id]) }}">
                            <div class="card ml-1 mr-1 bx-shadow mt-3">
                                <div class="card-body">
                                    <h5>{{ $a->user->name }}</h5>
                                    <p>
                                        {{ $a->state->name }} <br>
                                        {{ $a->city->name }} <br>

                                        @if ($a->landmark)
                                            {{ $a->landmark->name }} <br>
                                        @endif

                                        @if ($a->area)
                                            {{ $a->area->area }}
                                        @endif
                                    </p>

                                    <h6>{{ $a->user->mobile }}</h6>

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