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
              <label for="contat_no">Alternative Contact no.</label>

              <input name="contat_no" id="contat_no" type="text" class="form-control{{ $errors->has('contat_no') ? ' is-invalid' : '' }}" value="{{ old('contact_no') }}"/>
              @if ($errors->has('contat_no'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('contat_no') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="alternative_contact_no_2">Alternative Contact no.</label>

              <input name="alternative_contact_no_2" id="alternative_contact_no_2" type="text" class="form-control{{ $errors->has('alternative_contact_no_2') ? ' is-invalid' : '' }}" value="{{ old('alternative_contact_no_2') }}"/>
              @if ($errors->has('alternative_contact_no_2'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('alternative_contact_no_2') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="ventures">Add Ventures</label>

              <input name="ventures[]" id="ventures" data-url={{ route('get.ventures') }} data-dependency="city" data-provide="typeahead" autocomplete="off"  type="text" class="form-control js-typeahead"/>
              {{-- @if ($errors->has('ventures'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('ventures') }}</strong>
                </span>
              @endif --}}
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