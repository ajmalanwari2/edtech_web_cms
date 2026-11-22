<header id="top" class="site-header">
    <div class="container site-header__top">
        <div class="site-brand-group">
            <a class="site-brand" href="/{{ $lang }}" aria-label="EdTech — {{ __('footer.home') }}">
                <img src="{{ asset('assets/frontend/images/logo.png') }}" alt="EdTech">
            </a>
            <div class="site-social" aria-label="Social media">
                <a href="#" aria-label="Facebook" title="Facebook"><i class="icon-facebook" aria-hidden="true"></i></a>
                <a href="#" aria-label="Instagram" title="Instagram"><i class="icon-instagram" aria-hidden="true"></i></a>
                <a href="#" aria-label="Twitter" title="Twitter"><i class="icon-twitter" aria-hidden="true"></i></a>
                <a href="#" aria-label="LinkedIn" title="LinkedIn"><i class="icon-linkedin" aria-hidden="true"></i></a>
                <a href="#" aria-label="YouTube" title="YouTube"><i class="icon-video" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="site-header__tools">
            <div class="language" aria-label="Select language">
                <a href="/da" lang="fa" @if($lang === 'da') aria-current="page" @endif>دری</a>
                <a href="/pa" lang="ps" @if($lang === 'pa') aria-current="page" @endif>پښتو</a>
                <a href="/en" lang="en" @if($lang === 'en') aria-current="page" @endif>EN</a>
            </div>
            <button class="site-menu-toggle" type="button" aria-expanded="false" aria-controls="main-menu">
                <span></span><span></span><span></span>
                <span class="visually-hidden">Toggle navigation</span>
            </button>
        </div>
    </div>

    <div class="site-header__nav-shell">
        <nav class="site-nav container" aria-label="Main navigation">
            <ul id="main-menu">
                <li><a href="/{{ $lang }}" @if (request()->path() === $lang) aria-current="page" @endif>{{ __('footer.home') }}</a></li>
                <li><a href="/{{ $lang }}/content" @if (request()->is($lang . '/content*')) aria-current="page" @endif>{{ __('footer.contents') }}</a></li>
                <li><a href="/{{ $lang }}/course" @if (request()->is($lang . '/course*')) aria-current="page" @endif>{{ __('footer.courses') }}</a></li>
                <li class="has-submenu">
                    <a href="#download">{{ __('footer.download') }}</a>
                    <ul class="site-submenu">
                        <li><a href="#download">{{ __('footer.android') }}</a></li>
                        <li><a href="#download">{{ __('footer.apple') }}</a></li>
                    </ul>
                </li>
                <li><a href="/{{ $lang }}/contact" @if (request()->is($lang . '/contact*')) aria-current="page" @endif>{{ __('footer.contact') }}</a></li>
                <li><a class="site-nav__cta" href="/{{ $lang }}/request_form" @if (request()->is($lang . '/request_form*')) aria-current="page" @endif>{{ __('footer.request_access') }}</a></li>
            </ul>
        </nav>
    </div>
</header>

<script>
    (() => {
        const toggle = document.querySelector('.site-menu-toggle');
        const nav = document.querySelector('.site-header__nav-shell');
        if (!toggle || !nav) return;
        toggle.addEventListener('click', () => {
            const isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isOpen));
            nav.classList.toggle('is-open', !isOpen);
        });
    })();
</script>
