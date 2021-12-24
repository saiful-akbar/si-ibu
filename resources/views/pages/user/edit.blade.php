@extends('templates.main')

@section('title', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('user') }}" class="btn btn-rounded btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form name="user_form" enctype="multipart/form-data" action="{{ route('user.update', ['user' => $user->id]) }}" method="POST">
        @method('PATCH') @csrf

        {{-- form akun --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">
                            Form Edit User Akun
                        </h4>
                    </div>

                    <div class="card-body">

                        {{-- input username --}}
                        <div class="form-group row mb-3">
                            <label for="username" class="col-md-3 col-sm-12 col-form-label">
                                Username <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="text" id="username" name="username" placeholder="Masukan username..."
                                    value="{{ old('username', $user->username) }}"
                                    class="form-control @error('username') is-invalid @enderror" />

                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input password --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-sm-12 col-form-label">
                                password
                            </label>

                            <div class="col-md-3 col-sm-12 mt-2 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is-disable-password" />
                                    <label class="custom-control-label" for="is-disable-password">
                                        Ubah Password
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                    <input disabled type="password" id="password" name="password" placeholder="Masukan password..."
                                        value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror" />

                                    <div class="input-group-append" data-password="false" style="cursor: pointer">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <span class="help-block">
                                    <small>Biarkan password tetap kosong jika tidak ingin merubahnya.</small>
                                </span>

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input user aktif --}}
                        <div class="form-group row justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="active" class="custom-control-input form-control-lg" id="active"
                                        @if (old('active', $user->active)) checked @endif />

                                    <label class="custom-control-label" for="active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end form akun --}}

        {{-- form profil --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title mt-2">
                            Form Edit User Profil
                        </h4>
                    </div>

                    <div class="card-body">

                        {{-- input avatar --}}
                        <div class="form-group row mb-3 justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                @if ($user->profil->avatar != null)
                                    <img id="avatar-view" alt="avatar" class="img-fluid avatar-lg rounded-circle"
                                        src="{{ asset('storage/' . $user->profil->avatar) }}"
                                        data-src="{{ asset('storage/' . $user->profil->avatar) }}" />
                                @else
                                    <img id="avatar-view" alt="avatar" class="img-fluid avatar-lg rounded-circle"
                                        src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                        data-src="{{ asset('assets/images/avatars/avatar_default.webp') }}" />
                                @endif

                                <label for="avatar" class="ml-2">
                                    <span type="button" class="btn btn-rounded btn-primary">
                                        <i class="mdi mdi-upload-outline"></i>
                                        <span>Avatar</span>
                                    </span>
                                </label>

                                <div>
                                    <input type="file" id="avatar" name="avatar" accept="image/*" placeholder="Upload avatar..."
                                        value="{{ old('avatar') }}" class="@error('avatar') is-invalid @enderror"
                                        style="display: none;" />

                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- input nama lengkap --}}
                        <div class="form-group row mb-3">
                            <label for="nama_lengkap" class="col-md-3 col-sm-12 col-form-label">
                                Nama Lengkap <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input required type="text" id="nama_lengkap" name="nama_lengkap"
                                    placeholder="Masukan nama lengkap..."
                                    value="{{ old('nama_lengkap', $user->profil->nama_lengkap) }}"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror" />

                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input divisi --}}
                        <div class="form-group row mb-3">
                            <label for="divisi_id" class="col-md-3 col-sm-12 col-form-label">
                                Divisi <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select required name="divisi_id" id="divisi_id"
                                    class="custom-select @error('divisi_id') is-invalid @enderror">
                                    <option disabled @if (!old('divisi_id', $user->divisi->id)) selected @endif>
                                        -- Pilih Divisi --
                                    </option>

                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}" @if (old('divisi_id', $user->divisi->id) == $divisi->id) selected @endif>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end form profil --}}

        {{-- button submit & reset --}}
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-info btn-rounded mr-2">
                    <i class="mdi mdi-content-save"></i>
                    <span>Simpan</span>
                </button>

                <button type="reset" class="btn btn-rounded btn-secondary">
                    <i class="mdi mdi-close"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>

    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/js/pages/user.js') }}"></script>
@endsection
