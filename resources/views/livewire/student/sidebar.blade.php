<div class="d-flex flex-column flex-shrink-0 d-none d-lg-block bg-light" style="width: 280px;">
    <a href="/" class="d-flex align-items-center py-4 px-3 link-dark text-decoration-none">
        <img src="{{ $logoUrl }}" alt="Logo" height="45">
    </a>
    <ul class="list-unstyled flex-column overflow-auto mb-auto mt-4 px-3">
        <li class="mb-1">
            <a
                href="{{ route('student.dashboard') }}"
                class="btn btn-lg fw-medium {{ $currentPage === StudentSidebarLink::Dashboard ? 'sidebar-active' : '' }} d-flex text-start">
                <i class="bi bi-house-door me-2"></i>
                Dashboard
            </a>
        </li>
        <li class="mx-3 mt-3 mb-1">
            <span class="text-secondary">Modules</span>
        </li>
        @forelse($modules as $module)
            <li class="mb-1 heading">
                <button
                    class="btn btn-lg btn-toggle fw-medium {{ $currentModule == $module->module_id ? '' : 'collapsed' }} d-flex text-start"
                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}"
                    aria-expanded="{{ $currentModule == $module->module_id ? 'true' : 'false' }}">
                    <i class="bi bi-chevron-down me-2"></i>
                    {{ $module->module_name }}
                </button>
                <div class="{{ $currentModule == $module->module_id ? 'collapse show' : 'collapse' }}"
                    id="collapse-{{ $loop->index }}">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li>
                            <a href="{{ route('modules.student.home.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleHome ? 'sidebar-active' : '' }} link-dark rounded topic">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('modules.student.content.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleContent ? 'sidebar-active' : '' }} link-dark rounded topic">
                                Content
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('modules.student.assignment.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleAssignment ? 'sidebar-active' : '' }} link-dark rounded topic">
                                Assignments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('modules.student.news.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleNews ? 'sidebar-active' : '' }} link-dark rounded topic">
                                News
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('modules.student.quizzes.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleQuiz ? 'sidebar-active' : '' }} link-dark rounded topic">
                                Quizzes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('modules.student.meetings.index', ['module_id' => $module->module_id]) }}"
                                class="{{ $currentPage === StudentSidebarLink::ModuleMeetings ? 'sidebar-active' : '' }} link-dark rounded topic">
                                Meetings
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        @empty
            <p class="p-3">No modules pinned.</p>
        @endforelse
    </ul>
    <div class="dropdown border-top p-4 mt-4 w-100">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ $userProfileUrl }}" alt="" width="32" height="32" class="rounded-circle me-2">
            <span>{{ $userName }}</sppan>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="/profile">Settings</a></li>
            <li><a class="dropdown-item" href="/profile">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Sign out</button>
                </form>
            </li>
        </ul>
    </div>
</div>