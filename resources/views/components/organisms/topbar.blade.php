<div class="navbar-custom d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center">
        <button class="button-menu-mobile open-left disable-btn">
            <i class="mdi mdi-menu"></i>
        </button>

        <h5 id="datetime"></h5>
    </div>

    <ul class="list-unstyled topbar-right-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown"
                href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">
                    @if (Auth::user()->profil->avatar != null)
                        <img src="{{ asset('storage/' . Auth::user()->profil->avatar) }}" alt="user-image"
                            class="rounded-circle" />
                    @else

                        <img src="{{ asset('assets/images/avatars/avatar_default.webp') }}" alt="user-image"
                            class="rounded-circle" />
                    @endif
                </span>
                <span>
                    <span class="account-user-name">
                        {{ Auth::user()->profil->nama_lengkap }}
                    </span>
                    <span class="account-position">
                        {{ strtoupper(Auth::user()->divisi->nama_divisi) }}
                    </span>
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <a href="{{ route('profil') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle mr-1"></i>
                    <span>Profil</span>
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout text-danger mr-1"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>
    </ul>
</div>
