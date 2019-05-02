@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
        <i class="mdi mdi-home"></i>
    </span> Agents </h3>

  </div>

  <form autocomplete="off" action="{{ route('agents.store') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Basic information</div>

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif

              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif

              </div>

              <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" id="mobile" name="mobile" value="{{ old('mobile') }}">

                @if ($errors->has('mobile'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('mobile') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group">
                <label for="contact_no">Alternative contact no</label>
                <input type="text" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" id="contact_no" name="contact_no" value="{{ old('contact_no') }}">

                @if ($errors->has('contact_no'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('contact_no') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password">

                @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Address information</div>

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
              <select name="city" id="city" class="form-control js-city-field{{ $errors->has('city') ? ' is-invalid' : '' }}" data-preselect="{{ old('city') }}">
              </select>

              @if ($errors->has('city'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('city') }}</strong>
                </span> 
              @endif
            </div>

            <div class="form-group">
              <label for="address">Address</label>

              <textarea name="address" id="address" rows="7" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{ old('address') }}</textarea>
              @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
              @endif
            </div>

            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="pincode" class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}" id="pincode" name="pincode" value="{{ old('pincode') }}">

                @if ($errors->has('pincode'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('pincode') }}</strong>
                  </span>
                @endif
              </div>

          </div>
        </div>
      </div>

      <div class="col-md-12 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Tax information</div>

            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="pancard">PAN no.</label>
                  <input type="text" class="form-control{{ $errors->has('pancard') ? ' is-invalid' : '' }}" id="pancard" name="pancard" value="{{ old('pancard') }}">

                  @if ($errors->has('pancard'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('pancard') }}</strong>
                    </span>
                  @endif
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                <label for="gst">GST no</label>
                <input type="text" class="form-control{{ $errors->has('gst') ? ' is-invalid' : '' }}" id="gst" name="gst" value="{{ old('gst') }}">

                @if ($errors->has('gst'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('gst') }}</strong>
                  </span>
                @endif
              </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-12 mt-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Bank information</div>

              <div class="form-group">
                <label for="bank_name">Name of the Bank</label>
                <input type="text" class="form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}" id="bank_name" name="bank_name" value="{{ old('bank_name') }}">

                @if ($errors->has('bank_name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('bank_name') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group">
                <label for="mobile">Account no</label>
                <input type="text" class="form-control{{ $errors->has('account_no') ? ' is-invalid' : '' }}" id="account_no" name="account_no" value="{{ old('account_no') }}">

                @if ($errors->has('account_no'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('account_no') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group">
                <label for="ifsc">Bank IFSC</label>
                <input type="text" class="form-control{{ $errors->has('ifsc') ? ' is-invalid' : '' }}" id="ifsc" name="ifsc" value="{{ old('ifsc') }}">

                @if ($errors->has('ifsc'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('ifsc') }}</strong>
                  </span>
                @endif
              </div>
              
          </div>
        </div>
      </div>

      <div class="col-md-12 mt-4">
        <div class="form-check mx-sm-2">
          <label class="form-check-label">
            <input type="checkbox" class="form-check-input" name="premium" {{ old('premium') ? 'checked' : '' }} value="1"> Premium agent <i class="input-helper"></i></label>
        </div>
        <button class="btn btn-gradient-primary mt-3" type="submit">Add Agent</button>
      </div>
    </div>
  </form>

  @endsection