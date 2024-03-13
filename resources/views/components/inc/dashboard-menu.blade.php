<nav id="sidebar" aria-label="Main Navigation">
    <div class="content-header">
        <a class="font-semibold text-dual" href="/">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">LAKHPATI</span>
        </a>
       
        <div>
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
    </div>


    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                        <i class="nav-main-link-icon si si-cursor"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-main-heading">Contest Management</li>
                {{-- <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon si si-bulb"></i>
                        <span class="nav-main-link-name">Examples</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}" href="/pages/datatables">
                                <span class="nav-main-link-name">DataTables</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/slick') ? ' active' : '' }}" href="/pages/slick">
                                <span class="nav-main-link-name">Slick Slider</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/blank') ? ' active' : '' }}" href="/pages/blank">
                                <span class="nav-main-link-name">Blank</span>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('contests/create') ? ' active' : '' }}" href="{{route('createContest')}}">
                        <i class="nav-main-link-icon si si-plus"></i>
                        <span class="nav-main-link-name">Create Contest</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('contests') ? ' active' : '' }}" href="{{route('listContests')}}">
                        <i class="nav-main-link-icon si si-list"></i>
                        <span class="nav-main-link-name">List Contests</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>