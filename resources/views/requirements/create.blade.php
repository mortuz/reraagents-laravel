@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create requirement </h3>

  </div>

  <form autocomplete="off" action="{{ route('requirement.store') }}" method="POST">
    @csrf
    
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Address information</div>
            
            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control js-state-field{{ $errors->has('state') ? ' is-invalid' : '' }}">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
              <select name="city" id="city" class="form-control js-city-field{{ $errors->has('city') ? ' is-invalid' : '' }}" data-preselect="{{ old('city') }}">
              </select>

              @if ($errors->has('city'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('city') }}</strong>
                </span> 
              @endif
            </div>

            <div class="form-group">
              <label for="area">Area</label>
              <input id="area" name="area" data-preselect="{{ old('area') }}" data-url={{ route('api.area.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="landmark">Landmark</label>
              <input id="landmark" name="landmark" data-preselect="{{ old('landmark') }}" data-url={{ route('api.landmark.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="type">Property type</label>
              <input id="type" name="type" data-preselect="{{ old('type') }}" data-url={{ route('api.propertytype.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="bhk">Room</label>
              <input id="bhk" name="bhk" data-preselect="{{ old('bhk') }}" data-url={{ route('api.bhk.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="face">Face</label>
              <input id="face" name="face" data-preselect="{{ old('face') }}" data-url={{ route('api.faces.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="budget">Budget</label>
              <input id="budget" name="budget" data-preselect="{{ old('budget') }}" data-url={{ route('api.price.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
          </div>
        </div>
        
        <div class="card mt-4">
          <div class="card-body">
            <div class="card-title">Builder and agent</div>
            
            <div class="form-group">
              <label for="agents">Agents</label>
              <input id="agents" name="agents" data-preselect="{{ old('agents') }}" data-url={{ route('api.agents.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="builders">Builders</label>
              <input id="builders" name="builders" data-preselect="{{ old('builers') }}" data-url={{ route('api.builders.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="ventures">Ventures</label>
              <input id="ventures" name="ventures" data-preselect="{{ old('ventures') }}" data-url={{ route('api.venture.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

          </div>
        </div>

        <div class="card mt-4">
          <div class="card-body">

            <div class="form-group">
              <label for="contact">Contact no</label>
              <input type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" id="contact" name="contact" value="{{ old('contact') }}">

              @if ($errors->has('contact'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="handler">Handled by</label>
              <select class="form-control" id="handler" name="handler">
                <option value="0">Agent</option>
                <option value="1">Company</option>
              </select>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="0">New</option>
                <option value="1">Release</option>
                <option value="2">Approve</option>
                <option value="3">Reject</option>
              </select>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Property information</div>

            <label for="User value">User value</label>
            <div class="card">
              <div class="card-body bg-light">
                
                <div class="form-group">
                  <label for="raw_budget">Price</label>
                  <input type="text" class="form-control{{ $errors->has('raw_budget') ? ' is-invalid' : '' }}" id="raw_budget" name="raw_budget" value="{{ old('raw_budget') }}">

                  @if ($errors->has('raw_budget'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Budget is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="raw_details">Requirement details</label>
                  <textarea name="raw_details" id="raw_details" cols="30" rows="5" class="form-control{{ $errors->has('raw_details') ? ' is-invalid' : '' }}">{{ old('raw_details') }}</textarea>

                  @if ($errors->has('raw_details'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Details is required</strong>
                    </span>
                  @endif
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

      <button class="btn btn-gradient-primary mt-3" type="submit">Add Requirement</button>
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
      </script>
  @endsection