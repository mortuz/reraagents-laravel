@extends('layouts.frontend-master')

@section('content')

@if ($property->images)
    <section>
        <div id="imagesCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
            @foreach ($property->images as $index => $image)
                <div class="carousel-item {{$index == 0 ? 'active' : '' }}">
                    <img style="max-height:600px;" src="{{ asset($image) }}" class="d-block w-100 slider-img" alt="...">
                </div>
            @endforeach
            </div>
            <a class="carousel-control-prev" href="#imagesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imagesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </section>
@endif

<section class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="card-text">{{ $property->state->name }} >> <span class="color-dark">{{ $property->city->name }}</span> >> 
                  <span class="color-dark">{{ $property->propertytypes->first()->type }}</span>
                  <span class="card-text left-info">Property Id: <span class="color-red font-weight-bold">{{ $property->id }}</span>
                        , <span class="color-grey font-weight-bold">{{ $property->updated_at->format('Y-m-d') }}</span></span></p>
            </div>
        </div>
    </div>
</section>


<section class="mt-5">
    <div class="container">
        <div class="row bg-white p-5 bx-shadow">
            <div class="col-md-12">
                <h4 class="card-t1">{{ $property->raw_data->details }}</h4>
            </div>

            <div class="{{ $property->google_map ? 'col-md-6' : 'col-md-12' }} mt-5">
                <div class="">
                    @foreach ($property->features as $feature)
                        @php
                            $f = explode('::', $feature);
                        @endphp

                        <p>
                            <img class="icons-property" src="{{ asset('img/icons/hotel.svg') }}" alt=""> &nbsp; <span class="font-weight-bold">{{ $f[0] }}</span>: 
                            <span>{{ count($f) == 2 ? $f[1] : '' }}</span>
                        </p>
                        
                    @endforeach
                    
                    {{-- <p><img class="icons-property" src="{{ asset('img/icons/hotel.svg') }}" alt=""> &nbsp; NIGHTCLUB: <span style="font-weight:bold;">We have an amazing nightclub</span></p> --}}

                    @if ($property->website)
                        <a class="btn btn-danger mt-4" href="{{ $property->website }}" target="_blank" style="width:16rem;">Visit Website</a>
                    @endif

                    @if ($property->youtube_link)
                        <a class="btn btn-danger mt-4" href="{{ $property->website }}" target="_blank" style="width:16rem;">
                          Watch video
                        </a>
                    @endif

                    <a class="btn btn-danger mt-4" href="tel://{{ $property->mobile }}" style="width:16rem;">
                        Call: {{ $property->mobile }}
                    </a>

                </div>
            </div>
            @if ($property->google_map)
                <div class="col-md-6 mx-auto mb-3">
                <iframe src="{{ $property->google_map }}"
                    width="100%" height="300px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            @endif

            {{-- <div class="col-md-12 mt-5">
                <img style="max-height:450px; width:100%;" src="{{ asset('img/img3.jpeg') }}" alt="">
            </div> --}}


        </div>
    </div>
  </section>
@endsection