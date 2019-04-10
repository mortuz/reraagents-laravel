@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create property </h3>

  </div>

  <form action="{{ route('properties.update', ['property' => $property->id]) }}" method="POST">
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
                    <option value="{{ $state->id }}" {{ $property->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
              <select name="city" id="city" class="form-control js-city-field{{ $errors->has('city') ? ' is-invalid' : '' }}" data-preselect="{{ $property->city_id }}">
              </select>

              @if ($errors->has('city'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('city') }}</strong>
                </span> 
              @endif
            </div>

            <div class="form-group">
              <label for="area">Area</label>
              <input id="area" name="area" data-preselect="{{ $property->area }}" data-url={{ route('api.area.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="landmark">Landmark</label>
              <input id="landmark" name="landmark" data-preselect="{{ $property->landmark }}" data-url={{ route('api.landmark.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="type">Property type</label>
              <input id="type" name="type" data-preselect="{{ $property->type }}" data-url={{ route('api.propertytype.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="bhk">Room</label>
              <input id="bhk" name="bhk" data-preselect="{{ $property->rooms }}" data-url={{ route('api.bhk.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>

            <div class="form-group">
              <label for="face">Face</label>
              <input id="face" name="face" data-preselect="{{ $property->face }}" data-url={{ route('api.faces.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="price">Price</label>
              <input id="price" name="price" data-preselect="{{ $property->price }}" data-url={{ route('api.price.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
          </div>
        </div>
        
        <div class="card mt-4">
          <div class="card-body">
            <div class="card-title">Builder and agent</div>
            
            <div class="form-group">
              <label for="agents">Agents</label>
              <input id="agents" name="agents" data-preselect="{{ $property->agents }}" data-url={{ route('api.agents.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="builders">Builders</label>
              <input id="builders" name="builders" data-preselect="{{ $property->builders }}" data-url={{ route('api.builders.index') }} data-dependency="" type="text" class="form-control js-selectize"/>
            </div>
            
            <div class="form-group">
              <label for="ventures">Ventures</label>
              <input id="ventures" name="ventures" data-preselect="{{ $property->ventures }}" data-url={{ route('api.venture.index') }} data-dependency="city" type="text" class="form-control js-selectize"/>
            </div>

          </div>
        </div>

        <div class="card mt-4">
          <div class="card-body">

            <div class="form-group">
              <label for="contact">Contact no</label>
              <input type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" id="contact" name="contact" value="{{ $property->mobile }}">

              @if ($errors->has('contact'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="handler">Handled by</label>
              <select class="form-control" id="handler" name="handler">
                <option value="0" {{ $property->handled_by == 0 ? 'selected' : '' }}>Agent</option>
                <option value="1" {{ $property->handled_by == 1 ? 'selected' : '' }}>Company</option>
              </select>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="0" {{ $property->status == 0 ? 'selected' : '' }}>New</option>
                <option value="1" {{ $property->status == 1 ? 'selected' : '' }}>Approve</option>
                <option value="2" {{ $property->status == 2 ? 'selected' : '' }}>Reject</option>
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
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione voluptates veniam dicta tempora, quo similique unde totam dignissimos nisi aliquid odio facere earum qui vero amet, quibusdam soluta sapiente iure?
              </div>
            </div>
          </div>
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
      </script>
  @endsection