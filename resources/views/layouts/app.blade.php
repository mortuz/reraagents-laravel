<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Rera Agents') }}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.addons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/bootstrap-tagsinput.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/typeahead.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    @include('partials.navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      @include('partials.sidebar')
      <!-- partial -->

      <div class="main-panel">
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- content-wrapper ends -->

        <!-- partial:../../partials/_footer.html -->
        @include('partials.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('vendors/js/vendor.bundle.addons.js') }}"></script>
  <script src="{{ asset('vendors/js/typeahead.min.js') }}"></script>
  <script src="{{ asset('vendors/js/bootstrap-tagsinput.min.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  
  <script>
    $('.navbar-toggler').on('click', function() {
      if($(this).attr('data-toggle') == 'minimize') {
        $('body').toggleClass('sidebar-icon-only');
      }
    });

    @if(Session::has('error'))
        $.toast({
          heading: 'Error',
          text: "{{ Session::get('error') }}",
          showHideTransition: 'fade',
          icon: 'error',
          loaderBg: '#f2a654',
          position: 'top-right'
        })
    @endif

    @if(Session::has('success'))
        $.toast({
          heading: 'Success',
          text: "{{ Session::get('success') }}",
          showHideTransition: 'fade',
          icon: 'success',
          loaderBg: '#f96868',
          position: 'top-right'
        })
    @endif

    @if(Session::has('info'))
        $.toast({
          heading: 'Error',
          text: "{{ Session::get('info') }}",
          showHideTransition: 'fade',
          icon: 'info',
          loaderBg: '#46c35f',
          position: 'top-right'
        })
    @endif

    @if(Session::has('warning'))
        $.toast({
          heading: 'Error',
          text: "{{ Session::get('warning') }}",
          showHideTransition: 'fade',
          icon: 'warning',
          loaderBg: '#57c7d4',
          position: 'top-right'
        })
    @endif


    var $cityField = $('.js-city-field');

    $cityField.on('change', function() {
      initTypeahead();
    });

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
          }
        },
        error: function(err) {
          console.log('FETCH_CITY_ERR:', err);  
        }
      })
    }

    function initTypeahead() {
      if ($('.js-typeahead').length) {
        $typeahead = $('.js-typeahead');

        $typeahead.each(function() {
          var url = $(this).attr('data-url');
          $that = $(this);
          var dependency = $(this).attr('data-dependency');

          var data = {};

          if (dependency == 'city') {
            data = { 'city' : $cityField.val() };
          }

          // $that.on('change', function(event) {
          //     console.log($(this).val());
          //   });

          $.get(url, data, function (response){
            // console.log(response);
            $that.typeahead({ 
              source: response.data,
              afterSelect: function(event, item) {
                console.log(event, this);
              }
            });

          }, 'json');
        });
      }
    }

    var $stateField = $('.js-state-field');


    if ($stateField.length) {
      fetchCities($stateField.val());
    }
    $stateField.on('change', function() {
      fetchCities($(this).val());
    });


  </script>
  <!-- End custom js for this page-->
  @yield('javascript')
</body>

</html>
