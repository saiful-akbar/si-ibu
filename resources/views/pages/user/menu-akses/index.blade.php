@extends('templates.main')

@section('title', 'Menu Akses')

@section('btn-kembali')
    <a href="{{ route('user') }}" class="btn btn-rounded btn-light btn-sm">
        <i class="mdi mdi-chevron-double-left"></i>
        <span>Kembali</span>
    </a>
@endsection

@section('content')
    @include('pages.user.menu-akses.profile')

    <div class="row">

        {{-- tabs --}}
        <div class="col-lg-4 col-md-6-col-sm-12 mb-3">
            <div class="nav flex-column nav-pills" id="tabs-menu-access" role="tablist" aria-orientation="vertical">
                <a href="{{ route('user.menu-akses.detail', ['user' => $user->id]) }}" class="nav-link active show mb-2">
                    <i class="mdi mdi-eye-outline mr-2"></i>
                    <span>Detail Akses</span>
                </a>

                @if ($userAccess->pivot->update == 1)
                    <a href="{{ route('user.menu-akses.edit', ['user' => $user->id]) }}" class="nav-link mb-2">
                        <i class="mdi mdi-square-edit-outline mr-2"></i>
                        <span>Edit Akses</span>
                    </a>
                @endif
            </div>

            <hr>
        </div>
        {{-- end tabs --}}

        {{-- table list menu akses --}}
        <div class="col-lg-8 col-md-6 col-sm-12 mb-3">
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="card">
                        <div class="card-header pt-3">
                            <h4 class="header-title">Table Menu Akses User</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-centered w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">Read</th>
                                            <th class="text-center">Update</th>
                                            <th class="text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menuItems as $menuItem)
                                            <tr>
                                                <td>
                                                    <i class="{{ $menuItem->icon }} mr-2"></i>
                                                    {{ ucwords($menuItem->nama_menu) }}
                                                </td>
                                                <td class="text-center">
                                                    @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->create == 1)
                                                        <i class="mdi mdi-check text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h3"></i>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->read == 1)
                                                        <i class="mdi mdi-check text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h3"></i>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->update == 1)
                                                        <i class="mdi mdi-check text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h3"></i>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->delete == 1)
                                                        <i class="mdi mdi-check text-success h3"></i>
                                                    @else
                                                        <i class="mdi mdi mdi-close text-danger h3"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end table list menu akses --}}

    </div>
@endsection
