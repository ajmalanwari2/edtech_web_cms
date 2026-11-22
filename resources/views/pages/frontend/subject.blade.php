@extends($lang === 'en' ? 'layouts.frontend.master' : 'layouts.frontend.master_rtl')

@section('styles')
<title>{{ $subject->subject_name }} · {{ $subject->grade_name }} | EdTech Eqra</title>
<link href="{{ asset('assets/frontend/css/subject.css') }}?v=20261114" rel="stylesheet">
@endsection

@section('content')
<main class="subject-page" id="subject-page" dir="{{ $lang === 'en' ? 'ltr' : 'rtl' }}">
    <div class="container">
        <nav class="subject-breadcrumb" aria-label="{{ __('subject.breadcrumb') }}">
            <a href="{{ url($lang) }}">{{ __('subject.home') }}</a><span aria-hidden="true">/</span>
            <a href="{{ url($lang . '/content') }}">{{ __('subject.school') }}</a><span aria-hidden="true">/</span>
            <a href="{{ url($lang . '/grade/' . $subject->grade_id) }}" dir="auto">{{ $subject->grade_name }}</a><span aria-hidden="true">/</span>
            <span aria-current="page" dir="auto">{{ $subject->subject_name }}</span>
        </nav>
        <div class="subject-heading">
            <div>
                <p class="subject-eyebrow">{{ __('subject.classroom') }}</p>
                <h1 dir="auto">{{ $subject->subject_name }}</h1>
                <p class="subject-intro">{{ __('subject.intro') }}</p>
            </div>
            <a class="subject-back" href="{{ url($lang . '/grade/' . $subject->grade_id) }}">
                <span class="subject-back__arrow" aria-hidden="true">←</span> {{ __('subject.all_subjects') }}
            </a>
        </div>
        <div class="subject-summary">
            <span class="subject-grade" dir="auto">{{ $subject->grade_name }}</span>
            <span>{{ $subjectContents->count() }} {{ __('subject.lessons') }}</span>
            <span><i class="icon-video" aria-hidden="true"></i> {{ $subjectContents->filter(fn ($chapter) => filled($chapter->video_body))->count() }} {{ __('subject.videos') }}</span>
            <span><i class="icon-doc-text" aria-hidden="true"></i> {{ $subjectContents->whereNotNull('book_url')->count() }} {{ __('subject.books') }}</span>
        </div>
        @if($subjectContents->isEmpty())
            <div class="subject-empty">
                <i class="icon-doc-text" aria-hidden="true"></i>
                <h2>{{ __('subject.empty_title') }}</h2>
                <p>{{ __('subject.empty_description') }}</p>
                <a class="subject-button subject-button--primary" href="{{ url($lang . '/grade/' . $subject->grade_id) }}">{{ __('subject.all_subjects') }}</a>
            </div>
        @else
            <div class="subject-workspace">
                <section class="subject-viewer" aria-labelledby="lesson-title">
                    <div class="subject-player" id="subject-player" aria-busy="false">
                        <iframe id="main-video" title="{{ __('subject.video_player') }}" hidden
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <div class="subject-player__message" id="player-message" role="status">
                            <span class="subject-player__icon" aria-hidden="true"><i class="icon-video"></i></span>
                            <h2 id="player-message-title">{{ __('subject.select_lesson') }}</h2>
                            <p id="player-message-description">{{ __('subject.intro') }}</p>
                            <button type="button" id="play-lesson" class="subject-button subject-button--light" hidden>
                                <i class="icon-video" aria-hidden="true"></i> {{ __('subject.play') }}
                            </button>
                        </div>
                    </div>
                    <div class="subject-lesson-info">
                        <p class="subject-eyebrow" id="lesson-position" aria-live="polite"></p>
                        <h2 id="lesson-title" dir="auto">{{ __('subject.select_lesson') }}</h2>
                        <p class="subject-lesson-context" dir="auto">{{ $subject->grade_name }} · {{ $subject->subject_name }}</p>
                        <div class="subject-lesson-actions">
                            <a id="lesson-book" class="subject-button subject-button--primary" target="_blank" rel="noopener noreferrer" hidden>
                                <i class="icon-doc-text" aria-hidden="true"></i> {{ __('subject.open_book') }}
                                <span class="visually-hidden">{{ __('subject.new_tab') }}</span>
                            </a>
                            <span id="lesson-no-book" class="subject-muted" hidden>{{ __('subject.no_book') }}</span>
                            <span class="subject-online-note"><span aria-hidden="true">●</span> {{ __('subject.online_note') }}</span>
                        </div>
                    </div>
                    <nav class="subject-lesson-nav" aria-label="{{ __('subject.lesson_navigation') }}">
                        <button type="button" id="previous-lesson" class="subject-button"><span class="subject-back__arrow" aria-hidden="true">←</span> {{ __('subject.previous') }}</button>
                        <button type="button" id="next-lesson" class="subject-button">{{ __('subject.next') }} <span class="subject-back__arrow" aria-hidden="true">→</span></button>
                    </nav>
                </section>
                <aside class="subject-outline" aria-labelledby="outline-title">
                    <div class="subject-outline__heading">
                        <div><p class="subject-eyebrow">{{ __('subject.keep_learning') }}</p><h2 id="outline-title">{{ __('subject.lesson_list') }}</h2></div>
                        <span class="subject-count">{{ $subjectContents->count() }}</span>
                    </div>
                    <div class="subject-search">
                        <i class="icon-search" aria-hidden="true"></i>
                        <label for="lesson-search" class="visually-hidden">{{ __('subject.search') }}</label>
                        <input type="search" id="lesson-search" placeholder="{{ __('subject.search') }}" autocomplete="off" aria-controls="lesson-list" dir="auto">
                    </div>
                    <ol class="subject-lesson-list" id="lesson-list">
                        @foreach($subjectContents as $chapter)
                            <li class="subject-lesson" data-chapter="{{ $chapter->chapter_id }}">
                                <button type="button" class="subject-lesson__select" data-video="{{ $chapter->video_body }}" data-video-title="{{ $chapter->video_title }}" aria-controls="subject-player">
                                    <span class="subject-lesson__number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="subject-lesson__text">
                                        <b class="subject-lesson__title" dir="auto">{{ $chapter->chapter_name }}</b>
                                        <span class="subject-lesson__meta">{{ filled($chapter->video_body) ? __('subject.video_lesson') : __('subject.no_video_short') }}</span>
                                    </span>
                                    <i class="icon-video subject-lesson__play" aria-hidden="true"></i>
                                </button>
                                @if($chapter->book_url)
                                    <a class="subject-lesson__book" href="{{ $chapter->book_url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('subject.open_book') }}: {{ $chapter->chapter_name }} — {{ __('subject.new_tab') }}" title="{{ __('subject.open_book') }}">
                                        <i class="icon-doc-text" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                    <p id="lesson-search-empty" class="subject-search-empty" role="status" hidden>{{ __('subject.no_results') }}</p>
                    <div class="subject-outline__footer">{{ __('subject.select_hint') }}</div>
                </aside>
            </div>
            <noscript><p class="subject-empty">{{ __('subject.enable_javascript') }}</p></noscript>
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    window.subjectTranslations = {{ Illuminate\Support\Js::from(__('subject')) }};
</script>
<script src="{{ asset('assets/frontend/js/subject.js') }}?v=20261114" defer></script>
@endsection
