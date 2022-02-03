@extends('templates.main')

@section('title', 'Login')

@section('content')
    <div class="auth-fluid">

        {{-- Auth fluid left content --}}
        <div class="auth-fluid-form-box">
            <div class="d-flex align-items-center h-100">
                <div class="card-body">

                    {{-- logo --}}
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <a href="{{ route('login') }}" class="logo-dark">
                                <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" width="250" />
                            </a>
                        </div>
                    </div>
                    {{-- end logo --}}

                    <div class="row">
                        <div class="col-12 mb-2 text-center">
                            <h4 class="mt-0">Sign in account</h4>
                        </div>
                    </div>

                    {{-- alert error --}}
                    @error('error')
                        <div class="row">
                            <div class="col-12">
                                <div role="alert" class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                    <strong><i class="dripicons-wrong mr-2"></i></strong>

                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                    @enderror
                    {{-- end alert error --}}

                    {{-- form login --}}
                    <div class="row">
                        <div class="col-12">
                            <form name="form-login" autocomplete="off" method="POST" action="{{ route('login.post') }}">
                                @method('POST') @csrf

                                {{-- input username --}}
                                <div class="form-group mb-3">
                                    <label for="username">Username</label>
                                    <input required autofocus class="form-control" type="text" id="username" name="username"
                                        placeholder="Masukan username..." value="{{ old('username') }}" />
                                </div>

                                {{-- input password --}}
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input required class="form-control" type="password" id="password" name="password"
                                        placeholder="Masukan password..." />
                                </div>

                                {{-- show hide password --}}
                                <div class="form-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="show-password" />

                                        <label class="custom-control-label" for="show-password">
                                            Tampilkan password
                                        </label>
                                    </div>
                                </div>

                                {{-- button submit --}}
                                <div class="form-group mb-3 text-center">
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <i class="mdi mdi-login"></i>
                                        <span class="ml-1">Log In</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- end form login --}}

                </div>
            </div>
        </div>
        {{-- end auth-fluid-form-box --}}

        {{-- Auth fluid right content --}}
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">{{ config('app.description') }}</h2>

                <p class="lead">
                    <i class="mdi mdi-format-quote-open"></i>{{ config('app.name') }}<i class="mdi mdi-format-quote-close"></i>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#show-password').change(function() {
                $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
            });
        });
    </script>
@endsection
