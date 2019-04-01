@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create Office </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Add office</div>

          <form action="{{ route('office.store') }}" method="POST">
            
            @csrf

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
              <label for="mobile">Contact no.</label>

            <input name="mobile" id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{ old('mobile') }}"/>
              @if ($errors->has('mobile'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-group">
              <label for="url">Url</label>

            <input name="url" id="url" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ old('url') }}"/>
              @if ($errors->has('url'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-group">
              <label for="address">Address</label>

              <textarea name="address" id="address" cols="30" rows="5" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{ old('address') }}</textarea>
              @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-check mx-sm-2">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="govt" {{ old('govt') ? 'checked' : '' }} value="1"> It is a Government office <i class="input-helper"></i></label>
            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Add Office</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection