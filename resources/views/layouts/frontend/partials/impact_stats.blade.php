<section class="impact-section">
    <div class="container">
        <div class="impact-grid">
            <article class="impact-card impact-card--featured" data-aos="fade-up">
                <span class="impact-card__index" aria-hidden="true">01</span>
                <span class="impact-card__icon" aria-hidden="true"><i class="icon-graduation"></i></span>
                <div class="impact-card__content">
                    <strong class="impact-card__number">{{ $total_registered_students }}</strong>
                    <span class="impact-card__label">{{ __('home.student_registration') }}</span>
                </div>
            </article>

            <article class="impact-card impact-card--video" data-aos="fade-up" data-aos-delay="80">
                <span class="impact-card__index" aria-hidden="true">02</span>
                <span class="impact-card__icon" aria-hidden="true"><i class="icon-video"></i></span>
                <div class="impact-card__content">
                    <strong class="impact-card__number">{{ $videoCount }}</strong>
                    <span class="impact-card__label">{{ __('home.video_lossons') }}</span>
                </div>
            </article>

            <article class="impact-card impact-card--audio" data-aos="fade-up" data-aos-delay="160">
                <span class="impact-card__index" aria-hidden="true">03</span>
                <span class="impact-card__icon" aria-hidden="true"><i class="icon-music"></i></span>
                <div class="impact-card__content">
                    <strong class="impact-card__number">{{ $audioCount }}</strong>
                    <span class="impact-card__label">{{ __('home.audio_lossons') }}</span>
                </div>
            </article>

            <article class="impact-card impact-card--books" data-aos="fade-up" data-aos-delay="240">
                <span class="impact-card__index" aria-hidden="true">04</span>
                <span class="impact-card__icon" aria-hidden="true"><i class="icon-doc-text"></i></span>
                <div class="impact-card__content">
                    <strong class="impact-card__number">{{ $documentCount }}</strong>
                    <span class="impact-card__label">{{ __('home.document_lessons') }}</span>
                </div>
            </article>
        </div>
    </div>
</section>
