// ──────────────────────────────────────────────────
// Roster V2 Prototype — Concept A: Filter-in-Place
// ──────────────────────────────────────────────────

(function() {

    // ── State ──
    var state = {
        dept: 'ALL',
        artist: null,
        artistName: null
    };

    var feed = document.getElementById('videoFeed');
    var cards = feed.querySelectorAll('.video-card');
    var dividers = feed.querySelectorAll('.artist-divider');
    var tabs = document.querySelectorAll('.dept-tab');
    var breadcrumbTrail = document.querySelector('.breadcrumb-trail');

    // ── Rolling Scale/Opacity Effect ──
    function handleScroll() {
        var vh = window.innerHeight;
        var visibleCards = feed.querySelectorAll('.video-card:not(.filtered-out)');
        visibleCards.forEach(function(card) {
            var rect = card.getBoundingClientRect();
            var dist = Math.abs(rect.top + rect.height / 2 - vh / 2);
            var scale = Math.max(1.3 - dist / vh, 0.5);
            var opacity = Math.max(1.3 - dist / vh, 0.5);
            card.style.transform = 'scale(' + scale + ')';
            card.style.opacity = opacity;
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // ── Filter Logic ──
    function applyFilter() {
        cards.forEach(function(card) {
            var cardDept = card.getAttribute('data-dept');
            var cardArtist = card.getAttribute('data-artist');
            var show = true;

            if (state.dept !== 'ALL' && cardDept !== state.dept) {
                show = false;
            }
            if (state.artist && cardArtist !== state.artist) {
                show = false;
            }

            if (show) {
                card.classList.remove('filtered-out');
            } else {
                card.classList.add('filtered-out');
            }
        });

        dividers.forEach(function(div) {
            var divDept = div.getAttribute('data-dept');
            var divArtist = div.getAttribute('data-artist');
            var show = true;

            if (state.dept !== 'ALL' && divDept !== state.dept) {
                show = false;
            }
            if (state.artist && divArtist !== state.artist) {
                show = false;
            }

            if (show) {
                div.classList.remove('hidden');
            } else {
                div.classList.add('hidden');
            }
        });

        // Re-run scroll effect after filter transition settles
        setTimeout(function() {
            handleScroll();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 100);
    }

    // ── Tab Clicks ──
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var dept = this.getAttribute('data-dept');

            tabs.forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');

            state.dept = dept;
            state.artist = null;
            state.artistName = null;

            applyFilter();
            updateBreadcrumb();
        });
    });

    // ── Artist Divider Clicks ──
    dividers.forEach(function(div) {
        div.addEventListener('click', function() {
            var artist = this.getAttribute('data-artist');
            var artistName = this.querySelector('.artist-divider-name').textContent;
            var dept = this.getAttribute('data-dept');

            if (state.artist === artist) {
                state.artist = null;
                state.artistName = null;
            } else {
                state.artist = artist;
                state.artistName = artistName;

                if (state.dept === 'ALL') {
                    state.dept = dept;
                    tabs.forEach(function(t) { t.classList.remove('active'); });
                    tabs.forEach(function(t) {
                        if (t.getAttribute('data-dept') === dept) t.classList.add('active');
                    });
                }
            }

            applyFilter();
            updateBreadcrumb();
        });
    });

    // ── Breadcrumb ──
    function updateBreadcrumb() {
        var html = '';

        if (state.dept === 'ALL' && !state.artist) {
            html = '<span class="crumb active" data-level="all">All Work</span>';
        } else if (state.dept !== 'ALL' && !state.artist) {
            html = '<span class="crumb" data-level="all">All Work</span>';
            html += '<span class="crumb-sep">/</span>';
            html += '<span class="crumb active" data-level="dept">' + state.dept + '</span>';
        } else if (state.artist) {
            html = '<span class="crumb" data-level="all">All Work</span>';
            html += '<span class="crumb-sep">/</span>';
            html += '<span class="crumb" data-level="dept">' + state.dept + '</span>';
            html += '<span class="crumb-sep">/</span>';
            html += '<span class="crumb active" data-level="artist">' + state.artistName + '</span>';
        }

        breadcrumbTrail.innerHTML = html;
        bindBreadcrumbClicks();
    }

    function bindBreadcrumbClicks() {
        breadcrumbTrail.querySelectorAll('.crumb:not(.active)').forEach(function(crumb) {
            crumb.addEventListener('click', function() {
                var level = this.getAttribute('data-level');

                if (level === 'all') {
                    state.dept = 'ALL';
                    state.artist = null;
                    state.artistName = null;
                    tabs.forEach(function(t) { t.classList.remove('active'); });
                    tabs.forEach(function(t) {
                        if (t.getAttribute('data-dept') === 'ALL') t.classList.add('active');
                    });
                } else if (level === 'dept') {
                    state.artist = null;
                    state.artistName = null;
                }

                applyFilter();
                updateBreadcrumb();
            });
        });
    }

    // ── Video Modal ──
    $(document).on('click', '.video-card', function() {
        var $card = $(this);
        var simianUrl   = $card.attr('data-simian-url');
        var videoName   = $card.attr('data-video-name');
        var videoSub    = $card.attr('data-video-subname');
        var hasCredit   = $card.attr('data-has-credit');
        var credits     = $card.attr('data-credits');
        var prev1       = $card.attr('data-prev1');
        var prev2       = $card.attr('data-prev2');
        var prev3       = $card.attr('data-prev3');
        var prev4       = $card.attr('data-prev4');
        var prev5       = $card.attr('data-prev5');
        var prev6       = $card.attr('data-prev6');

        // Clear previous state
        $('#videoModal iframe').attr('src', '');
        $('#videoModal .modal-screenshots').html('');

        // Populate screenshots
        [prev1, prev2, prev3, prev4, prev5, prev6].forEach(function(src, i) {
            if (src) {
                $('#videoModal .modal-screenshots').append(
                    '<li class="preview' + (i + 1) + '"><img src="' + src + '"></li>'
                );
            }
        });

        var title = videoSub ? videoName + ' - ' + videoSub : videoName;

        if (hasCredit === 'yes' && credits) {
            $('#videoModal .modal-credit iframe').attr('src', simianUrl);
            $('#videoModal .modal-credit .modal-title-main').text(title);
            $('#videoModal .modal-credit .credit-right').html(credits);
            $('#videoModal .modal-simple').hide();
            $('#videoModal .modal-credit').show();
        } else {
            $('#videoModal .modal-simple iframe').attr('src', simianUrl);
            $('#videoModal .modal-simple .modal-title-main').text(videoName);
            $('#videoModal .modal-simple .modal-title-sub').text(videoSub);
            $('#videoModal .modal-credit').hide();
            $('#videoModal .modal-simple').show();
        }

        $('#videoModal').modal('show');
    });

    // Clear iframe on modal close
    $('#videoModal').on('hidden.bs.modal', function() {
        $('#videoModal iframe').attr('src', '');
    });

    // ── Mobile Video Fix ──
    document.querySelectorAll('.video-card video').forEach(function(v) {
        v.setAttribute('playsinline', '');
        v.setAttribute('webkit-playsinline', '');
        v.muted = true;
    });

    // ── URL Parameter Support ──
    var params = new URLSearchParams(window.location.search);
    var paramDept = params.get('dept');
    var paramArtist = params.get('artist');

    if (paramDept && paramDept !== 'ALL') {
        state.dept = paramDept.toUpperCase();
        tabs.forEach(function(t) { t.classList.remove('active'); });
        tabs.forEach(function(t) {
            if (t.getAttribute('data-dept') === state.dept) t.classList.add('active');
        });
    }

    if (paramArtist) {
        state.artist = paramArtist;
        dividers.forEach(function(div) {
            if (div.getAttribute('data-artist') === paramArtist) {
                state.artistName = div.querySelector('.artist-divider-name').textContent;
                if (state.dept === 'ALL') {
                    state.dept = div.getAttribute('data-dept');
                    tabs.forEach(function(t) { t.classList.remove('active'); });
                    tabs.forEach(function(t) {
                        if (t.getAttribute('data-dept') === state.dept) t.classList.add('active');
                    });
                }
            }
        });
    }

    if (paramDept || paramArtist) {
        applyFilter();
        updateBreadcrumb();
    }

})();
