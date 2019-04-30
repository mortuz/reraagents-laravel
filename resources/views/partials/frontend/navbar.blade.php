<nav class="navbar navbar-expand-lg bg-light fixed-nav navbar-light pt-3">
    <a class="navbar-brand" href="{{ route('index') }}"><img class="logo-header" src="{{ asset('img/rera_new.png') }}" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topNav"
        aria-controls="topNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="topNav">
        <ul class="navbar-nav ml-auto ham-menu d-flex align-items-center">
            <li class="nav-item active">
                <a class="nav-link" href="https://play.google.com/store/apps/details?id=in.idevia.reraagents" target="_blank">
                    <img class="playstore-img " src="{{ asset('img/download-on-the-app-store-icon-0.png') }}" alt="">
                </a>
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