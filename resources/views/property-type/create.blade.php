@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create property type </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Add new state</div>

          <form autocomplete="off" action="{{ route('property-types.store') }}" method="POST">
            
            @csrf
            <div class="form-group">
              <label for="type">Property type</label>
              <input type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" id="type" name="type">

              @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
              @endif

            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Add property type</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection