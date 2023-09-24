<x-layouts.guest title="Login">
    <div class="auth-fluid">
        <div class="auth-fluid-form-box d-flex justify-content-center align-items-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3 text-center">
                        <a href="{{ route('login') }}" class="logo-dark">
                            <img src="{{ asset('assets/images/logo/logo-dark.png') }}" alt="logo" width="230" />
                        </a>
                    </div>

                    <div class="col-12 mb-3 text-center">
                        <h4 class="mt-0">Sign in account</h4>
                    </div>
                </div>

                {{-- alert error --}}
                @error('error')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-alert color="danger" title="Login gagal">
                                {{ $message }}
                            </x-alert>
                        </div>
                    </div>
                @enderror

                {{-- form login --}}
                <div class="row">
                    <div class="col-12">
                        <x-form method="POST" action="{{ route('login.post') }}">
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input required autofocus class="form-control" type="text" id="username" name="username"
                                    placeholder="Masukan username..." value="{{ old('username') }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input required class="form-control" type="password" id="password" name="password"
                                    placeholder="Masukan password..." />

                                <div class="custom-control custom-checkbox mt-2">
                                    <input type="checkbox" class="custom-control-input" id="show-password" />
                                    <label class="custom-control-label" for="show-password">
                                        Tampilkan password
                                    </label>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-block" type="submit">
                                    <i class="mdi mdi-login"></i>
                                    <span>Log In</span>
                                </button>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">{{ config('app.description') }}</h2>

                <p class="lead">
                    <i class="mdi mdi-format-quote-open"></i>
                    v{{ config('app.version') }}
                    <i class="mdi mdi-format-quote-close"></i>
                </p>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#show-password').change(function() {
                    $('#password').attr('type', $(this).is(':checked') ? 'text' : 'password');
                });
            });
        </script>
    </x-slot>
</x-layouts.guest>
