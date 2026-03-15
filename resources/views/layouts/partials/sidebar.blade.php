<div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-dark shadow" id="sidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between mb-4">
        <a href="/" class="d-flex align-items-center text-decoration-none">
            <i class="bi bi-mortarboard-fill fs-3 me-2 text-primary"></i>
            <span class="fs-4 fw-bold logo-text">ShuleReport</span>
        </a>
    </div>
    
    <ul class="nav nav-pills flex-column mb-auto">
        @auth
            @if(auth()->user()->role === 'super_admin')
                <li class="nav-item mb-1">
                    <a href="{{ route('super_admin.dashboard') }}" class="nav-link {{ request()->routeIs('super_admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill me-2"></i> <span>Users & Roles</span>
                    </a>
                </li>
            @elseif(auth()->user()->role === 'academic_master')
                <li class="nav-item mb-1">
                    <a href="{{ route('master.dashboard') }}" class="nav-link {{ request()->routeIs('master.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('academic-years.index') }}" class="nav-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar3 me-2"></i> <span>Academic Years</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('grade-settings.index') }}" class="nav-link {{ request()->routeIs('grade-settings.*') ? 'active' : '' }}">
                        <i class="bi bi-sliders me-2"></i> <span>Grade Settings</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('promotions.index') }}" class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-up-circle me-2"></i> <span>Promotions</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('invitations.index') }}" class="nav-link {{ request()->routeIs('invitations.*') ? 'active' : '' }}">
                        <i class="bi bi-envelope-plus me-2"></i> <span>Invitations</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear me-2"></i> <span>Settings</span>
                    </a>
                </li>
            @elseif(auth()->user()->role === 'academic_department')
                <li class="nav-item mb-1">
                    <a href="{{ route('department.dashboard') }}" class="nav-link {{ request()->routeIs('department.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('classes.index') }}" class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                        <i class="bi bi-building me-2"></i> <span>Classes</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('subjects.index') }}" class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <i class="bi bi-book me-2"></i> <span>Subjects</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('students.index') }}" class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> <span>Students</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('assignments.index') }}" class="nav-link {{ request()->routeIs('assignments.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge me-2"></i> <span>Teacher Assignments</span>
                    </a>
                </li>
            @elseif(auth()->user()->role === 'teacher')
                <li class="nav-item mb-1">
                    <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('marks.index') }}" class="nav-link {{ request()->routeIs('marks.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-check me-2"></i> <span>My Marks</span>
                    </a>
                </li>
            @endif
        @endauth
    </ul>
    
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle logo-text" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2 text-white" style="width: 32px; height: 32px;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <strong>{{ auth()->user()->name }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow border-0" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
