<div class="nav-bar">
    <h2>This is the left nav bar bro</h2>
    <h2>Modules:</h2>
    <ul>
        @foreach($userModules as $module)
            <li>
                <a href="javascript:void(0)" onclick="toggleSubMenu('{{ $module->module_name }}')">{{ $module->module_name }}</a>
                <ul class="sub-menu" id="sub-{{ $module->module_name }}">
                    <li><a href="{{ url('home/' . $module->module_id) }}">Home</a></li>
                    <li>
                        @if(Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.content.index', ['module_id' => $module->module_id]) }}">Content</a>
                        @elseif(Auth::user()->user_type == 'student')
                            <a href="{{ route('modules.student.content.index', ['module_id' => $module->module_id]) }}">Content</a>
                        @endif
                    </li>
                    <li>
                        @if(Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.assignments.index', ['module_id' => $module->module_id]) }}">Assignments</a>
                        @endif
                    </li>
                    <li>
                        @if(Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.news.index', ['module_id' => $module->module_id]) }}">News</a>
                        @elseif(Auth::user()->user_type == 'student')
                            <a href="{{ route('modules.student.news.index', ['module_id' => $module->module_id]) }}">News</a>
                        @endif
                    </li>
                    <li>
                        @if(Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.quizzes.index', ['module_id' => $module->module_id]) }}">Quizzes</a>
                        @elseif(Auth::user()->user_type == 'student')
                            <a href="{{ route('modules.student.quizzes.index', ['module_id' => $module->module_id]) }}">Quizzes</a>
                        @endif
                    </li>
                    <li>
                        @if(Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.meetings.index', ['module_id' => $module->module_id]) }}">Meetings</a>
                        @elseif(Auth::user()->user_type == 'student')
                            <a href="{{ route('modules.student.meetings.index', ['module_id' => $module->module_id]) }}">Meetings</a>
                        @endif
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function toggleSubMenu(moduleName) {
        var subMenu = document.getElementById('sub-' + moduleName);
        if (subMenu.style.display === 'none' || subMenu.style.display === '') {
            subMenu.style.display = 'block';
        } else {
            subMenu.style.display = 'none';
        }
    }
</script>

<style>
    /* left-nav-bar.blade.php */
    .nav-bar {
        position: fixed;
        left: 0;
        top: 0;
        width: 200px; /* Adjust width as needed */
        height: 100%;
        background-color: #f8f9fa;
        padding: 20px;
        z-index: 100; /* Ensure it's on top of other elements */
    }
</style>
