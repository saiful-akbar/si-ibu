@extends('templates.main')

@section('title', 'Login')

@section('content')
    <div class="auth-fluid">

        {{-- Auth fluid left content --}}
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <a
                                href="{{ route('login.view') }}"
                                class="logo-dark"
                            >
                                <span>
                                    <img
                                        src="assets/images/logo-dark.png"
                                        alt="logo"
                                        height="20"
                                        class="mb-4"
                                    />
                                </span>
                            </a>
                            <h4 class="mt-0">Sign In</h4>
                            <p class="text-muted">
                                Masukan username dan password untuk mengakses panel dashboard.
                            </p>
                        </div>
                    </div>

                    @error('error')
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div
                                    role="alert"
                                    class="alert alert-danger alert-dismissible fade show"
                                >
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="alert"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong><i class="dripicons-wrong mr-2"></i></strong>
                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                    @enderror

                    <div class="row">
                        <div class="col-12">
                            <form
                                name="form-login"
                                autocomplete="off"
                                method="POST"
                                action="{{ route('login') }}"
                            >
                                @method('POST')
                                @csrf

                                <div class="form-group mb-3">
                                    <label for="username">Username</label>
                                    <input
                                        required
                                        autofocus
                                        class="form-control"
                                        type="text"
                                        id="username"
                                        name="username"
                                        placeholder="Masukan username..."
                                        value="{{ old('username') }}"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input
                                        required
                                        class="form-control"
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Masukan password..."
                                    >
                                </div>

                                <div class="form-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="show-password"
                                        >
                                        <label
                                            class="custom-control-label"
                                            for="show-password"
                                        >
                                            Tampilkan password
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center">
                                    <button
                                        class="btn btn-primary btn-block"
                                        type="submit"
                                    >
                                        <i class="mdi mdi-login"></i> Log In
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- end auth-fluid-form-box --}}

        {{-- Auth fluid right content --}}
        <div class="auth-fluid-right text-center"></div>
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
