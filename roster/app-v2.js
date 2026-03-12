// ──────────────────────────────────────────────────
// Roster V2 — Shared JS for all page types
// Detects page type via body class and runs appropriate logic
// ──────────────────────────────────────────────────

(function() {

    var isDepartmentPage = document.body.classList.contains('page-department');
    var isArtistPage     = document.body.classList.contains('page-artist');
    var isIndexPage      = !isDepartmentPage && !isArtistPage;

    // ── Rolling Scale/Opacity Effect (index page uses window scroll) ──
    function initScrollEffect() {
        var feed = document.getElementById('videoFeed');
        if (!feed) return;

        function handleScroll() {
            var vh = window.innerHeight;
            var selector = isIndexPage
                ? '.video-card:not(.filtered-out)'
                : '.video-card';
            var visibleCards = feed.querySelectorAll(selector);
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
    }


    // ── Index Page: Filter Logic ──
    function initIndexFilters() {
        var feed = document.getElementById('videoFeed');
        if (!feed) return;

        var state = { dept: 'ALL', artist: null, artistName: null };
        var cards = feed.querySelectorAll('.video-card');
        var dividers = feed.querySelectorAll('.artist-divider');
        var tabs = document.querySelectorAll('.dept-tab');
        var breadcrumbTrail = document.querySelector('.breadcrumb-trail');

        function applyFilter() {
            cards.forEach(function(card) {
                var cardDept = card.getAttribute('data-dept');
                var cardArtist = card.getAttribute('data-artist');
                var show = true;
                if (state.dept !== 'ALL' && cardDept !== state.dept) show = false;
                if (state.artist && cardArtist !== state.artist) show = false;
                card.classList.toggle('filtered-out', !show);
            });

            dividers.forEach(function(div) {
                var divDept = div.getAttribute('data-dept');
                var divArtist = div.getAttribute('data-artist');
                var show = true;
                if (state.dept !== 'ALL' && divDept !== state.dept) show = false;
                if (state.artist && divArtist !== state.artist) show = false;
                div.classList.toggle('hidden', !show);
            });

            setTimeout(function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        }

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');
                state.dept = this.getAttribute('data-dept');
                state.artist = null;
                state.artistName = null;
                applyFilter();
                updateBreadcrumb();
            });
        });

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

        function updateBreadcrumb() {
            if (!breadcrumbTrail) return;
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
            if (!breadcrumbTrail) return;
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

        // URL parameter support
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
    }

    // ── Video Modal (shared across all page types) ──
    function initModal() {
        var cardSelector = isDepartmentPage ? '.hcard' : '.video-card';

        $(document).on('click', cardSelector, function() {
            var $card = $(this);
            var simianUrl = $card.attr('data-simian-url') || '';
            var embedHtml = $card.attr('data-embed') || '';
            var videoName = $card.attr('data-video-name') || '';
            var videoSub  = $card.attr('data-video-subname') || '';
            var hasCredit = $card.attr('data-has-credit');
            var credits   = $card.attr('data-credits') || '';
            var aspect    = $card.attr('data-aspect') || 'landscape';

            var $modal = $('#videoModal');
            $modal.removeClass('modal-portrait');
            if (aspect === 'portrait') {
                $modal.addClass('modal-portrait');
            }

            $modal.find('.vmodal-player').html('');
            $modal.find('.vmodal-screenshots').html('');

            var displayTitle = videoSub ? videoName + ' \u2014 ' + videoSub : videoName;
            $modal.find('.vmodal-title').text(displayTitle);

            var $tags = $modal.find('.vmodal-tags').empty();
            var artistName = $card.attr('data-artist-name') || '';
            if (artistName) {
                $tags.append('<span class="vmodal-tag">' + artistName + '</span>');
            }

            if (embedHtml && embedHtml.indexOf('<') !== -1) {
                $modal.find('.vmodal-player').html(embedHtml);
            } else if (simianUrl) {
                $modal.find('.vmodal-player').html(
                    '<div style="width:100%;height:0;position:relative;padding-bottom:56.25%;"><iframe src="' + simianUrl + '" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" allow="autoplay" allowfullscreen></iframe></div>'
                );
            }

            if (hasCredit === 'yes' && credits) {
                $modal.find('.vmodal-credits-content').html(credits);
                $modal.find('.vmodal-credits-bar').show();
            } else {
                $modal.find('.vmodal-credits-bar').hide();
            }

            for (var i = 1; i <= 6; i++) {
                var src = $card.attr('data-prev' + i);
                if (src) {
                    $modal.find('.vmodal-screenshots').append('<li><img src="' + src + '" loading="lazy"></li>');
                }
            }

            $modal.modal('show');
        });

        $('#videoModal').on('hidden.bs.modal', function() {
            $('#videoModal .vmodal-player').html('');
        });
    }

    // ── Mobile Video Fix (all pages) ──
    function initMobileVideoFix() {
        document.querySelectorAll('video').forEach(function(v) {
            v.setAttribute('playsinline', '');
            v.setAttribute('webkit-playsinline', '');
            v.muted = true;
        });
    }

    // ── Horizontal Scroll with crossfade (department pages) ──
    function initHorizontalScroll() {
        var track = document.getElementById('scatterFeed');
        if (!track) return;

        var cards = track.querySelectorAll('.hcard');
        var sections = track.querySelectorAll('.dept-section');
        
        var heroTitles = document.querySelectorAll('.dept-hero-title[data-dept]');
        var heroArtists = document.querySelectorAll('.dept-hero-artists[data-dept]');

        var targetX = 0;
        var currentX = 0;
        var maxScroll = track.scrollWidth - window.innerWidth;
        var vw = window.innerWidth;
        var center = vw / 2;
        var ease = 0.08;
        var running = false;

        // Scroll to starting department if specified
        var startDept = document.body.getAttribute('data-start-dept');
        if (startDept && startDept !== 'EDIT') {
            for (var si = 0; si < sections.length; si++) {
                if (sections[si].getAttribute('data-dept') === startDept) {
                    targetX = sections[si].offsetLeft - vw * 0.1;
                    currentX = targetX;
                    break;
                }
            }
        }

        function clamp(val, min, max) {
            return Math.max(min, Math.min(max, val));
        }

        function updateHero() {
            var bestDept = 'EDIT';
            var bestDist = Infinity;

            // Find which section the viewport center is inside (or closest to)
            sections.forEach(function(sec) {
                var rect = sec.getBoundingClientRect();
                var dept = sec.getAttribute('data-dept');
                // Distance from viewport center to nearest edge of section
                var dist;
                if (center >= rect.left && center <= rect.right) {
                    dist = 0; // viewport center is inside this section
                } else {
                    dist = Math.min(Math.abs(rect.left - center), Math.abs(rect.right - center));
                }
                if (dist < bestDist) {
                    bestDist = dist;
                    bestDept = dept;
                }
            });

            heroTitles.forEach(function(el) {
                var dept = el.getAttribute('data-dept');
                if (dept === bestDept) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
                el.style.cursor = 'pointer';
            });

            heroArtists.forEach(function(el) {
                var dept = el.getAttribute('data-dept');
                el.style.opacity = (dept === bestDept) ? '1' : '0';
                el.style.pointerEvents = (dept === bestDept) ? 'auto' : 'none';
            });
        }

        // Click on dept title to jump to that section
        heroTitles.forEach(function(el) {
            el.addEventListener('click', function() {
                var dept = el.getAttribute('data-dept');
                for (var si = 0; si < sections.length; si++) {
                    if (sections[si].getAttribute('data-dept') === dept) {
                        targetX = clamp(sections[si].offsetLeft - vw * 0.05, 0, maxScroll);
                        startAnimation();
                        break;
                    }
                }
            });
        });

        function animate() {
            currentX += (targetX - currentX) * ease;
            if (Math.abs(targetX - currentX) < 0.5) currentX = targetX;

            track.style.transform = 'translateX(' + (-currentX) + 'px)';

            var trackRect = track.getBoundingClientRect();
            var trackMidY = trackRect.top + trackRect.height / 2;
            var lazyThreshold = vw * 1.5;
            cards.forEach(function(card) {
                var rect = card.getBoundingClientRect();
                var cardCenter = rect.left + rect.width / 2;
                var dist = Math.abs(cardCenter - center);

                // Lazy load: set src when within 1.5x viewport of center
                if (dist < lazyThreshold) {
                    var vid = card.querySelector('video[data-src]');
                    if (vid && !vid.getAttribute('src')) {
                        vid.setAttribute('src', vid.getAttribute('data-src'));
                        vid.play();
                    }
                }

                var maxDist = vw * 0.45;
                var ratio = clamp(dist / maxDist, 0, 1);
                var scale = 1.15 - ratio * 0.6;
                var cardMidY = rect.top + rect.height / 2;
                var pullY = (trackMidY - cardMidY) * (1 - ratio) * 0.35;
                card.style.transform = 'scale(' + Math.max(scale, 0.55) + ') translateY(' + pullY + 'px)';
            });

            updateHero();

            if (Math.abs(targetX - currentX) > 0.5) {
                requestAnimationFrame(animate);
            } else {
                running = false;
            }
        }

        function startAnimation() {
            if (!running) {
                running = true;
                requestAnimationFrame(animate);
            }
        }

        window.addEventListener('wheel', function(e) {
            e.preventDefault();
            var delta = e.deltaY || e.deltaX;
            targetX = clamp(targetX + delta * 1.2, 0, maxScroll);
            startAnimation();
        }, { passive: false });

        window.addEventListener('resize', function() {
            maxScroll = track.scrollWidth - window.innerWidth;
            vw = window.innerWidth;
            center = vw / 2;
            targetX = clamp(targetX, 0, maxScroll);
            startAnimation();
        });

        currentX = targetX;
        animate();
    }

    // ── Page Transition (initial load fade-in) ──
    function initPageTransition() {
        var overlay = document.getElementById('pageTransition');
        if (!overlay) return;

        window.addEventListener('load', function() {
            overlay.classList.add('fade-out');

            var animElements = document.querySelectorAll('.anim-fade-in, .anim-fade-up');
            animElements.forEach(function(el) {
                el.classList.add('visible');
            });
        });
    }

    // ── Initialize based on page type ──
    if (isIndexPage) {
        initScrollEffect();
        initIndexFilters();
    } else if (isArtistPage) {
        initScrollEffect();
    }

    if (isDepartmentPage) {
        initPageTransition();
        initHorizontalScroll();
    }

    initModal();
    initMobileVideoFix();

})();
