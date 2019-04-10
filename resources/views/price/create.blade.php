@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Price </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Add price</div>

          <form action="{{ route('price.store') }}" method="POST">
            
            @csrf

            <div class="form-group">
              <label for="price">Price</label>
              <input type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" id="price" name="price" value="{{ old('price') }}">

              @if ($errors->has('price'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('price') }}</strong>
                </span>
              @endif

            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Add price</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection