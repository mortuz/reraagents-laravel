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

                <div class="download-text d-none">
                  Download our app to sell your property.
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
                    <label for="measurements">Measurements</label>
                    <input type="text" name="measurements" id="measurements" class="form-control">
                  </div>

                   <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control">
                  </div>

                   <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control">
                  </div>

                   <div class="form-group">
                      <label for="details">Details</label>
                      <textarea class="form-control" id="details" rows="3" name="details"></textarea>
                    </div>


                  <button type="submit" class="btn float-right btn2 mt-4">Sell Property</button>

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
            var html = '<option value="">Select city</option>';

            for (let i = 0; i < res.data.length; i++) {
              const city = res.data[i];
              html += `<option value="${city.id}">${city.name}</option>`;
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
          $('.download-text').show();
        } else {
          // show form
          $('#form').show();
          $('.download-text').hide();
        }
      });


      $('#form').validate({
        rules: {
          state: 'required',
          city: 'required',
          measurements: 'required',
          location: 'required',
          price: 'required',
          details: 'required'
        },
        messages: {
          state: 'Please select a state',
          city: 'Please select a city',
          measurements: 'Please enter measurements',
          location: 'Please enter location',
          price: 'Please enter price of the property',
          details: 'Please enter Property details',
        }
      });
    </script>
@endsection