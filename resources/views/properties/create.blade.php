@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create property </h3>

  </div>

  <form autocomplete="off" action="{{ route('properties.store') }}" method="POST">
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
              <label for="area">Area</label> <button type="button" class="btn btn-link btn-sm float-right p-1" onclick="launchOnTheFlowModal('Area', '{{ route('api.area.store') }}', true)"><i class="mdi mdi-plus"></i> Add area</button>
              <input id="area" name="area" data-preselect="{{ old('area') }}" data-url={{ route('api.area.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="landmark">Landmark</label> <button type="button" class="btn btn-link btn-sm float-right p-1" onclick="launchOnTheFlowModal('Landmark', '{{ route('api.landmark.store') }}', true)"><i class="mdi mdi-plus"></i> Add landmark</button>
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
              <label for="price">Price</label> <button type="button" class="btn btn-link btn-sm float-right p-1" onclick="launchOnTheFlowModal('Price', '{{ route('api.price.store') }}', false)"><i class="mdi mdi-plus"></i> Add price</button>
              <input id="price" name="price" data-preselect="{{ old('price') }}" data-url={{ route('api.price.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
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
              <label for="ventures">Ventures</label> <button type="button" class="btn btn-link btn-sm float-right p-1" onclick="launchOnTheFlowModal('Venture', '{{ route('api.venture.store') }}', true)"><i class="mdi mdi-plus"></i> Add venture</button>
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
                <option value="1">Approve</option>
                <option value="2">Reject</option>
              </select>
            </div>

            <div class="form-check mx-sm-2">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="premium" {{ old('premium') ? 'checked' : '' }} value="1"> Premium property <i class="input-helper"></i></label>
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
                  <label for="raw_price">Price</label>
                  <input type="text" class="form-control{{ $errors->has('raw_price') ? ' is-invalid' : '' }}" id="raw_price" name="raw_price" value="{{ old('raw_price') }}">

                  @if ($errors->has('raw_price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Price is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="raw_measurement">Measurement</label>
                  <input type="text" class="form-control{{ $errors->has('raw_measurement') ? ' is-invalid' : '' }}" id="raw_measurement" name="raw_measurement" value="{{ old('raw_measurement') }}">

                  @if ($errors->has('raw_measurement'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Measurement is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="raw_location">Location</label>
                  <input type="text" class="form-control{{ $errors->has('raw_location') ? ' is-invalid' : '' }}" id="raw_location" name="raw_location" value="{{ old('raw_location') }}">

                  @if ($errors->has('raw_location'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Location is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="raw_details">Details</label>
                  <input type="text" class="form-control{{ $errors->has('raw_details') ? ' is-invalid' : '' }}" id="raw_details" name="raw_details" value="{{ old('raw_details') }}">

                  @if ($errors->has('raw_details'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Price is required</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="office">Office</label>
                  <input id="office" name="office" data-preselect="{{ old('office') }}" data-url={{ route('api.office.index') }} data-dependency="city" type="text" class="form-control js-office"/>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

      <button class="btn btn-gradient-primary mt-3" type="submit">Add Property</button>
    </form>

  @endsection

@section('javascript')
  <script>

    $(document).on('city_init', function() {
      console.log('selectize')
      initSelectize();
      initOfficeSelectize();
    });

    $(document).on('city_changed', function() {
      console.log('city changed');
      initOfficeSelectize();
    });      
  </script>
@endsection