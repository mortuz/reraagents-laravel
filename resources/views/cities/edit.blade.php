@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create city </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Edit city: {{ $city->name }}</div>

          <form autocomplete="off" action="{{ route('cities.update', ['city' => $city->id]) }}" method="POST">
            
            @method('put')
            @csrf
            <div class="form-group">
              <label for="name">City name</label>
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ $city->name }}">

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $city->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('state'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-check mx-sm-2">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="status" {{ $city->status ? 'checked' : '' }} value="1"> Active city <i class="input-helper"></i></label>
            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Update city</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection