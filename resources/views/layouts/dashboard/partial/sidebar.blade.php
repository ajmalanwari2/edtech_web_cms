<div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">ED Tech</div>
            <i class='bx bx-menu' id="btn" ></i>
        </div>

        <ul class="accordion nav-list" id="accordionExample">
           
                <!-- <ul id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <li class="accordion-body no-pad">
                        <a href="">
                            <i class='bx bx-right-arrow-alt'></i>
                            <span class="links_name">Grade 1</span>
                        </a>
                    </li>
                    <li class="accordion-body no-pad">
                        <a href="">
                            <i class='bx bx-right-arrow-alt'></i>
                            <span class="links_name">Grade 1</span>
                        </a>
                    </li>
                    <li class="accordion-body no-pad">
                        <a href="">
                            <i class='bx bx-right-arrow-alt'></i>
                            <span class="links_name">Grade 1</span>
                        </a>
                    </li>
                </ul> -->
            <!-- </li> -->
            @foreach ($grades as $grade)
            <li>
            <a href="{{route('landing.subject', $grade->id)}}">
            <i class='bx bx-book-content'></i>
            <span class="links_name">{{$grade->name}}</span>
            </a>
            </li>
            @endforeach
        </ul>
    </div>

    