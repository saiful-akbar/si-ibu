@extends('templates.main')

@section('title', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('user') }}" class="btn btn-sm btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form name="user_form" enctype="multipart/form-data" action="{{ route('user.store') }}" method="POST">
        @method('POST') @csrf

        {{-- form akun --}}
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h4 class="header-title">Form Tambah User Akun</h4>
                            </div>
                        </div>

                        {{-- input username --}}
                        <div class="form-group row mb-3">
                            <label for="username" class="col-md-3 col-sm-12 col-form-label">
                                Username <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="username"
                                    name="username"
                                    placeholder="Masukan username..."
                                    value="{{ old('username') }}"
                                    class="form-control @error('username') is-invalid @enderror"
                                />

                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input password --}}
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-sm-12 col-form-label">
                                password <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                    <input
                                        required
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Masukan password..."
                                        value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror"
                                    />

                                    <div class="input-group-append" data-password="false" style="cursor: pointer">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- input user aktif --}}
                        <div class="form-group row justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        name="active"
                                        class="custom-control-input form-control-lg"
                                        id="active"
                                        @if (old('active')) checked @endif
                                    />

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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h4 class="header-title">Form Tambah User Profil</h4>
                            </div>
                        </div>

                        {{-- input avatar --}}
                        <div class="form-group row mb-3 justify-content-end">
                            <div class="col-md-9 col-sm-12">
                                <img
                                    id="avatar-view"
                                    alt="avatar"
                                    class="img-fluid avatar-lg rounded-circle"
                                    src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                    data-src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                />

                                <label for="avatar" class="ml-2">
                                    <span type="button" class="btn btn-sm btn-primary">
                                        Upload avatar
                                    </span>
                                </label>

                                <div>
                                    <input
                                        type="file"
                                        id="avatar"
                                        name="avatar"
                                        accept="image/*"
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

                        {{-- input nama lengkap --}}
                        <div class="form-group row mb-3">
                            <label for="nama_lengkap" class="col-md-3 col-sm-12 col-form-label">
                                Nama Lengkap <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <input
                                    required
                                    type="text"
                                    id="nama_lengkap"
                                    name="nama_lengkap"
                                    placeholder="Masukan nama lengkap..."
                                    value="{{ old('nama_lengkap') }}"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                />

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
                                <select
                                    required
                                    name="divisi_id"
                                    id="divisi_id"
                                    class="custom-select @error('divisi_id') is-invalid @enderror"
                                >
                                    <option disabled @if (!old('divisi_id')) selected @endif>
                                        -- Pilih Divisi --
                                    </option>

                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}" @if (old('divisi_id') == $divisi->id) selected @endif>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- input role level --}}
                        <div class="form-group row mb-3">
                            <label for="role_id" class="col-md-3 col-sm-12 col-form-label">
                                Role Level <small class="text-danger">*</small>
                            </label>

                            <div class="col-md-9 col-sm-12">
                                <select
                                    required
                                    name="role_id"
                                    id="role_id"
                                    class="custom-select @error('role_id') is-invalid @enderror"
                                >
                                    <option disabled @if (!old('role_id')) selected @endif>
                                        -- Pilih Level --
                                    </option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if (old('role_id') == $role->id) selected @endif>
                                            {{ ucwords($role->level) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role_id')
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
                <button type="submit" class="btn btn-success btn-sm mr-2">
                    <i class="mdi mdi-content-save"></i>
                    <span>Simpan</span>
                </button>

                <button type="reset" class="btn btn-sm btn-secondary">
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