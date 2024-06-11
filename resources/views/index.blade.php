@extends('layouts.main')
@section('content')
<section id="home" class="home">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-banner" style="text-align: center">
                    <div data-aos="zoom-in-up">
                        <div class="banner-title">
                            <h1 class="font-weight-medium">
                                {{{ __('theme/landing.banner.title') }}}
                            </h1>
                        </div>
                        <p class="mt-3 banner-text" id="elementEl">{{ __('theme/landing.banner.text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <section class="our-process" id="marka-takip-hizmeti">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="automatic text-dark text-center">{{ __('theme/landing.section-1.sub-title') }}</p>
                    <h2 class="font-weight-medium text-dark mb-5 text-center">{{ __('theme/landing.section-1.title') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 img-fluid" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                    data-aos-duration="2000">
                    <img src="images/marka-takip-hizmeti.webp" width="443" height="295" alt="idea"
                        class="home-page-images">
                </div>
                <div class="col-lg-6 service-section" data-aos="fade-up">
                    <h3 class="font-weight-medium text-dark" style="font-size: 30px">
                        {{ __('theme/landing.section-1.list-header') }}</h3>
                    <p class="font-weight-medium mb-4"></p>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-1.item-1') }}</p>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-1.item-2') }}</p>
                    </div>
                    <div class="d-flex justify-content-start">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-1.item-3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-process" style="background-color: #f9f9f9">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 service-section" data-aos="fade-up">
                    <h3 class="font-weight-medium text-dark" style="font-size: 30px">
                        {{ __('theme/landing.section-2.title') }}</h3>
                    <p class="font-weight-medium mb-4"></p>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-2.item-1') }}</p>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-2.item-2') }}</p>
                    </div>
                    <div class="d-flex justify-content-start">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-2.item-3') }}</p>
                    </div>
                </div>
                <div class="col-lg-6 text-right img-fluid" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                    data-aos-duration="2000">
                    <img src="images/ucretsiz-takip-firsati.webp" width="443" height="295" style="margin-bottom: 25px"
                        alt="idea" class="home-page-images">
                </div>
            </div>
        </div>
    </section>
    <section class="our-process">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-left img-fluid" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                    data-aos-duration="2000">
                    <img src="images/otomatik-ve-tam-zamaninda.webp" width="443" height="295" alt="idea"
                        class="home-page-images">
                </div>
                <div class="col-sm-6 service-section" data-aos="fade-up">
                    <h3 class="font-weight-medium text-dark" style="font-size: 30px">
                        {{ __('theme/landing.section-3.title') }}</h3>
                    <p class="font-weight-medium mb-4"></p>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-3.item-1') }}</p>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-3.item-2') }}</p>
                    </div>
                    <div class="d-flex justify-content-start">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-3.item-3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-services" id="geliskin-arama">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 service-section" data-aos="fade-up">
                    <h3 class="font-weight-medium text-dark" style="font-size: 30px">
                        {{ __('theme/landing.section-5.title') }}</h3>
                    <p class="font-weight-medium mb-4"></p>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-5.item-1') }}</p>
                    </div>
                    <div class="d-flex justify-content-start mb-3">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-5.item-2') }}</p>
                    </div>
                    <div class="d-flex justify-content-start">
                        <img src="images/tick.png" alt="tick" class="mr-3 tick-icon">
                        <p class="mb-0">{{ __('theme/landing.section-5.item-3') }}</p>
                    </div>
                </div>
                <div class="col-lg-6 text-left img-fluid" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                    data-aos-duration="2000">
                    <img src="images/geliskin-arama.webp" alt="geliskin arama" width="443" height="295"
                        class="home-page-images">
                </div>
            </div>
        </div>
    </section>
    <section class="our-services" id="neden-marka-takibi">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="font-weight-medium text-dark mb-5 text-center">
                        {{ __('theme/landing.section-4.title') }}
                    </h3>
                </div>
            </div>
            <div class="row offering" data-aos="fade-up">
                <div class="col-sm-6 text-center text-lg-left">
                    <div class="services-box" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"
                        style="background-color: #3c37f1; border-radius: 3%; color:white;padding: 30px">
                        <img src="images/design-development.webp" width="50" height="50" alt="design-development"
                            data-aos="zoom-in">
                        <p class=" mb-3 mt-4 font-weight-medium neden-marka-takibi">
                            {{ __('theme/landing.section-4.item-1-title') }}</p>
                        <p>{{ __('theme/landing.section-4.item-1-text') }}</p>
                    </div>
                </div>
                <div class="col-sm-6 text-center text-lg-left">
                    <div class="services-box" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"
                        style="padding: 30px">
                        <img src="images/benzer-markalari-kacirma.webp" width="50" height="50"
                            alt="benzer markalari kacirma" data-aos="zoom-in">
                        <p class="text-dark mb-12 font-weight-medium neden-marka-takibi">
                            {{ __('theme/landing.section-4.item-2-title') }}</p>
                        <p>{{ __('theme/landing.section-4.item-2-text') }}</p>
                    </div>
                </div>
            </div>
            <div class="row offering" data-aos="fade-up">
                <div class="col-sm-6 text-center text-lg-left">
                    <div class="services-box" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"
                        style="padding: 30px">
                        <img src="images/rekabeti-kacirma.webp" width="50" height="50" alt="rekabeti kacirma"
                            data-aos="zoom-in">
                        <p class="text-dark mb-3 mt-4 neden-marka-takibi">
                            {{ __('theme/landing.section-4.item-3-title') }}</p>
                        <p>{{ __('theme/landing.section-4.item-3-text') }}</p>
                    </div>
                </div>
                <div class="col-sm-6 text-center text-lg-left">
                    <div class="services-box" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"
                        style="background-color: #3c37f1; border-radius: 3%; color:white;padding: 30px">
                        <img src="images/isleriniz-artsin.webp" width="50" height="50" alt="design-development"
                            data-aos="zoom-in">
                        <p class="mb-3 mt-4 font-weight-medium neden-marka-takibi">
                            {{ __('theme/landing.section-4.item-4-title') }}</p>
                        <p>{{ __('theme/landing.section-4.item-4-text') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($articles->count() > 0)
        <section class="our-process" style="background-color: #f9f9f9">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <h3 class="font-weight-medium text-dark" style="font-size: 30px">
                            {{ __('theme/landing.articles') }}</h3>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up">
                        <ul class="list-group list-group-flush bg-transparent">
                            @foreach ($articles as $article)
                                <li class="list-group-item bg-transparent border-0">
                                    <a href="{{ route('front.article', ['language' => app()->getLocale(), 'slug' => $article->slug]) }}">{{ $article->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('front.articles', app()->getLocale()) }}" class="btn btn-primary mt-4">{{ __('theme/landing.all-articles') }}</a>
                    </div>
                    <div class="col-lg-6 text-right img-fluid" data-aos="flip-left" data-aos-easing="ease-out-cubic"
                        data-aos-duration="2000">
                        <img src="images/ucretsiz-takip-firsati.webp" width="443" height="295"
                            style="margin-bottom: 25px" alt="idea" class="home-page-images">
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="contactus" id="contact-us">
        <div class="container">
            <div class="row mb-5 pb-5">
                <div class="col-lg-6 col-md-12" style="text-align: center" data-aos="fade-up" data-aos-offset="-500">
                    <img src="images/contact.jpg" width="300" height="305" alt="contact"
                        class="home-page-images">
                </div>
                <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-offset="-500">
                    <h3 class="font-weight-medium text-dark mt-5 mt-lg-0">{{ __('theme/landing.contact-form.text') }}</h3>
                    <p style="line-height: 32px;" class="text-dark mb-5 contact-us-paragraph">
                        {{ __('theme/landing.contact-form.sub-text') }}
                    </p>
                    {{-- Success message --}}
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <form method="POST" action="/contact-form#contact-us">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name"
                                        class="form-control mb-1 border border-primary rounded" id="name"
                                        placeholder="{{ __('theme/landing.contact-form.name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="email" name="email"
                                        class="form-control mb-1 border border-primary rounded" id="email"
                                        placeholder="{{ __('theme/landing.contact-form.email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control mb-1 border border-primary rounded"
                                        placeholder="{{ __('theme/landing.contact-form.message') }}" rows="5"></textarea>
                                    @error('message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="btn btn-primary">{{ __('theme/landing.contact-form.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
