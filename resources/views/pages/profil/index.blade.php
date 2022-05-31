<x-layouts.auth title="Profil">
    <x-layouts.profile>
        <div class="row">
            <div class="col-12">
                <x-form method="PATCH" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title mt-2">Ubah Profil</h4>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-md-8 col-sm-12 mb-3">
                                    @if ($profil->avatar != null)
                                        <img id="avatar-view"
                                            alt="avatar"
                                            class="img-fluid avatar-lg rounded-circle img-thumbnail"
                                            src="{{ asset('storage/' . $profil->avatar) }}"
                                            data-src="{{ asset('storage/' . $profil->avatar) }}"
                                        />
                                    @else
                                        <img id="avatar-view"
                                            alt="avatar"
                                            class="img-fluid avatar-lg rounded-circle img-thumbnail"
                                            src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                            data-src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                        />
                                    @endif

                                    <label for="avatar" class="ml-2">
                                        <span type="button" class="btn btn-success btn-sm">
                                            <i class="mdi mdi-upload-outline"></i>
                                            <span>Unggah</span>
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

                            <div class="form-group row">
                                <label for="nama_lengkap" class="col-md-4 col-sm-12 col-form-label">
                                    Nama Lengkap <small class="text-danger">*</small>
                                </label>

                                <div class="col-md-8 col-sm-12">
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
            </div>
        </div>
    </x-layouts.profile>
    
    <x-slot name="script">
        <script>
            $(document).ready(function() {

                //  View avatar
                $("#avatar").change(function(e) {
                    e.preventDefault();
                    
                    const { files } = $(this)[0];
                    
                    if (files) {
                        $("#avatar-view").attr("src", URL.createObjectURL(files[0]));
                    }
                });

                 // Kembalikan avatar ketika form direset
                $("button[type=reset]").click(function() {
                    $("#avatar-view").attr("src", avatarView.data("src"));
                });
            });
        </script>
    </x-slot>
</x-layouts.auth>
