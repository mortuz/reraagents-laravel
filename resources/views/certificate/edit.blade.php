@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Edit certificate </h3>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Review certificate for: {{ $certificate->user->name }}</div>

          <form autocomplete="off" action="{{ route('certificate.update', ['certificate' => $certificate->id]) }}" method="POST">
            
            @method('put')
            @csrf
            {{-- <div class="form-group">
              <label for="name">City name</label>
              <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ $city->name }}">

              @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif

            </div> --}}

            <div class="form-group">
              <label for="certificate_no">Certificate no</label>
              <input type="text" name="certificate_no" id="certificate_no" class="form-control{{ $errors->has('certificate_no') ? ' is-invalid' : '' }}" value="{{ $certificate->certificate_no }}">
              @if ($errors->has('certificate_no'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('certificate_no') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="expiry_date">Expiry date</label>
              <input type="date" name="expiry_date" id="expiry_date" class="form-control{{ $errors->has('expiry_date') ? ' is-invalid' : '' }}" value="{{ $certificate->expiry_date }}">
              @if ($errors->has('expiry_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('expiry_date') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
              <label for="state">State</label>
              <select name="state" id="state" class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}">
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $certificate->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('state'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
              @endif

            </div>

            <div class="form-group">
              <label for="status">Status</label> 
                <select name="status" id="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}">
                  <option value="0" {{ $certificate->status == 0 ? 'selected' : '' }}>Pending</option>
                  <option value="1" {{ $certificate->status == 1 ? 'selected' : '' }}>Approve</option>
                  <option value="2" {{ $certificate->status == 2 ? 'selected' : '' }}>Reject</option>
                </select>
                
                @if ($errors->has('status'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('status') }}</strong>
                  </span>
                @endif

            </div>
            <div>
              <a href="{{ $certificate->url }}" class="btn btn-inverse-secondary" target="_blank">View certificate</a>
            </div>

            <button class="btn btn-gradient-primary mt-3" type="submit">Update certificate</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection