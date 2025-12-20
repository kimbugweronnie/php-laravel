<nav class="navbar navbar-expand navbar-light navbar-bg" style="background-color: #2bacf7;">
    <a class="sidebar-toggle js-sidebar-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#ffffff" class="bi bi-list"
            viewBox="0 0 15 15">
            <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </svg>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                <a class="nav-link dropdown-toggle text-white d-none d-sm-inline-block py-0" href="#"
                    data-bs-toggle="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="#ffffff"
                        class="bi bi-person-circle" viewBox="0 0 18 18">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                    @if(Session::get('userDetails'))
                        <span class="text-white">{{ \Str::ucfirst(\Str::lower(Session::get('userDetails')['first_name'])) }} {{ \Str::ucfirst(\Str::lower(Session::get('userDetails')['last_name'])) }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <a class="dropdown-item" href="#">
                        <i class="align-middle me-1" data-feather="settings"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div> --}}
                    <a class="dropdown-item" href="{{ route('signout') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-box-arrow-right me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                            <path fill-rule="evenodd"
                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg>
                        Log out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
