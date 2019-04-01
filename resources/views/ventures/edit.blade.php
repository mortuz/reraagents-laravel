@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Venture </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Edit Venture: {{ $venture->name }}</div>

          <form action="{{ route('venture.update', ['venture' => $venture->id]) }}" method="POST">
            @method('patch')
            @csrf

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
            <select name="city" id="city" class="form-control js-city-field{{ $errors->has('state') ? ' is-invalid' : '' }}" data-preselect="{{ $venture->city_id }}">
              </select>

              @if ($errors->has('city'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ $venture->name }}">

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif

            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Update venture</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection