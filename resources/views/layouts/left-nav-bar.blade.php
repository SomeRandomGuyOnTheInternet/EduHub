<div class="nav-bar">
    <h2>Your Modules</h2>
    <ul>
        @foreach($userModules as $module)
            <li>
                <a href="javascript:void(0)" onclick="toggleSubMenu('{{ $module->module_name }}')">{{ $module->module_name }}</a>
                <ul class="sub-menu" id="sub-{{ $module->module_name }}">
                    <li><a href="{{ url('home/' . $module->module_id) }}">Home</a></li>
                    @if(Auth::user()->user_type == 'professor')
                        <li><a href="{{ route('modules.professor.content.index', ['module_id' => $module->module_id]) }}">Content</a></li>
                        <li><a href="{{ route('modules.professor.assignments.index', ['module_id' => $module->module_id]) }}">Assignments</a></li>
                        <li><a href="{{ route('modules.professor.news.index', ['module_id' => $module->module_id]) }}">News</a></li>
                        <li><a href="{{ route('modules.professor.quizzes.index', ['module_id' => $module->module_id]) }}">Quizzes</a></li>
                        <li><a href="{{ route('modules.professor.meetings.index', ['module_id' => $module->module_id]) }}">Meetings</a></li>
                    @elseif(Auth::user()->user_type == 'student')
                        <li><a href="{{ route('modules.student.content.index', ['module_id' => $module->module_id]) }}">Content</a></li>
                        <li><a href="{{ route('modules.student.assignments.index', ['module_id' => $module->module_id]) }}">Assignments</a></li>
                        <li><a href="{{ route('modules.student.news.index', ['module_id' => $module->module_id]) }}">News</a></li>
                        <li><a href="{{ route('modules.student.quizzes.index', ['module_id' => $module->module_id]) }}">Quizzes</a></li>
                        <li><a href="{{ route('modules.student.meetings.index', ['module_id' => $module->module_id]) }}">Meetings</a></li>
                    @endif
                </ul>
            </li>
        @endforeach
    </ul>
</div>

<style>
    /* left-nav-bar.blade.php */
    .nav-bar {
        position: fixed;
        left: 0;
        top: 0;
        width: 220px; /* Adjust width as needed */
        height: 100%;
        background-color: #37474f; /* Dark blue background */
        color: #ffffff; /* White text color */
        padding: 20px;
        z-index: 100; /* Ensure it's on top of other elements */
    }

    .nav-bar h2 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .nav-bar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .nav-bar > ul > li {
        margin-bottom: 10px;
        transition: background-color 0.3s ease; /* Smooth transition for background color */
    }

    /* Active state for main menu item when sub-menu is open */
    .nav-bar .active {
        background-color: #ffffff; /* White background when sub-menu is open */
        color: #000000; /* Black text color when sub-menu is open */
    }

    .nav-bar a {
        text-decoration: none;
        display: block;
        padding: 10px 16px;
        color: inherit; /* Inherit text color from parent */
    }

    .sub-menu {
        display: none;
        padding-left: 20px;
    }

    .sub-menu li {
        margin-bottom: 6px;
        color: #000000; /* Default black text color */
    }

    /* Sub-menu item link styling */
    .sub-menu li > a {
        text-decoration: none;
        display: block;
        padding: 10px 16px;
        color: inherit; /* Inherit text color from parent */
    }

    /* Hover effect for sub-menu items */
    .sub-menu li:hover {
        background-color: #546e7a; /* Darker blue background on hover */
    }

    /* Hover effect for sub-menu item links */
    .sub-menu li:hover > a {
        color: #ffffff; /* White text color on hover */
    }

</style>


<script>
    function toggleSubMenu(moduleName) {
        var subMenu = document.getElementById('sub-' + moduleName);
        var allSubMenus = document.querySelectorAll('.sub-menu');
        var allMenuItems = document.querySelectorAll('.nav-bar > ul > li');

        // Close all other sub-menus
        allSubMenus.forEach(function(menu) {
            if (menu.id !== 'sub-' + moduleName) {
                menu.style.display = 'none';
                menu.parentElement.classList.remove('active');
            }
        });

        // Toggle the current sub-menu
        if (subMenu.style.display === 'none' || subMenu.style.display === '') {
            subMenu.style.display = 'block';
            subMenu.parentElement.classList.add('active');
        } else {
            subMenu.style.display = 'none';
            subMenu.parentElement.classList.remove('active');
        }
    }
</script>