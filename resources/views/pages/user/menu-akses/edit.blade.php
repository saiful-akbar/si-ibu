@extends('templates.main')

@section('title', 'User Menu Akses')

@section('content')
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a
                href="{{ route('user') }}"
                class="btn btn-sm btn-dark"
            >
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- profil --}}
    @include('pages.user.menu-akses.profile')

    {{-- tabs --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                            <h4 class="header-title">Edit User Menu Akses</h4>
                        </div>
                    </div>
                    {{-- end title & btn tambah --}}

                    {{-- nav tabs --}}
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills bg-nav-pills nav-justified">
                                <li class="nav-item">
                                    <a
                                        href="{{ route('user.menu-akses.detail', ['user' => $user->id]) }}"
                                        aria-expanded="false"
                                        class="nav-link rounded-0"
                                    >
                                        <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Detail</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        href="{{ route('user.menu-akses.edit', ['user' => $user->id]) }}"
                                        aria-expanded="true"
                                        class="nav-link rounded-0 active"
                                    >
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Edit</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- end nav tabs --}}
                </div>
            </div>
        </div>
    </div>

    {{-- form user akses --}}
    <form
        action="{{ route('user.menu-akses.update', ['user' => $user->id]) }}"
        method="POST"
    >
        @method('PATCH') @csrf

        @foreach ($menuHeaders as $menuHeader)
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- input menu header --}}
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="hidden"
                                                name="menuHeader[{{ $menuHeader->id }}][id]"
                                                value="{{ $menuHeader->id }}"
                                            />

                                            {{-- menu header --}}
                                            <input
                                                name="menuHeader[{{ $menuHeader->id }}][read]"
                                                type="checkbox"
                                                id="{{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                class="custom-control-input form-control-lg menu-headers"
                                                data-header-name="{{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                @if (isset($user->menuHeader->find($menuHeader->id)->pivot) && $user->menuHeader->find($menuHeader->id)->pivot->read == 1) checked @endif
                                            />

                                            <label
                                                class="custom-control-label"
                                                for="{{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                            >
                                                {{ ucwords($menuHeader->nama_header) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end input menu header --}}

                            {{-- input menu item --}}
                            @foreach ($menuHeader->menuItem as $menuItem)
                                <div class="form-group row mb-3">
                                    <div class="col-md-4 col-sm-12 mb-1">
                                        <span class="h5">
                                            <i class="{{ $menuItem->icon }} mr-2"></i>
                                            {{ ucwords($menuItem->nama_menu) }}
                                        </span>
                                    </div>

                                    {{-- id --}}
                                    <input
                                        type="hidden"
                                        name="menuItem[{{ $menuItem->nama_menu }}][id]"
                                        value="{{ $menuItem->id }}"
                                    >

                                    {{-- create --}}
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="menuItem[{{ $menuItem->nama_menu }}][create]"
                                                class="custom-control-input {{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                id="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-create"
                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->create == 1) checked @endif
                                                @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif
                                            />

                                            <label
                                                class="custom-control-label"
                                                for="{{ str_replace(' ', '-', $menuItem->nama_menu) }}-create"
                                            >
                                                Create
                                            </label>
                                        </div>
                                    </div>

                                    {{-- read --}}
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="menuItem[{{ $menuItem->nama_menu }}][read]"
                                                class="custom-control-input {{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                id="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-read"
                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->read == 1) checked @endif
                                                @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif
                                            >
                                            <label
                                                class="custom-control-label"
                                                for="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-read"
                                            >
                                                Read
                                            </label>
                                        </div>
                                    </div>

                                    {{-- update --}}
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="menuItem[{{ $menuItem->nama_menu }}][update]"
                                                class="custom-control-input {{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                id="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-update"
                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->update == 1) checked @endif
                                                @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif
                                            >
                                            <label
                                                class="custom-control-label"
                                                for="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-update"
                                            >
                                                Update
                                            </label>
                                        </div>
                                    </div>

                                    {{-- delete --}}
                                    <div class="col-md-2 col-sm-6 mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                name="menuItem[{{ $menuItem->nama_menu }}][delete]"
                                                class="custom-control-input {{ str_replace(' ', '-', $menuHeader->nama_header) }}"
                                                id="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-delete"
                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->delete == 1) checked @endif
                                                @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif
                                            >
                                            <label
                                                class="custom-control-label"
                                                for="{{ str_replace(' ', '_', $menuItem->nama_menu) }}-delete"
                                            >
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{-- end input menu item --}}

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- button submit & reset --}}
        <div class="row">
            <div class="col-12">
                <button
                    type="submit"
                    class="btn btn-info btn-sm mr-2"
                >
                    <i class="mdi mdi-content-save"></i>
                    <span>Simpan</span>
                </button>

                <button
                    type="reset"
                    class="btn btn-sm btn-secondary"
                >
                    <i class="mdi mdi-close"></i>
                    <span>Reset</span>
                </button>
            </div>
        </div>
    </form>
    {{-- form user akses --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/pages/user.js') }}"></script>
@endsection
