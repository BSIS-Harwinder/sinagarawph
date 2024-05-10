@extends('layouts.master')

@section('seo')
    @include('components.meta', [
        'title' => 'Home'
    ])
@endsection

@section('styles')
    @include('components.styles')
@endsection

@section('content')
    <nav  class="navbar navbar-expand-lg bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="https://www.facebook.com/messages/t/103199242864749">
                <img src="{{ asset('images/logo1.png') }}" alt="main-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Header-->

    <!--Image Carousel-->
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner.png') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h5>GOING SOLAR? WE MAKE IT SIMPLE</h5>
                    <p>it's time to say goodbye to bills and say hello to SAVINGS.</p>
                    <p><a href="{{ route('register') }}" class="btn btn-warning mt-3">Get a Quote</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/bg1.jpg') }}" class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/bg2.jpg') }}" class="d-block w-100" alt="...">

            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!--Image Carousel-->


    <!--About-->
    <section id="about" class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12" data-aos="fade-up">
                    <div class="about-img">
                        <img src="{{ asset('images/costumer-guide.jpg') }}" alt="..." class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5" data-aos="fade-up">
                    <div class="about-text">
                        <h2> Where Excellence Meets Every Installation:<br> Our Commitment to Your Solar Success.</h2>
                        <p>At Sinag Araw, we're more than just a service—we're your reliable guide throughout every step of the process!</p>
                        <p>From inception to achievement, our dedicated team is here to lead you through the journey with expertise and support.
                        Join us in our mission to empower you with the sun's energy. It's time to say goodbye to bills and hello to savings!
                        </p>
                        <a href="#" class="btn btn-warning">Learn More.</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About-->

    <!--Service-->
    <section id="services" class="services section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5" data-aos="fade-up">
                        <h2>Services</h2>
                        <p>Solar installation services tailored <br>to your needs. </p>
                    </div>
                </div>
            </div>

            <div class="row" data-aos="fade-up">
                <div class="col-12 col-md-12 col-lg-4" data-aos="fade-up">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-bookmark-check-fill"></i>
                            <h3 class="card-tittle">On Grid</h3>
                            <p class="lead">On-grid solar panels are designed to directly feed electricity into the existing utility grid. These systems utilize photovoltaic (PV) panels to convert sunlight into electricity, which is then sent to the grid for immediate use or storage. Ideal for urban areas where grid connectivity is reliable, on-grid solar systems allow homeowners and businesses to offset their electricity bills while contributing clean energy to the grid.</p>
                            <a href="#" class="btn btn-warning dark-text">Learn More.</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-4" data-aos="fade-up">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-bookmark-heart-fill"></i>
                            <h3 class="card-tittle">Hybrid</h3>
                            <p class="lead">Hybrid solar panels combine the best of both on-grid and off-grid systems, offering flexibility and reliability. These systems integrate solar panels with battery storage and grid connectivity, allowing users to optimize their energy usage according to their needs and local conditions. Hybrid systems provide backup power during grid outages while maximizing self-consumption of solar energy, making them versatile solutions for residential and commercial applications.</p>
                            <a href="#" class="btn btn-warning dark-text">Learn More.</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-4" data-aos="fade-up">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-bookmark-star-fill"></i>
                            <h3 class="card-tittle">Off Grid</h3>
                            <p class="lead" style="font-weight: 200;">Off-grid solar panels operate independently of the utility grid, making them suitable for remote locations or areas with unreliable grid access. These systems typically incorporate batteries for energy storage, allowing users to harness solar power even when the sun isn't shining. Off-grid solar solutions provide energy independence and sustainability, making them popular choices for remote cabins, RVs, and remote villages.</p>
                            <a href="#" class="btn btn-warning dark-text">Learn More.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Service-->

    <!--Contact-->
    <section id="contact" class="contact section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12" data-aos="fade-up">
                    <div class="section-header text-center pb-5">
                        <h2>Contact Us</h2>
                    </div>
                </div>
            </div>
            <div class="row m-0" data-aos="fade-up">
                <div class="col-md-12 p-0 p-4 pb-4">
                    <form action="#" class="bg-light p-4.m-auto">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea rows="3" class="form-control" placeholder="Message Here..." required></textarea>
                                </div>
                            </div>

                            <button class="btn btn-warning btn-lg btn-block mt-3">Send Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--Contact-->

    <!--Footer-->
    @include('components.home-footer')
@endsection

@section('scripts')

@endsection
