<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Rera Agents - All Certificed agents by RERA">
    <meta name="description" content="Rera Agents -All Certificed agents by RERA">
    <meta name="keywords" content="">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Rera Agents - All Certificed agents by RERA</title>
     @if (env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142678288-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-142678288-1');
        </script>
    @endif
</head>

<body>

    <section class="bg-hero" style="background-image: url('{{ asset('img/img3.jpeg') }}')">
        
      <nav class="navbar navbar-expand-lg fixed-nav navbar-light pt-3">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img class="logo-header" src="{{ asset('img/rera_new.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topNav"
            aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav ml-auto ham-menu d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="https://play.google.com/store/apps/details?id=in.idevia.reraagents" target="_blank">
                        <img class="playstore-img " src="{{ asset('img/download-on-the-app-store-icon-0.png') }}" alt=""></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.about') }}">About us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.contact') }}">Contact us</a>
                </li>
                {{-- <li>
                    <button class="btn btn-outline-dark my-sm-0" type="submit"><i class="fa fa-user-secret"
                            aria-hidden="true"></i> Register as Agent</button>
                </li> --}}
            </ul>
        </div>
      </nav>

        <div class="container text-center header-text">
            <div class="row ">
                <div class="col-md-12 hero-text">
                    <h1 class="hero-tagline" style="color:#ffffff;">For all your Property Requirements</h1>
                </div>
                <div class="col-md-12">
                    <a href="{{ route('page.property.buy') }}" class="btn btn1 my-2 my-sm-0">Post Your Requirement</a>
                    <a href="{{ route('page.property.sell') }}" class="btn btn2 my-2 my-sm-0">Sell Property</a>
                </div>
            </div>

        </div>
    </section>

 

    {{-- property list --}}
    @yield('content')

    {{-- footer --}}
    <footer id="footer" class="bg-dark footer-nav mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 light-text mb-3">
                    <h5 class="footer-heading">COMPANY</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="{{ route('index') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('page.about') }}">About us</a>
                        </li>
                        <li>
                            <a href="{{ route('page.contact') }}">Contact us</a>
                        </li>
                        <li>
                            <a href="{{ route('page.privacy') }}">Privacy policy</a>
                        </li>
                        <li>
                            <a href="{{ route('page.terms') }}">Terms &amp; Conditions</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 light-text mb-3">
                    {{-- <h5 class="footer-heading">Contact us</h5>
                    <ul class="list-unstyled">
                        <li>
                            <table>
                                <tbody>
                                    <tr>
                                        <th><i class="fa fa-map-marker" aria-hidden="true"></i></th>
                                        <td>
                                            Reraagents
                                            Vidyanagar 3rd line
                                            Guntur,522034
                                            Andhara Pradesh
                                            India
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </li>
                        <li>
                            <table>
                                <tbody>
                                    <tr>
                                        <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                        <td>
                                            +91 986 665 7007
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </li>
                        <li>
                            <table>
                                <tbody>
                                    <tr>
                                        <th><i class="fa fa-envelope" aria-hidden="true"></i></th>
                                        <td>
                                            support@reraagents.in
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </li>

                    </ul> --}}
                </div>


                <div class="col-md-3 light-text mb-3">
                    <h5 class="footer-heading">Social</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/reraagents.in/" target="_blank">Facebook</a></li>
                        <!-- <li><a href="" target="_blank">Linkedin</a></li>
                        <li><a href="" target="_blank">Twitter</a></li>
                        <li><a href="" target="_blank">Instagram</a></li> -->
                    </ul>
                </div>
                <div class="col-md-3 align-self-center my-3">
                    <img class="logofoot" src="{{ asset('img/logofooter.png') }}" alt="rera agents logo">
                </div>
            </div>
            <hr class="white-hr">
            <div class="row">
                <div class="col-12">
                    <p class="text-center text-light">© Copyright 2018 by <span style="color:#018cc7;">Charanetra
                            Spaces PVT LTD. </span> All rights reserved.</p>
                </div>
            </div>
        </div>

    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        $cityField = $('.js-city-field');

        $cityField.on('change', function() {
        $(document).trigger('city_changed');
        initTypeahead();
        initSelectize();
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
                $(document).trigger('city_init');
            }
            },
            error: function(err) {
            console.log('FETCH_CITY_ERR:', err);  
            }
        })
        }

        initTypeahead();
        initSelectize();

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
            } else if (dependency == 'state') {
                data = {'state': $stateField.val()}
            } else {
                data = {};
            }

            $that.typeahead('destroy');
            // $that.on('change', function(event) {
            //     console.log($(this).val());
            //   });

            $.get(url, data, function (response){
                // console.log(response);
                $that.typeahead({ 
                source: response.data,
                afterSelect: function(item) {
                    console.log(item);
                    $that.siblings('input').val(item.id);

                    $that.after(`<button type="button" class="btn custom-tag btn-light btn-xs my-3 mr-2">
                                <input type="hidden" value="${item.id}" name="${$that.attr('data-name')}"> 
                                ${item.name} <span class="badge"><i class="mdi mdi-delete text-danger"></i></span>
                                </button>`);
                    $that.val('');
                }
                });

            }, 'json');
            });
        }
        }

        function initSelectize() {
        var $selectize = $('.js-selectize');
        if ($selectize.length) {
            console.log('init..', $cityField.val())
            $selectize.each(function() {
            var $that = $(this);
            var url = $that.attr('data-url');
            if (!url) return;
            var dependency = $that.attr('data-dependency');

            var data = {};
            var values = $that.attr('data-preselect');

            if (dependency == 'city') {
                if ((!$cityField.val() || $cityField.val() <= 0))
                return;
                data = { 'city' : $cityField.val() };
            } else if (dependency == 'state') {
                data = {'state': $stateField.val()}
            } else {
                data = {};
            }

            let select = $(this).selectize({ 
                optionMap: {},
                delimiter: ',',
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                hideSelected: true,
                preload: true,
                persist: false,
                create: false,
                render: {
                    option: function(data, escape) {
                    return `<div class="list-group-item">${data.name}</div>`;
                    }
                },
                load: function(query, callback) {
                    var self = this;
                    $.get(url, data, function (response){
                    callback(response.data);
                    if (values) {
                        self.setValue(values.split(','), true);
                        $that.attr('data-preselect','');
                        values = '';
                    }

                    }, 'json');
                }
                });

                select[0].selectize.refreshItems();

                // console.log(select[0].selectize.setValue([1,2], true));

            
            });
        }
        }

        $(document).on('city_changed', function() {
        initSelectize();
        });

        var $stateField = $('.js-state-field');


        if ($stateField.length) {
        fetchCities($stateField.val());
        }
        $stateField.on('change', function() {
        fetchCities($(this).val());
        });
    </script>

    @yield('javascripts')
</body>

</html>