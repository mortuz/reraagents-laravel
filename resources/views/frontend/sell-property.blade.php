@extends('layouts.frontend-master')

@section('content')
    <section class="mt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-2">
            
            <div class="card">
              <div class="card-header"> <h5>Sell your property</h5> </div>
              <div class="card-body">
                <div>
                  <label class="mr-2 mt-3">Are you an Agent?</label>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="yes" name="choice" class="choice custom-control-input" value="yes">
                    <label class="custom-control-label" for="yes">Yes</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="no" name="choice" class="choice custom-control-input" value="no">
                    <label class="custom-control-label" for="no">No</label>
                  </div>
                </div>

                <form action="{{ route('page.property.sell') }}" method="post" id="form">
              
                  <div class="form-group">
                    <label for="state">State</label>
                    <select name="state" id="state" class="form-control js-state-field">
                      @foreach ($states as $state)
                          <option value="{{ $state->id }}">{{ $state->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" id="city" class="form-control js-city-field">
                    </select>
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


                  <button type="button" class="btn float-right btn2 mt-4">Sell Property</button>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endsection
    
    
    @section('javascript')
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script>
      $cityField = $('.js-city-field');
      $stateField = $('.js-state-field');

      function fetchCities(state) {
        var url = "{{ route('get.cities') }}";

        $.ajax({
          url: url,
          data: {state: state},
          dataType: 'json',
          contentType: 'application/json',
          success: function(res) {
            var html = '<option value="0">Select city</option>';

            var oldCity = '0';

            oldCity = $cityField.attr('data-preselect');
            if (!oldCity) {
              oldCity = "{{ old('city') }}";
            }

            for (let i = 0; i < res.data.length; i++) {
              const city = res.data[i];
              html += `<option value="${city.id}" ${oldCity == city.id ? 'selected': ''}>${city.name}</option>`;
            }


            if ($cityField.length) {
              $cityField.html(html);
              $(document).trigger('city_init');
            }
          },
          error: function(err) {
            console.log('FETCH_CITY_ERR:', err);  
          }
        })
      }


      if ($stateField.length) {
        fetchCities($stateField.val());
      }
      $stateField.on('change', function() {
        fetchCities($(this).val());
      });

      $('.choice').on('change', function(e) {
        console.log($(this).valshow);

        if($(this).val() == 'yes') {
          // hide form
          $('#form').hide();
        } else {
          // show form
          $('#form').show();
        }
      });


      $('#form').validate({
        rules: {

        }
      });
    </script>
@endsection