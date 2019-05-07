@extends('layouts.frontend-master')

@section('content')
    <section class="mt-5" style="min-height: calc(100vh - 481px);">
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

                <div class="download-text" style="display: none">
                  <p class="mt-3">Download our app to sell your property.</p>
                  <a class="nav-link mt-2" href="https://play.google.com/store/apps/details?id=in.idevia.reraagents" target="_blank">
                    <img class="playstore-img " src="http://127.0.0.1:8000/img/download-on-the-app-store-icon-0.png" alt="">
                </a>
                </div>

                <form action="{{ route('page.property.sell') }}" method="post" id="form" style="display: none">
              
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
                    <label for="type">Property type</label>
                    <select name="type" id="type" class="form-control">
                      @foreach ($types as $type)
                          <option value="{{ $type->id }}">{{ $type->type }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="mobile">Mobile no</label>
                    <input type="text" name="mobile" id="mobile" class="form-control">
                  </div>

                   <div class="form-group">
                    <label for="measurement">Measurements</label>
                    <input type="text" name="measurement" id="measurement" class="form-control">
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

    <!-- Modal -->
    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="otpModal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Enter OTP</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" class="form-control" id="otp">
              <p class="error-message text-danger mt-2"></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-otp">Submit</button>
          </div>
        </div>
      </div>
    </div>
    @endsection
    
    
    @section('javascript')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

      var data = {};

      $('#form').validate({
        rules: {
          state: 'required',
          city: 'required',
          measurement: 'required',
          location: 'required',
          price: 'required',
          details: 'required',
          type: 'required', 
          mobile: {
            required: true,
            digits: true,
            minlength: 10,
            maxlength: 10
          }
        },
        messages: {
          state: 'Please select a state',
          city: 'Please select a city',
          measurement: 'Please enter measurements',
          location: 'Please enter location',
          price: 'Please enter price of the property',
          details: 'Please enter Property details',
          type: 'Property type is required',
          mobile: {
            required: 'Please enter mobile no',
            digits: 'Invalid mobile no',
            maxlength: 'Invalide mobile no',
            minlength: 'Invalide mobile no'
          }
        },
        submitHandler: function(form) {
          data = {
            state: $('#state').val(),
            city: $('#city').val(),
            type: $('#type').val(),
            measurement: $('#measurement').val(),
            location: $('#location').val(),
            price: $('#price').val(),
            details: $('#details').val(),
            mobile: $('#mobile').val(),
          };

          console.log(data);

          var url = "{{ route('post.guest.property') }}";
          $.ajax({
            type: 'post',
            url: url,
            accept: 'application/json',
            data: data,
            success: function(response) {
              console.log(response);

              if (response.otp_required) {
                data.token = response.token;
                console.log(data);

                $('#otpModal').modal();
                return;
              }

              if (!response.success) {
                $('error-message').html(response.error);
              }
            },
            error: function(err) {
              console.log(err);

              if (err.status == 422) {
                console.log(err.responseText);
              }
            }
          });
          return false;
        }
      });

      $('.btn-otp').on('click', function() {
        $('.error-message').html('');

        data.otp = $('#otp').val();

        var url = "{{ route('post.guest.property') }}";
        $.ajax({
          type: 'post',
          url: url,
          accept: 'application/json',
          data: data,
          success: function(response) {
            console.log(response);

            if (!response.success) {
              $('.error-message').html(response.message);
            } else {
              // hide modal
              $('#otpModal').modal('hide');
              // reset form
              $('#form')[0].reset();
              // show success swal

              swal({
                title: "Success!",
                text: "Your property posted with id " + response.data.id + ". We will get back to you after review.",
                icon: "success",
              });
            }
          },
          error: function(err) {
            console.log(err);

            if (err.status == 422) {
              console.log(err.responseText);
            }
          }
        });
      });
    </script>
@endsection