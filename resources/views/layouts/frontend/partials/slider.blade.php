@php
    $heroSlides = [
        ['image' => 'slider33.jpg', 'title' => __('home.slide_show_title'), 'description' => __('home.slide_show_description'), 'button' => __('home.learmore')],
        ['image' => 'slider2.jpg', 'title' => __('home.slide_show_title1'), 'description' => __('home.slide_show_description1'), 'button' => __('home.learnmore1')],
        ['image' => 'slider3.jpg', 'title' => __('home.slide_show_title2'), 'description' => __('home.slide_show_description2'), 'button' => __('home.learnmore2')],
    ];
@endphp

<section id="slideshow" class="academy-hero carousel slide carousel-fade" data-bs-ride="carousel" aria-label="EdTech Eqra">
    <div class="carousel-inner">
        @foreach ($heroSlides as $slide)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="academy-hero__container">
                    <div class="academy-hero__grid">
                        <div class="academy-hero__copy">
                            <span class="academy-hero__eyebrow">EdTech Eqra</span>
                            <h1>{{ $slide['title'] }}</h1>
                            <p>{{ $slide['description'] }}</p>
                            <a class="academy-hero__cta" href="/{{ $lang }}/content">
                                {{ $slide['button'] }}
                                <span class="academy-hero__cta-arrow" aria-hidden="true">&#8594;</span>
                            </a>
                        </div>
                        <div class="academy-hero__media">
                            <img src="{{ asset('assets/frontend/images/' . $slide['image']) }}" alt="" aria-hidden="true">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="academy-hero__footer">
        <div class="carousel-indicators academy-hero__indicators">
            @foreach ($heroSlides as $slide)
                <button type="button" data-bs-target="#slideshow" data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}" @if ($loop->first) aria-current="true" @endif
                    aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>
        <div class="academy-hero__arrows">
            <button type="button" data-bs-target="#slideshow" data-bs-slide="prev" aria-label="Previous slide">
                <span aria-hidden="true">&#8592;</span>
            </button>
            <button type="button" data-bs-target="#slideshow" data-bs-slide="next" aria-label="Next slide">
                <span aria-hidden="true">&#8594;</span>
            </button>
        </div>
    </div>
</section>
