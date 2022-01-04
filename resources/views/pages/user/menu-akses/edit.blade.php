@extends('templates.main')

@section('title', 'User Menu Akses')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <a href="{{ route('user') }}" class="btn btn-rounded btn-dark btn-sm">
                <i class="mdi mdi-chevron-double-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- profil --}}
    @include('pages.user.menu-akses.profile')

    <div class="row">

        {{-- tabs --}}
        <div class="col-lg-4 col-md-6-col-sm-12 mb-3">
            <div class="nav flex-column nav-pills" id="tabs-menu-access" role="tablist" aria-orientation="vertical">
                <a href="{{ route('user.menu-akses.detail', ['user' => $user->id]) }}" class="nav-link mb-2">
                    <i class="mdi mdi-eye-outline mr-2"></i>
                    <span>Detail Akses</span>
                </a>

                <a href="{{ route('user.menu-akses.edit', ['user' => $user->id]) }}" class="nav-link mb-2 active show">
                    <i class="mdi mdi-square-edit-outline mr-2"></i>
                    <span>Edit Akses</span>
                </a>
            </div>

            <hr>
        </div>
        {{-- end tabs --}}

        {{-- form user akses --}}
        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <form action="{{ route('user.menu-akses.update', ['user' => $user->id]) }}" method="POST">
                        @method('PATCH') @csrf

                        @foreach ($menuHeaders as $menuHeader)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            {{-- input menu header --}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="hidden" name="menuHeader[{{ $menuHeader->id }}][id]"
                                                        value="{{ $menuHeader->id }}" />

                                                    {{-- input menu header --}}
                                                    <div class="form-group mt-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input name="menuHeader[{{ $menuHeader->id }}][read]"
                                                                id="{{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                type="checkbox"
                                                                class="custom-control-input form-control-lg menu-headers"
                                                                data-header-name="{{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                @if (isset($user->menuHeader->find($menuHeader->id)->pivot) && $user->menuHeader->find($menuHeader->id)->pivot->read == 1) checked @endif />

                                                            <label class="custom-control-label"
                                                                for="{{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}">
                                                                {{ ucwords($menuHeader->nama_header) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end input menu header --}}

                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <hr>
                                                </div>
                                            </div>

                                            {{-- input menu item --}}
                                            @foreach ($menuHeader->menuItem as $menuItem)
                                                <div class="form-group row mb-3">
                                                    <div class="col-md-4 col-sm-12 mb-1">
                                                        <span class="h5">
                                                            <i class="{{ $menuItem->icon }} mr-2"></i>
                                                            {{ ucwords($menuItem->nama_menu) }}
                                                        </span>
                                                    </div>

                                                    {{-- input id --}}
                                                    <input type="hidden"
                                                        name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][id]"
                                                        value="{{ $menuItem->id }}" />

                                                    {{-- input create --}}
                                                    <div class="col-md-2 col-sm-6 mb-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox"
                                                                name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][create]"
                                                                class="custom-control-input {{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-create"
                                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->create == 1) checked @endif @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                            <label class="custom-control-label"
                                                                for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-create">
                                                                Create
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- input read --}}
                                                    <div class="col-md-2 col-sm-6 mb-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox"
                                                                name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][read]"
                                                                class="custom-control-input {{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-read"
                                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->read == 1) checked @endif @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                            <label class="custom-control-label"
                                                                for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-read">
                                                                Read
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- input update --}}
                                                    <div class="col-md-2 col-sm-6 mb-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox"
                                                                name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][update]"
                                                                class="custom-control-input {{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-update"
                                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->update == 1) checked @endif @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                            <label class="custom-control-label"
                                                                for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-update">
                                                                Update
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- input delete --}}
                                                    <div class="col-md-2 col-sm-6 mb-1">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox"
                                                                name="menuItem[{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}][delete]"
                                                                class="custom-control-input {{ str_replace(' ', '_', strtolower($menuHeader->nama_header)) }}"
                                                                id="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-delete"
                                                                @if (isset($user->menuItem->find($menuItem->id)->pivot) && $user->menuItem->find($menuItem->id)->pivot->delete == 1) checked @endif @if (!isset($user->menuHeader->find($menuHeader->id)->pivot) || $user->menuHeader->find($menuHeader->id)->pivot->read != 1) disabled @endif />

                                                            <label class="custom-control-label"
                                                                for="{{ str_replace(' ', '_', strtolower($menuItem->nama_menu)) }}-delete">
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
                                <button type="submit" class="btn btn-info btn-rounded btn-sm mr-2">
                                    <i class="mdi mdi-content-save"></i>
                                    <span>Simpan</span>
                                </button>

                                <button type="reset" class="btn btn-rounded btn-outline-dark btn-sm">
                                    <i class="mdi mdi-close"></i>
                                    <span>Reset</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- form user akses --}}

    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/js/pages/user.js') }}"></script>
@endsection
