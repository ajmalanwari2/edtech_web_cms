 <!-- Footer Start -->
 <footer class="footer">
    <div class="container" style="position:relative; z-index:2">
      <div class="row">
        <div class="col-md-5" data-aos="fade-right">
          <h3>{{ __('footer.about_us') }}</h3>
          <img class="logo" src="{{ asset('assets/frontend/images/logo.png') }}">
          <p>{{ __('footer.description') }}</p>
          <div class="about-list">
            <a href="#" target="_blank"><i class="icon-facebook icon"></i></a>
            <a href="#" target="_blank"><i class="icon-instagram icon"></i></a>
            <a href="#" target="_blank"><i class="icon-twitter icon"></i></a>
            <a href="#" target="_blank"><i class="icon-linkedin icon"></i></a>
            <a href="#" target="_blank"><i class="icon-video icon"></i></a>
          </div>
        </div><!-- Column End -->
        <div class="col-md-1"></div>
        <div class="col-md-2 col-sm-6" data-aos="fade-up">
          <h3>{{ __('footer.overview') }}</h3>
          <ul>
            <li><a href="#">{{ __('footer.home') }}</a></li>
            <!-- <li><a href="#">{{ __('footer.about_us') }}</a></li> -->
            <!-- <li><a href="#">درخواستی</a></li> -->
            <li><a href="#">{{ __('footer.contact_us') }}</a></li>
          </ul>
        </div><!-- Column End -->


        <!-- <div class="col-md-3 col-sm-6" data-aos="fade-left">
          <h3>{{ __('footer.contact_us') }}</h3>
          <div class="contact-list" sytle="direction: rtl">
            <div class="item"><i class="icon icon-whatsapp"></i> +93780000000</div>
            <div class="item"><i class="icon icon-mail"></i> info@edtecheqra.com</div>
            <div class="item"><i class="icon icon-globe"></i> {{ __('footer.address') }}</div>
          </div>
        </div>Column End -->
        <div class="col-md-3 col-sm-6" data-aos="fade-left">
          <h3>{{ __('footer.contact_us') }}</h3>
            <div class="item"><i class="icon icon-whatsapp"></i> +93780000000</div>
            <div class="item"><i class="icon icon-mail"></i> info@edtecheqra.com</div>
            <div class="item"><i class="icon icon-globe"></i> {{ __('footer.address') }}</div>
        </div><!-- Column End -->

      </div>

      <div class="end clearfix">
        <p class="float-lg-start float-sm-none">&copy; 2024 {{ __('footer.all_rights_reserved') }} <a target="_blank" style="" href="https://lifetech.af">LifeTech</a></p>
        <p class="float-lg-end float-sm-none"><a href="#top"><i class="icon-up-dir"></i> {{ __('footer.go_up') }}</a></p>
      </div>
  </footer>
  <!-- Footer Endd -->


  <script>
    $(window).on("scroll", function () {
        AOS.init({
            duration: 800,
            once: true
        });
     });
  </script>
