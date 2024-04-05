<!-- Slideshow Started -->
<div id="slideshow" class="slideshow carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#slideshow" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#slideshow" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#slideshow" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">

      <!-- Slider 1 Start -->
      <div class="carousel-item">
        <img src="{{ asset('assets/frontend/images/slider1.jpg') }}" aria-hidden="true" focusable="false" class="bd-placeholder-img" />
        <div class="container position-relative">
          <div class="carousel-caption text-start">
            <!-- <h1 class="slide-title">سلاید شو امتحانی اول</h1> -->
            <!-- <p>جمله امتحانی وبسایت موقتی میباشد اینجا </p>
            <a class="btn btn-lg btn-primary" href="about.html">ادامه مطلب  <i class="fa-solid fa-arrow-right"></i></a> -->
          </div>
        </div>
      </div>
      <!-- Slider 1 End -->

      <!-- Slider 2 Start -->
      <div class="carousel-item">
        <img src="{{ asset('assets/frontend/images/slider2.jpg') }}" aria-hidden="true" focusable="false" class="bd-placeholder-img" />
        <div class="container position-relative">
          <div class="carousel-caption text-start">
            <!-- <h1 class="slide-title">سلاید شو دوم وبسایت</h1>
            <p>جمله امتحانی وبسایت موقتی میباشد اینجا </p>
            <a class="btn btn-lg btn-primary" href="about.html">ادامه مطلب  <i class="fa-solid fa-arrow-right"></i></a> -->
          </div>
        </div>
      </div>
      <!-- Slider 2 End -->

      <!-- Slider 3 Start -->
      <div class="carousel-item">
        <img src="{{ asset('assets/frontend/images/slider3.jpg') }}" aria-hidden="true" focusable="false" class="bd-placeholder-img" />
        <div class="container position-relative">
          <div class="carousel-caption text-start">
            <!-- <h1 class="slide-title">جمله موقتی سلاید شو</h1>
            <p>جمله امتحانی وبسایت موقتی میباشد اینجا </p>
            <a class="btn btn-lg btn-primary" href="about.html">ادامه مطلب  <i class="fa-solid fa-arrow-right"></i></a> -->
          </div>
        </div>
      </div>
      <!-- Slider 3 End -->

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#slideshow" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#slideshow" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>

  </div>
  <script type="text/javascript">
    $(".carousel-item:first-child").addClass("active");
  </script>
  <!-- End Slideshow -->
