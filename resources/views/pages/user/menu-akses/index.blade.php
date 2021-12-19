@extends('templates.main')

@section('title', 'User Menu Akses')

@section('content')

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('user') }}" class="btn btn-sm btn-dark">
                <i class="dripicons-chevron-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    {{-- profil --}}
    @include('pages.user.menu-akses.profile')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- title & btn tambah --}}
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                            <h4 class="header-title">Detail User Menu Akses</h4>
                        </div>
                    </div>
                    {{-- end title & btn tambah --}}

                    {{-- tabs --}}
                    <div class="row">
                        <div class="col-12">

                            {{-- tab nav --}}
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-5">
                                <li class="nav-item">
                                    <a href="{{ route('user.menu-akses.detail', ['user' => $user->id]) }}" aria-expanded="true"
                                        class="nav-link rounded-0 active">
                                        <span class="d-md-block">Detail</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('user.menu-akses.edit', ['user' => $user->id]) }}" aria-expanded="false"
                                        class="nav-link rounded-0 @if ($userAccess->pivot->update != 1) disabled @endif">
                                        <span class="d-md-block">Edit</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- end tab nav --}}

                            <div class="tab-content">
                                <div class="tab-pane show active">
                                    <div class="table-responsive">
                                        <table class="table table-hover nowrap">
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
                                                        <td class="text-center align-middle">
                                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->create == 1)
                                                                <i class="mdi mdi-check text-success h3"></i>
                                                            @else
                                                                <i class="mdi mdi mdi-close text-danger h3"></i>
                                                            @endif
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->read == 1)
                                                                <i class="mdi mdi-check text-success h3"></i>
                                                            @else
                                                                <i class="mdi mdi mdi-close text-danger h3"></i>
                                                            @endif
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            @if (!empty($user->menuItem->find($menuItem->id)) && $user->menuItem->find($menuItem->id)->pivot->update == 1)
                                                                <i class="mdi mdi-check text-success h3"></i>
                                                            @else
                                                                <i class="mdi mdi mdi-close text-danger h3"></i>
                                                            @endif
                                                        </td>

                                                        <td class="text-center align-middle">
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
                    {{-- end tabs --}}
                </div>
            </div>
        </div>
    </div>
@endsection
