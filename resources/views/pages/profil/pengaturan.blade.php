@extends('templates.profil')

@section('title', 'Pengaturan')

@section('content-profil')
    <div class="row">
        <div class="col-12">

            <form
                action="{{ route('profil.pengaturan.tema') }}"
                method="POST"
            >
                @method('PATCH') @csrf

                {{-- tema card --}}
                <div class="card">
                    <div class="card-header pt-3">
                        <h4 class="header-title">Tema</h4>
                    </div>

                    {{-- tema card-body --}}
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-4 col-sm-12 col-form-label">
                                Tema
                            </label>

                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <div class="mt-2 @error('tema') is-invalid @enderror">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input
                                            type="radio"
                                            class="custom-control-input @error('tema') is-invalid @enderror"
                                            id="light"
                                            value="light"
                                            name="tema"
                                            @if (auth()->user()->pengaturan->tema == 'light') checked @endif
                                        />

                                        <label
                                            class="custom-control-label"
                                            for="light"
                                        >
                                            Terang
                                        </label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input
                                            type="radio"
                                            class="custom-control-input @error('tema') is-invalid @enderror"
                                            id="dark"
                                            value="dark"
                                            name="tema"
                                            @if (auth()->user()->pengaturan->tema == 'dark') checked @endif
                                        />

                                        <label
                                            class="custom-control-label"
                                            for="dark"
                                        >
                                            Gelap
                                        </label>
                                    </div>
                                </div>

                                @error('tema')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- end tema card-body --}}

                    {{-- tema card-footer --}}
                    <div class="card-footer">
                        <button
                            type="submit"
                            class="btn btn-sm btn-info btn-rounded mr-2"
                        >
                            <i class="mdi mdi-content-save"></i>
                            <span>Simpan</span>
                        </button>

                        <button
                            type="reset"
                            class="btn btn-sm btn-rounded btn-dark"
                        >
                            <i class="mdi mdi-close"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                    {{-- end tema card-footer --}}

                </div>
                {{-- end tema card --}}

            </form>
        </div>
    </div>
@endsection
