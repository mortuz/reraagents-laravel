@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create Facing </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Add Facing</div>

          <form action="{{ route('face.store') }}" method="POST">
            
            @csrf
            <div class="form-group">
              <label for="face">Face</label>
              <input type="text" class="form-control{{ $errors->has('face') ? ' is-invalid' : '' }}" id="face" name="face" value="{{ old('face') }}">

              @if ($errors->has('face'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('face') }}</strong>
                </span>
              @endif

            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Add facing</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection