@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Add builders </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Add builder</div>

          <form action="{{ route('builders.store') }}" method="POST">
            
            @csrf

            <div class="form-group">
              <label for="name">Builder name</label>
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name')}}">

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control js-state-field{{ $errors->has('name') ? ' is-invalid' : '' }}">
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
              <select name="city" id="city" class="form-control js-city-field">
              </select>
            </div>

            <div class="form-group">
              <label for="mobile">Mobile</label>
              <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="mobile" value="{{ old('mobile') }}">

              @if ($errors->has('mobile'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="email" value="{{ old('email') }}">

              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>


            <div class="form-group">
              <label for="contact_no">Alternative Contact no.</label>

              <input name="contact_no" id="contact_no" type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" value="{{ old('contact_no') }}"/>
              @if ($errors->has('contact_no'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contact_no') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="alternative_contact_no">Alternative Contact no.</label>

              <input name="alternative_contact_no" id="alternative_contact_no" type="text" class="form-control{{ $errors->has('alternative_contact_no') ? ' is-invalid' : '' }}" value="{{ old('alternative_contact_no') }}"/>
              @if ($errors->has('alternative_contact_no'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('alternative_contact_no') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="ventures">Add Ventures</label>

              <input id="ventures" data-name="ventures[]" data-url="{{ route('api.get.ventures') }}" data-dependency="city" data-provide="typeahead" autocomplete="off"  type="text" class="form-control js-typeahead"/>
              
              @if (old('ventures'))
                @foreach (old('ventures') as $venture)

                  @foreach ($ventures as $v)
                      @if($v->id == $venture)
                        <button type="button" class="btn custom-tag btn-light btn-xs my-3 mr-2">
                          <input type="hidden" value="{{ $venture }}" name="ventures[]"> 
                          {{ $v->name }} <span class="badge"><i class="mdi mdi-delete text-danger"></i></span>
                        </button>
                      @endif
                  @endforeach
                @endforeach
              @endif
              
            </div>

            {{-- <div class="form-check mx-sm-2">
              <label class="form-check-label">
              <input type="checkbox" class="form-check-input" name="govt" {{ old('govt') ? 'checked' : '' }} value="1"> It is a Government office <i class="input-helper"></i></label>
            </div> --}}

            <button class="btn btn-gradient-primary mt-3" type="submit">Add builder</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('javascript')
      <script>


        var ventures = [];
        var allVentures = [];

        // @foreach($ventures as $key => $value)
        //   allVentures.push({ id: {{$key}}, name: {{ $value}}});
        // @endforeach

        // @if(old('ventures'))
        //   @foreach(old('ventures') as $venture)
        //     ventures.push($venture);
        //   @endforeach

        // @endif

      </script>
  @endsection