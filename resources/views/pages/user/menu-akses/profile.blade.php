{{-- profil --}}
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card bg-primary">
            <div class="card-body profile-user-box">
                <div class="media">
                    <span class="float-left m-2 mr-4">
                        @if ($user->profil->avatar != null)
                            <img
                                src="{{ asset('storage/' . $user->profil->avatar) }}"
                                style="height: 100px;"
                                alt=""
                                class="rounded-circle img-thumbnail"
                            />
                        @else
                            <img
                                src="{{ asset('assets/images/avatars/avatar_default.webp') }}"
                                style="height: 100px;"
                                alt=""
                                class="rounded-circle img-thumbnail"
                            />
                        @endif
                    </span>

                    <div class="media-body">
                        <h4 class="mt-1 mb-1 text-white">{{ $user->profil->nama_lengkap }}</h4>
                        <p class="font-13 text-white-50">{{ $user->username }}</p>

                        <ul class="mb-0 list-inline text-light">
                            <li class="list-inline-item mr-3">
                                <h5 class="mb-1 text-white">{{ $user->active == 1 ? 'Aktif' : 'Tidak Aktif' }}</h5>
                                <p class="mb-0 font-13 text-white-50">Status</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-1 text-white">{{ $user->divisi->nama_divisi }}</h5>
                                <p class="mb-0 font-13 text-white-50">{{ $user->seksi }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end profil --}}
