<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="{{ $title }}">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>{{ $title }} - RERA Agents - All certified agents by RERA</title>
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
  @include('partials.frontend.navbar')

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
                    <img class="logofoot" src="{{ asset('img/logofooter.png') }}">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    @yield('javascript')
</body>

</html>