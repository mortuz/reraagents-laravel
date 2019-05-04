@extends('layouts.frontend-master')

@section('content')
    <section class="mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            
            <div class="card">
              <div class="card-header"> <h5>Sell your property</h5> </div>
              <div class="card-body">
                <form action="{{ route('page.property.sell') }}" method="post">
              
                  <div class="form-group">
                    <label for="name">State</label>
                    <input type="text" name="name" id="name" class="form-control{{$errors->has('name') ? ' is-invalid': ''}}">
                    @if ($errors->has('name'))
                        <label class="invalid-feedback">{{ $errors->name }}</label>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="mobile">City</label>
                    <input type="text" name="mobile" id="mobile" class="form-control{{$errors->has('mobile') ? ' is-invalid': ''}}">
                    @if ($errors->has('mobile'))
                        <label class="invalid-feedback">{{ $errors->mobile }}</label>
                    @endif
                  </div>

                   <div class="form-group">
                    <label for="mobile">Measurements</label>
                    <input type="text" name="mobile" id="mobile" class="form-control{{$errors->has('mobile') ? ' is-invalid': ''}}">
                    @if ($errors->has('mobile'))
                        <label class="invalid-feedback">{{ $errors->mobile }}</label>
                    @endif
                  </div>

                   <div class="form-group">
                    <label for="mobile">Location</label>
                    <input type="text" name="mobile" id="mobile" class="form-control{{$errors->has('mobile') ? ' is-invalid': ''}}">
                    @if ($errors->has('mobile'))
                        <label class="invalid-feedback">{{ $errors->mobile }}</label>
                    @endif
                  </div>

                   <div class="form-group">
                    <label for="mobile">Price</label>
                    <input type="text" name="mobile" id="mobile" class="form-control{{$errors->has('mobile') ? ' is-invalid': ''}}">
                    @if ($errors->has('mobile'))
                        <label class="invalid-feedback">{{ $errors->mobile }}</label>
                    @endif
                  </div>

                   <div class="form-group">
                   <label for="exampleFormControlTextarea1">Example textarea</label>
                   <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <!-- <div class="custom-control custom-switch mt-4">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                    <label class="custom-control-label" for="customSwitch1">Are you a agent?</label>
                    </div> -->
                    <div>
                    <label class="mr-2 mt-3" for="mobile">Are you an Agent?</label>
                   <div class="custom-control custom-radio custom-control-inline">
                   <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
                   <label class="custom-control-label" for="customRadioInline1">Yes</label>
                   </div>
                   <div class="custom-control custom-radio custom-control-inline">
                   <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                   <label class="custom-control-label" for="customRadioInline2">No</label>
                   </div>
                    </div>
                   

                  <button type="button" class="btn float-right btn1 mt-4">Post Property</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
