@extends('templates.profil')

@section('content-profil')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Ubah Profil</h4>
                </div>

                <div class="card-body">
                    <form
                        action="{{ route('profil.update') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @method('PATCH')
                        @csrf

                        {{-- input avatar --}}
                        <div class="form-group row mb-3 justify-content-end">
                            <div class="col-lg-9 col-sm-12">
                                @if ($profil->avatar != null)
                                    <img
                                        id="avatar-view"
                                        alt="avatar"
                                        class="img-fluid avatar-lg rounded-circle img-thumbnail"
                                        src="{{ asset('storage/' . $profil->avatar) }}"
                                        data-src="{{ asset('storage/' . $profil->avatar) }}"
                                    />
                                @else
                                    <img
                                        id="avatar-view"
                                        alt="avatar"
                                        class="img-fluid avatar-lg rounded-circle img-thumbnail"
                                        src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                        data-src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                    />
                                @endif

                                <label
                                    for="avatar"
                                    class="ml-2"
                                >
                                    <span
                                        type="button"
                                        class="btn btn-rounded btn-primary"
                                    >
                                        <i class="mdi mdi-upload-outline"></i>
                                        <span>Avatar</span>
                                    </span>
                                </label>

                                <div>
                                    <input
                                        type="file"
                                        id="avatar"
                                        name="avatar"
                                        accept="image/*"
                                        placeholder="Upload avatar..."
                                        value="{{ old('avatar') }}"
                                        class="@error('avatar') is-invalid @enderror"
                                        style="display: none;"
                                    />

                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- end input avatar --}}

                        {{-- input nama lengkap --}}
                        <div class="form-group row mb-3">
                            <label
                                for="nama_lengkap"
                                class="col-lg-3 col-sm-12 col-form-label"
                            >
                                Nama Lengkap <small class="text-danger">*</small>
                            </label>

                            <div class="col-lg-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="nama_lengkap"
                                    name="nama_lengkap"
                                    placeholder="Masukan nama lengkap..."
                                    value="{{ old('nama_lengkap', $profil->nama_lengkap) }}"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                />

                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- end input nama lengkap --}}

                        {{-- button submit & reset --}}
                        <div class="row justify-content-end">
                            <div class="col-lg-9 col-sm-12">
                                <button
                                    type="submit"
                                    class="btn btn-info btn-rounded mr-2"
                                >
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-rounded btn-secondary"
                                >
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-profil')
    <script>
        $(document).ready(function() {
            /**
             * View avatar
             */
            $("#avatar").change(function(e) {
                e.preventDefault();

                const {
                    files
                } = $(this)[0];

                if (files) {
                    $("#avatar-view").attr("src", URL.createObjectURL(files[0]));
                }
            });

            /**
             * Kembalikan avatar ketika form direset
             */
            $("button[type=reset]").click(function() {
                const avatarView = $("#avatar-view");

                avatarView.attr("src", avatarView.data("src"));
            });
        });
    </script>
@endsection
