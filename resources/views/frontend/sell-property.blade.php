@extends('layouts.frontend-master')

@section('content')
    <section class="mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            
            <div class="card">
              <div class="card-header">Sell your property</div>
              <div class="card-body">
                <form action="{{ route('page.property.sell') }}" method="post">
              
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control{{$errors->has('name') ? ' is-invalid': ''}}">
                    @if ($errors->has('name'))
                        <label class="invalid-feedback">{{ $errors->name }}</label>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="mobile">Mobile no</label>
                    <input type="text" name="mobile" id="mobile" class="form-control{{$errors->has('mobile') ? ' is-invalid': ''}}">
                    @if ($errors->has('mobile'))
                        <label class="invalid-feedback">{{ $errors->mobile }}</label>
                    @endif
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
