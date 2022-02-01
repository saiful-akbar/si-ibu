@extends('templates.landing')

@section('title', 'Offline')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white font-weight-normal mb-4 mt-3 hero-title">
                            Saat ini Anda tidak terhubung ke jaringan apa pun.
                        </h2>
                    </div>
                </div>

                <div class="col-md-5 offset-md-2">
                    <div class="text-md-right mt-3 mt-md-0">
                        <img src="{{ asset('/assets/images/bg/offline.svg') }}" alt="offline" class="img-fluid" width="70%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
