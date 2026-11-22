(() => {
    'use strict';

    const root = document.getElementById('subject-page');
    if (!root) return;
    const lessons = Array.from(root.querySelectorAll('.subject-lesson'));
    if (!lessons.length) return;

    const strings = window.subjectTranslations;
    const player = document.getElementById('main-video');
    const message = document.getElementById('player-message');
    const playButton = document.getElementById('play-lesson');
    const bookLink = document.getElementById('lesson-book');
    const previous = document.getElementById('previous-lesson');
    const next = document.getElementById('next-lesson');
    let current = -1;
    let currentVideo = null;

    function youtubeId(value) {
        if (!value) return null;
        const raw = value.trim();
        if (/^[\w-]{11}$/.test(raw)) return raw;

        try {
            const url = new URL(/^https?:\/\//i.test(raw) ? raw : 'https://' + raw);
            if (!['http:', 'https:'].includes(url.protocol)) return null;
            const host = url.hostname.toLowerCase().replace(/^www\./, '');
            let id;
            if (host === 'youtu.be') {
                id = url.pathname.split('/')[1];
            } else if (['youtube.com', 'm.youtube.com', 'music.youtube.com', 'youtube-nocookie.com'].includes(host)) {
                const parts = url.pathname.split('/').filter(Boolean);
                id = parts[0] === 'watch' ? url.searchParams.get('v') :
                    ['embed', 'shorts', 'live', 'v'].includes(parts[0]) ? parts[1] : null;
            }
            return id && /^[\w-]{11}$/.test(id) ? id : null;
        } catch {
            return null;
        }
    }

    function play() {
        if (!currentVideo) return;
        player.src = 'https://www.youtube.com/embed/' + currentVideo + '?autoplay=1&rel=0';
        player.hidden = false;
        message.hidden = true;
    }

    function selectLesson(index, autoplay = false, reveal = false) {
        if (index < 0 || index >= lessons.length) return;
        current = index;
        player.removeAttribute('src');
        player.hidden = true;
        message.hidden = false;

        lessons.forEach((lesson, position) => {
            const button = lesson.querySelector('.subject-lesson__select');
            lesson.classList.toggle('is-active', position === index);
            if (position === index) button.setAttribute('aria-current', 'true');
            else button.removeAttribute('aria-current');
        });

        const lesson = lessons[index];
        const button = lesson.querySelector('.subject-lesson__select');
        const chapterTitle = lesson.querySelector('.subject-lesson__title').textContent;
        document.getElementById('lesson-title').textContent = button.dataset.videoTitle || chapterTitle;
        document.getElementById('lesson-position').textContent = strings.position
            .replace(':current', String(index + 1)).replace(':total', String(lessons.length));
        player.title = chapterTitle;

        const resource = lesson.querySelector('.subject-lesson__book');
        bookLink.hidden = !resource;
        if (resource) bookLink.href = resource.href;
        else bookLink.removeAttribute('href');
        document.getElementById('lesson-no-book').hidden = Boolean(resource);

        currentVideo = youtubeId(button.dataset.video);
        playButton.hidden = !currentVideo;
        document.getElementById('player-message-title').textContent = currentVideo ? strings.ready : strings.no_video;
        document.getElementById('player-message-description').textContent = currentVideo ? strings.ready_description : strings.no_video_description;
        previous.disabled = index === 0;
        next.disabled = index === lessons.length - 1;
        if (autoplay && currentVideo) play();

        if (reveal) {
            // Scroll only the lesson list; keep the page and player in place.
            const list = document.getElementById('lesson-list');
            const rowBounds = lesson.getBoundingClientRect();
            const listBounds = list.getBoundingClientRect();
            if (rowBounds.top < listBounds.top) list.scrollTop -= listBounds.top - rowBounds.top;
            else if (rowBounds.bottom > listBounds.bottom) list.scrollTop += rowBounds.bottom - listBounds.bottom;
        }
    }

    lessons.forEach((lesson, index) => {
        lesson.querySelector('.subject-lesson__select').addEventListener('click', () => selectLesson(index, true));
    });
    playButton.addEventListener('click', play);
    const search = document.getElementById('lesson-search');
    function normalize(value) {
        return value.toLowerCase().normalize('NFKC').replace(/[يى]/g, 'ی').replace(/ك/g, 'ک')
            .replace(/[\u064B-\u065F\u0670\u0640\u200C\u200D]/g, '').trim();
    }
    function filterLessons() {
        const query = normalize(search.value);
        let matches = 0;
        lessons.forEach(lesson => {
            lesson.hidden = !normalize(lesson.querySelector('.subject-lesson__title').textContent).includes(query);
            if (!lesson.hidden) matches++;
        });
        document.getElementById('lesson-search-empty').hidden = matches > 0;
    }
    search.addEventListener('input', filterLessons);
    function navigate(offset) {
        search.value = '';
        filterLessons();
        selectLesson(current + offset, true, true);
    }
    previous.addEventListener('click', () => navigate(-1));
    next.addEventListener('click', () => navigate(1));
    selectLesson(0);
})();
