<footer class="footer" id="site-footer">
    <div class="container footer__inner">
        <div class="row footer__main">
            <section class="col-lg-5 col-md-6 footer__brand" aria-labelledby="footer-about-title">
                <h3 id="footer-about-title">{{ __('footer.about_us') }}</h3>
                <img class="logo" src="{{ asset('assets/frontend/images/logo.png') }}" alt="EdTech">
                <p>{{ __('footer.description') }}</p>
                <div class="about-list" aria-label="Social media">
                    <a href="#" aria-label="Facebook" title="Facebook"><i class="icon-facebook icon" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Instagram" title="Instagram"><i class="icon-instagram icon" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Twitter" title="Twitter"><i class="icon-twitter icon" aria-hidden="true"></i></a>
                    <a href="#" aria-label="LinkedIn" title="LinkedIn"><i class="icon-linkedin icon" aria-hidden="true"></i></a>
                    <a href="#" aria-label="YouTube" title="YouTube"><i class="icon-video icon" aria-hidden="true"></i></a>
                </div>
            </section>

            <nav class="col-lg-3 col-md-6 footer__links" aria-labelledby="footer-links-title">
                <h3 id="footer-links-title">{{ __('footer.overview') }}</h3>
                <ul>
                    <li><a href="/{{ $lang }}">{{ __('footer.home') }}</a></li>
                    <li><a href="/{{ $lang }}/content">{{ __('footer.contents') }}</a></li>
                    <li><a href="/{{ $lang }}/course">{{ __('footer.courses') }}</a></li>
                    <li><a href="/{{ $lang }}/contact">{{ __('footer.contact_us') }}</a></li>
                    <li><a href="/{{ $lang }}/term_and_policy">{{ __('footer.terms_and_policy') }}</a></li>
                </ul>
            </nav>

            <section class="col-lg-4 col-md-12 footer__contact" aria-labelledby="footer-contact-title">
                <h3 id="footer-contact-title">{{ __('footer.contact_us') }}</h3>
                <div class="contact-list">
                    <div class="item"><i class="icon icon-whatsapp" aria-hidden="true"></i><span>+93780000000</span></div>
                    <div class="item"><i class="icon icon-mail" aria-hidden="true"></i><a href="mailto:info@edtecheqra.com">info@edtecheqra.com</a></div>
                    <div class="item"><i class="icon icon-globe" aria-hidden="true"></i><span>{{ __('footer.address') }}</span></div>
                </div>
            </section>
        </div>

        <div class="footer__bottom">
            <p>&copy; {{ __('footer.all_rights_reserved') }} <a target="_blank" rel="noopener" href="https://lifetech.af">LifeTech</a></p>
            <a href="#top"><i class="icon-up-dir" aria-hidden="true"></i> {{ __('footer.go_up') }}</a>
        </div>
    </div>
</footer>

<script>
    if (window.AOS) {
        AOS.init({ duration: 800, once: true });
    }
</script>
