
<div class="sidebar">
     
    <div class="logo-details">
        <!-- <i class='bx bxl-c-plus-plus icon'></i> -->
        <a href="{{ route('dashboard.index') }}" class="flex d-flex align-items-center text-underline-0">
        <div class="logo_name">EDTech</div>
</a>
        <i class='bx bx-menu' id="btn"></i>
    </div>

    <ul class="accordion nav-list" id="accordionExample">
           
       
        <li>
        <a href="{{ route('content.index') }}">
        <i class='bx bx-book-reader'></i>
        <span class="links_name">Lessons</span>
        </a>
        </li>
        <li>
        <a href="{{ route('course.index') }}">
        <i class='bx bx-book-content'></i>
        <span class="links_name">Courses</span>
        </a>
        </li>
        <li>
                <a href="" data-bs-toggle="collapse" data-bs-target="#library" aria-expanded="true" aria-controls="library">
                <i class='bx bx-library'></i>
                <span class="links_name">Library</span>
                </a>
                <span class="tooltip">Library</span>
                <ul id="library" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <li class="accordion-body no-padding">
                        <a  href="{{ route('library_document.index') }}">
                            <i class='bx bx-book-content'></i>
                            <span class="links_name">Document</span>
                        </a>
                        <span class="tooltip">Document</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('library_video.index') }}">
                            <i class='bx bx-video'></i>
                            <span class="links_name">Video</span>
                        </a>
                        <span class="tooltip">Video</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('library_audio.index') }}">
                            <i class='bx bx-volume-full'></i>
                            <span class="links_name">Audio</span>
                        </a>
                        <span class="tooltip">Audio</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('library_kit.index') }}">
                            <i class='bx bx-book'></i>
                            <span class="links_name">Kit</span>
                        </a>
                        <span class="tooltip">Kit</span>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class='bx bx-user-pin'></i>
                <span class="links_name">User Management</span>
                </a>
                <span class="tooltip">User Management</span>
                <ul id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <li class="accordion-body no-padding">
                        <a  href="{{ route('user.index') }}">
                            <i class='bx bx-user-minus'></i>
                            <span class="links_name">Pending Requests</span>
                        </a>
                        <span class="tooltip">Pending Requests</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('user.regisered_index') }}">
                            <i class='bx bx-user-check'></i>
                            <span class="links_name">Manage Users</span>
                        </a>
                        <span class="tooltip">Manage Users</span>
                    </li>
                     <li class="accordion-body no-padding">
                        <a href="{{ route('user.deleted_user_index') }}">
                            <i class='bx bx-user-check'></i>
                            <span class="links_name">Delete Requests</span>
                        </a>
                        <span class="tooltip">Delete Requests</span>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" data-bs-toggle="collapse" data-bs-target="#reports" aria-expanded="true" aria-controls="reports">
                <i class='bx bx-list-ul'></i>
                <span class="links_name">Reports</span>
                </a>
                <span class="tooltip">Reports</span>
                <ul id="reports" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <li class="accordion-body no-padding">
                        <a  href="{{ route('report.index') }}">
                            <i class='bx bx-user'></i>
                            <span class="links_name">Enrolled Students</span>
                        </a>
                        <span class="tooltip">Enrolled Students</span>
                    </li>
                </ul>
            </li>
            <li>
                <a href="" data-bs-toggle="collapse" data-bs-target="#configuration" aria-expanded="true" aria-controls="configuration">
                <i class='bx bx-category'></i>
                <span class="links_name">Configuration</span>
                </a>
                <span class="tooltip">Configuration</span>
                <ul id="configuration" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <li class="accordion-body no-padding">
                        <a  href="{{ route('rmo.index') }}">
                            <i class='bx bx-current-location'></i>
                            <span class="links_name">RMO</span>
                        </a>
                        <span class="tooltip">RMO</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('province.index') }}">
                            <i class='bx bx-down-arrow-circle'></i>
                            <span class="links_name">Provinces</span>
                        </a>
                        <span class="tooltip">Provinces</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('district.index') }}">
                            <i class='bx bx-droplet'></i>
                            <span class="links_name">Districts</span>
                        </a>
                        <span class="tooltip">Districts</span>
                    </li>
                    <!-- <li class="accordion-body no-padding">
                        <a href="{{ route('subject.index') }}">
                            <i class='bx bx-file'></i>
                            <span class="links_name">Subjects</span>
                        </a>
                        <span class="tooltip">Subjects</span>
                    </li> -->
                    <li class="accordion-body no-padding">
                        <a href="{{ route('grade.index') }}">
                            <i class='bx bx-layer'></i>
                            <span class="links_name">Grades</span>
                        </a>
                        <span class="tooltip">Grades</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('school.index') }}">
                            <i class='bx bx-male'></i>
                            <span class="links_name">Schools</span>
                        </a>
                        <span class="tooltip">Schools</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('notice.index') }}">
                            <i class='bx bx-user-voice'></i>
                            <span class="links_name">Notices</span>
                        </a>
                        <span class="tooltip">Notices</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('news.index') }}">
                        <i class='bx bx-file'></i>
                            <span class="links_name">News</span>
                        </a>
                        <span class="tooltip">News</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('feedback.index') }}">
                        <i class='bx bx-file'></i>
                            <span class="links_name">FeedBack</span>
                        </a>
                        <span class="tooltip">FeedBack</span>
                    </li>
                    <li class="accordion-body no-padding">
                        <a href="{{ route('game.index') }}">
                        <i class='bx bx-file'></i>
                            <span class="links_name">Game</span>
                        </a>
                        <span class="tooltip">Game</span>
                    </li>
                </ul>
            </li>
   </ul>
</div>

<style>
    .no-padding{padding: 0 0 0 16px}
    </style>