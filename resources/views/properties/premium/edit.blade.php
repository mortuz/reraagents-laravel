@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Premium properties </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Update property: {{ $property->id }}</div>

          <form action="{{ route('property.premium.update', ['id' => $property->id ]) }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            @method('put')

            <div class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" id="website" name="website" value="{{ $property->website }}">

              @if ($errors->has('website'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="youtube_link">Youtube link</label>
              <input type="text" class="form-control{{ $errors->has('youtube_link') ? ' is-invalid' : '' }}" id="youtube_link" name="youtube_link" value="{{ $property->youtube_link }}">

              @if ($errors->has('youtube_link'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('youtube_link') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="google_map">Google map</label>
              <input type="text" class="form-control{{ $errors->has('google_map') ? ' is-invalid' : '' }}" id="google_map" name="google_map" value="{{ $property->google_map }}">

              @if ($errors->has('google_map'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('google_map') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group mb-4">
              <label for="images">Product images</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input{{ $errors->has('images') ? ' is-invalid' : '' }}" id="images" name="images[]" multiple accept="image/*">
                <label class="custom-file-label" for="images">Choose file</label>

              </div>
            </div>

            <div class="form-group">
              <label for="features">Features</label>
              <textarea name="features" id="features" rows="3" class="form-control">{{ $property->features }}</textarea>

              @if ($errors->has('features'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('features') }}</strong>
                </span>
              @endif
            </div>


            <button class="btn btn-gradient-primary mt-3" type="submit">Update state</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection