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
          <div id="premium-form" 
            data-id="{{ $property->id }}" 
            data-token="{{ $token }}"
            data-url="{{ route('api.admin.premium.property') }}"
            data-amenities-url={{ route('api.admin.amenity.index') }}
            ></div>
        </div>
      </div>
    </div>
  </div>

  @endsection