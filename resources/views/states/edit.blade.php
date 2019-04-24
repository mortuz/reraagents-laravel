@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Edit states </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Edit state: {{ $state->name }}</div>

          <form autocomplete="off" action="{{ route('states.update', ['id' => $state->id ]) }}" method="POST">
            
            @csrf
            @method('put')
            <div class="form-group">
              <label for="name">State name</label>
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ $state->name }}">

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-check mx-sm-2">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="status" {{ $state->status ? 'checked' : '' }} value="1"> Active state <i class="input-helper"></i></label>
            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Update state</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection