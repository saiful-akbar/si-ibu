<x-layouts.auth title="Pengaturan">
    <x-layouts.profile>
        <x-form method="PATCH" action="{{ route('profil.pengaturan.tema') }}">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title mt-2">Ubah Tema</h4>
                </div>

                <div class="card-body">
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-md-4 col-sm-12 col-form-label">
                            Tema
                        </label>

                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <div class="mt-2 @error('tema') is-invalid @enderror">

                                {{-- Tema light --}}
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input @error('tema') is-invalid @enderror"
                                        id="light"
                                        value="light"
                                        name="tema"
                                        @if (auth()->user()->pengaturan->tema == 'light') checked @endif
                                    />

                                    <label class="custom-control-label" for="light">
                                        Terang
                                    </label>
                                </div>

                                {{-- Tema dark --}}
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input @error('tema') is-invalid @enderror"
                                        id="dark"
                                        value="dark"
                                        name="tema"
                                        @if (auth()->user()->pengaturan->tema == 'dark') checked @endif
                                    />

                                    <label class="custom-control-label" for="dark">
                                        Gelap
                                    </label>
                                </div>

                            </div>

                            @error('tema')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-md-4 col-sm-12">
                            Sidebar
                        </label>

                        <div class="col-lg-9 col-md-8 col-sm-12">
                            <div class="mt-2 @error('sidebar') is-invalid @enderror">

                                {{-- Sidebar default --}}
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input @error('sidebar') is-invalid @enderror"
                                        id="sidebar-default"
                                        value="default"
                                        name="sidebar"
                                        @if (auth()->user()->pengaturan->sidebar == 'default') checked @endif
                                    />

                                    <label class="custom-control-label" for="sidebar-default">
                                        Default
                                    </label>
                                </div>

                                {{-- Sidebar terang --}}
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input @error('sidebar') is-invalid @enderror"
                                        id="sidebar-light"
                                        value="light"
                                        name="sidebar"
                                        @if (auth()->user()->pengaturan->sidebar == 'light') checked @endif
                                    />

                                    <label class="custom-control-label" for="sidebar-light">
                                        Terang
                                    </label>
                                </div>

                                {{-- Sidebar gelap --}}
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                        type="radio"
                                        class="custom-control-input @error('sidebar') is-invalid @enderror"
                                        id="sidebar-dark"
                                        value="dark"
                                        name="sidebar"
                                        @if (auth()->user()->pengaturan->sidebar == 'dark') checked @endif
                                    />

                                    <label class="custom-control-label" for="sidebar-dark">
                                        Gelap
                                    </label>
                                </div>

                            </div>

                            @error('sidebar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-info mr-2">
                        <i class="mdi mdi-content-save"></i>
                        <span>Simpan</span>
                    </button>

                    <button type="reset" class="btn btn-sm btn-dark">
                        <i class="mdi mdi-close"></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </x-form>
    </x-layouts.profile>
</x-layouts.auth>
