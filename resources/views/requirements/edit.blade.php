@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Update property </h3>

  </div>

  <form autocomplete="off" action="{{ route('requirement.update', ['requirement' => $requirement->id]) }}" method="POST">
    @csrf
    @method('patch')
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Address information</div>
            
            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control js-state-field{{ $errors->has('state') ? ' is-invalid' : '' }}">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $requirement->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('state'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="city">City</label>
              <select name="city" id="city" class="form-control js-city-field{{ $errors->has('city') ? ' is-invalid' : '' }}" data-preselect="{{ $requirement->city_id }}">
              </select>

              @if ($errors->has('city'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('city') }}</strong>
                </span> 
              @endif
            </div>

            <div class="form-group">
              <label for="area">Area</label>
              <input id="area" name="area" data-preselect="{{ $requirement->area }}" data-url={{ route('api.area.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="landmark">Landmark</label>
              <input id="landmark" name="landmark" data-preselect="{{ $requirement->landmark }}" data-url={{ route('api.landmark.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="type">requirement type</label>
              <input id="type" name="type" data-preselect="{{ $requirement->type }}" data-url={{ route('api.propertytype.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="bhk">Room</label>
              <input id="bhk" name="bhk" data-preselect="{{ $requirement->rooms }}" data-url={{ route('api.bhk.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="face">Face</label>
              <input id="face" name="face" data-preselect="{{ $requirement->face }}" data-url={{ route('api.faces.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="price">Price</label>
              <input id="price" name="price" data-preselect="{{ $requirement->price }}" data-url={{ route('api.price.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
          </div>
        </div>
        
        <div class="card mt-4">
          <div class="card-body">
            <div class="card-title">Builder and agent</div>
            
            <div class="form-group">
              <label for="agents">Agents</label>
              <input id="agents" name="agents" data-preselect="{{ $requirement->agents }}" data-url={{ route('api.agents.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="builders">Builders</label>
              <input id="builders" name="builders" data-preselect="{{ $requirement->builders }}" data-url={{ route('api.builders.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="ventures">Ventures</label>
              <input id="ventures" name="ventures" data-preselect="{{ $requirement->ventures }}" data-url={{ route('api.venture.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

          </div>
        </div>

        <div class="card mt-4">
          <div class="card-body">

            <div class="form-group">
              <label for="contact">Contact no</label>
              <input type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" id="contact" name="contact" value="{{ $requirement->mobile }}">

              @if ($errors->has('contact'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="call_date">Call date</label>
              <input type="datetime-local" class="form-control{{ $errors->has('call_date') ? ' is-invalid' : '' }}" id="call_date" name="call_date" value="{{ $requirement->call_date }}">

              @if ($errors->has('call_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('call_date') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="visit_date">Visit date</label>
              <input type="date" class="form-control{{ $errors->has('visit_date') ? ' is-invalid' : '' }}" id="visit_date" name="visit_date" value="{{ $requirement->visit_date }}">

              @if ($errors->has('visit_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('visit_date') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="handler">Handled by</label>
              <select class="form-control" id="handler" name="handler">
                <option value="0" {{ $requirement->handled_by == 0 ? 'selected' : '' }}>Agent</option>
                <option value="1" {{ $requirement->handled_by == 1 ? 'selected' : '' }}>Company</option>
              </select>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control js-status" id="status" name="status">
                <option value="0" {{ $requirement->status == 0 ? 'selected' : '' }}>New</option>
                <option value="1" {{ $requirement->status == 1 ? 'selected' : '' }}>Release</option>
                <option value="2" {{ $requirement->status == 2 ? 'selected' : '' }}>Approve</option>
                <option value="3" {{ $requirement->status == 3 ? 'selected' : '' }}>Reject</option>
              </select>
            </div>

            <div class="form-group js-message {{$requirement->status != 2 ? 'd-none': ''}}">
              <label for="message">Reason for rejection</label>
              <textarea name="message" id="message" rows="3" class="form-control"></textarea>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Requirement information</div>

            <label for="User value">User value</label>
            <div class="card">
              <div class="card-body bg-light">

                <div class="form-group">
                  <label for="raw_budget">Budget</label>
                  <input type="text" class="form-control{{ $errors->has('raw_budget') ? ' is-invalid' : '' }}" id="raw_budget" name="raw_budget" value="{{ $requirement->raw['budget'] }}">

                  @if ($errors->has('raw_budget'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Budget is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="raw_details">Details</label>
                  <input type="text" class="form-control{{ $errors->has('raw_details') ? ' is-invalid' : '' }}" id="raw_details" name="raw_details" value="{{ $requirement->raw['details'] }}">

                  @if ($errors->has('raw_details'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Details are required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="cstatus">Customer status</label>
                  <select class="form-control" id="status" name="cstatus">
                    <option value="0">Please select</option>
                    @foreach ($cstatus as $st)
                      <option value="{{ $st->id }}" {{ $st->status == $requirement->custormer_status_id }}>{{ $st->status }}</option>    
                    @endforeach
                  </select>
                </div>

              </div>
            </div>
          </div>
        </div>

        @if ($requirement->working_agent > 0)
          <div class="card mt-3">
            <div class="card-body">
              <p class="text-muted card-title">Working agent</p>
              <h3 class="h4">{{ $requirement->workingAgent->user->name }}</h3>
              <p>
                {{ $requirement->workingAgent->user->mobile }} <br>
                {{ $requirement->workingAgent->state->name }} <br>
                {{ $requirement->workingAgent->city->name }} <br>
              </p>

              <div class="form-check mr-sm-2">
                <label class="form-check-label">
                <input type="checkbox" id="release-check" class="form-check-input" name="release" value="1"> Release from the agent <i class="input-helper"></i></label>
              </div>

              
            </div>
          </div>
        @endif

        <div class="form-group">
          <label for="release_message">Add comment(optional)</label>
          <textarea name="release_message" id="release_message" rows="3" class="form-control"></textarea>
        </div>
        
      </div>

    </div>

      <button class="btn btn-gradient-primary mt-3" type="submit">Update Property</button>
    </form>

  @endsection

  @section('javascript')
    
      <script>

        $(document).on('city_init', function() {
          console.log('selectize')
          initSelectize();
        });

        $(document).on('city_changed', function() {
          console.log('city changed');
        });

        $('.js-status').on('change', function() {
          var value = $(this).val();

          // if value = 2 show message
          if (value == 3) {
            $('.js-message').removeClass('d-none');
          } else {
            $('.js-message').addClass('d-none');
          }
        });

        $('#release-check').on('change', function() {

          if($(this).is(':checked')) {
            $('.js-release-message').removeClass('d-none');
          } else {
            $('.js-release-message').addClass('d-none');
          }
        });
      </script>
  @endsection