@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Create advertisement </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Update advertisement </div>

          <form autocomplete="off" action="{{ route('advertisement.update', ['advertisement' => $ad->id]) }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            @method('put')
            <div class="form-group">
              <label for="title">Title</label>

              <input name="title" id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $ad->title }}"/>
              @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control js-state-field{{ $errors->has('state') ? ' is-invalid' : '' }}">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $ad->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
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
              <select name="city" id="city" class="form-control js-city-field" data-preselect="{{ $ad->city_id }}">
              </select>
            </div>

            <div class="form-group mb-4">
              <label for="images">Change image</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input{{ $errors->has('images') ? ' is-invalid' : '' }}" id="images" name="image" accept="image/*">
                <label class="custom-file-label" for="images">Choose file</label>

                @if ($errors->has('image'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
              @endif
              </div>
            </div>

            <div class="form-group">
              <label for="link">Link ( include <span class="bg-light font-weight-bold">http://</span> or <span class="bg-light font-weight-bold"> https://</span> for external url or enter property id)</label>

              <input name="link" id="link" type="text" class="form-control{{ $errors->has('link') ? ' is-invalid' : '' }}" value="{{ $ad->link }}"/>
              @if ($errors->has('link'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('link') }}</strong>
                </span>
              @endif
            </div>


            <div class="form-group">
              <label for="description">Description</label>

              <textarea name="description" id="description" cols="30" rows="5" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $ad->description }}</textarea>
              @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
              @endif
            </div>


            <button class="btn btn-gradient-primary mt-3" type="submit">Update advertisement</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection