<?php
// Landing page template - generates index.php
$visible_projects = array_filter($landing_projects, function($p) { return $p['visible'] ?? true; });
usort($visible_projects, function($a, $b) { return ($a['order'] ?? 999) <=> ($b['order'] ?? 999); });
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($settings['site_title'] ?? 'APOLLO'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
    <link rel="stylesheet" type="text/css" href="home-new/style-new.css?v=10.2.0">
    <style>
    .videoPlayOverlay {
        height: 100vh !important;
    }
    
    /* Video loader styles */
    #videoLoaderDiv {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        height: 100vh;
        background: #000;
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
    }
    
    #videoLoaderDiv video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 99999999;
    }
    
    /* Fallback animation - only applied when needed */
    #videoLoaderDiv.fallback-hide {
        animation: fadeOutLoader 0.5s forwards;
        z-index: 999999;
    }
    
    /* Keyframe animation to hide loader */
    @keyframes fadeOutLoader {
        0% {
            opacity: 1;
            visibility: visible;
            z-index: 999999;
        }
        100% {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            z-index: 999999;
        }
    }
    
    /* Mobile-specific CSS fallback - hide loader after delay ONLY if JS fails */
    @media (max-width: 768px) {
        #videoLoaderDiv.css-fallback {
            animation: mobileFallbackHide 3s forwards;
        }
        
        @keyframes mobileFallbackHide {
            0%, 85% {
                opacity: 1;
                visibility: visible;
            }
            100% {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
        }
    }
    </style> 
</head>
<body>
<div id="videoLoaderDiv">
    <video muted="true" playsinline="true" webkit-playsinline="true" autoplay="true" id="videoLoader">
        <!-- Sources will be set via JavaScript -->
    </video>
</div>
<header>
    <div class="logo" style="display:none;">
        <a href="/"><img src="fonts/logo.png" /></a>
    </div>
    <div class="menu" style="display:none;">
        <ul>
            <li>
                <a href="/roster/department.php">ROSTER</a>
            </li>
            <li>
                <a href="contact/">CONTACT</a>
            </li>
        </ul>
    </div>
</header>    
<?php
$first = true;
foreach ($visible_projects as $project):
    $opacity = $first ? 1 : 0;
    $visibility = $first ? 'visible' : 'hidden';
    $first = false;
    
    // Format video long URL - check if it's already an iframe or just a URL
    $video_long = $project['video_long'];
    if (strpos($video_long, '<iframe') === false && strpos($video_long, 'http') === 0) {
        // It's a URL, wrap it in iframe
        $video_long = '<div style="width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;"><iframe src="' . htmlspecialchars($video_long) . '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
    }
?>
<div class="backgroundImage <?php echo htmlspecialchars($project['image_class']); ?>" style="opacity:<?php echo $opacity; ?>;visibility:<?php echo $visibility; ?>;">
    <a class="openModelItem" 
       data-image='<?php echo htmlspecialchars($project['image_class']); ?>' 
       data-prev1="<?php echo htmlspecialchars($project['preview_images'][0] ?? ''); ?>" 
       data-prev2="<?php echo htmlspecialchars($project['preview_images'][1] ?? ''); ?>" 
       data-prev3="<?php echo htmlspecialchars($project['preview_images'][2] ?? ''); ?>" 
       data-prev4="<?php echo htmlspecialchars($project['preview_images'][3] ?? ''); ?>" 
       data-prev5="<?php echo htmlspecialchars($project['preview_images'][4] ?? ''); ?>" 
       data-prev6="<?php echo htmlspecialchars($project['preview_images'][5] ?? ''); ?>" 
       data-long="<?php echo htmlspecialchars($video_long); ?>" 
       data-author="<?php echo htmlspecialchars($project['author']); ?>" 
       data-title="<?php echo htmlspecialchars($project['title']); ?>" 
       data-subtitle="<?php echo htmlspecialchars($project['subtitle']); ?>" 
       data-credit="<?php echo ($project['has_credits'] ?? false) ? 'yes' : 'no'; ?>" 
       data-credits="<?php echo htmlspecialchars($project['credits'] ?? ''); ?>">
        <video src="<?php echo htmlspecialchars($project['video_short']); ?>" muted autoplay loop playsinline></video>
        <h3 style="display:none;"><?php echo htmlspecialchars($project['title']); ?></h3>
        <p style="display:none;"><?php echo htmlspecialchars($project['subtitle']); ?></p>
    </a> 
</div>
<?php endforeach; ?>

<div class="innerBody">
    <ul class="heading" style="display:none;">
        <li>
            <a href="roster/edit" data-author="EDIT">Edit</a>
        </li>
        <li>
            <a href="roster/color" data-author="COLOR">Color</a>
        </li>
        <li>
            <a href="roster/sound" data-author="SOUND">Sound</a>
        </li>
        <li>
            <a href="roster/vfx" data-author="VFX">VFX</a>
        </li>
    </ul>
    <div class="allLists detailedBox" style="display:none;">
        <ul>
            <?php foreach ($visible_projects as $project):
                $list_vl = $project['video_long'];
                if (strpos($list_vl, '<iframe') === false && strpos($list_vl, 'http') === 0) {
                    $list_vl = '<div style="width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;"><iframe src="' . htmlspecialchars($list_vl) . '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
                }
            ?>
            <li>
                <a class="openModelItem" 
                   data-image='<?php echo htmlspecialchars($project['image_class']); ?>' 
                   data-prev1="<?php echo htmlspecialchars($project['preview_images'][0] ?? ''); ?>" 
                   data-prev2="<?php echo htmlspecialchars($project['preview_images'][1] ?? ''); ?>" 
                   data-prev3="<?php echo htmlspecialchars($project['preview_images'][2] ?? ''); ?>" 
                   data-prev4="<?php echo htmlspecialchars($project['preview_images'][3] ?? ''); ?>" 
                   data-prev5="<?php echo htmlspecialchars($project['preview_images'][4] ?? ''); ?>" 
                   data-prev6="<?php echo htmlspecialchars($project['preview_images'][5] ?? ''); ?>" 
                   data-long="<?php echo htmlspecialchars($list_vl); ?>" 
                   data-author="<?php echo htmlspecialchars($project['author']); ?>" 
                   data-title="<?php echo htmlspecialchars($project['title']); ?>" 
                   data-subtitle="<?php echo htmlspecialchars($project['subtitle']); ?>" 
                   data-credit="<?php echo ($project['has_credits'] ?? false) ? 'yes' : 'no'; ?>" 
                   data-credits="<?php echo htmlspecialchars($project['credits'] ?? ''); ?>">
                    <?php echo htmlspecialchars($project['title']); ?><?php if ($project['subtitle']): ?> - <?php echo htmlspecialchars($project['subtitle']); ?><?php endif; ?>
                </a> 
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="modal fade" id="videoModalPopup" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="vmodal-close" data-bs-dismiss="modal" aria-label="Close">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1 1L19 19M19 1L1 19" stroke="#fff" stroke-width="1.5"/></svg>
      </button>
      <div class="modal-body">
        <div class="vmodal-info">
          <h2 class="vmodal-title"></h2>
          <p class="vmodal-subtitle"></p>
          <div class="vmodal-tags"></div>
        </div>
        <div class="vmodal-player"></div>
        <div class="vmodal-credits-bar" style="display:none;">
          <div class="vmodal-credits-content"></div>
        </div>
        <ul class="vmodal-screenshots"></ul>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).on('click','a.openModelItem',function(){
    var author = $(this).attr('data-author') || '';
    var prevs = [];
    for (var i = 1; i <= 6; i++) {
        var p = $(this).attr('data-prev' + i);
        if (p) prevs.push(p);
    }
    var longVideo = $(this).attr('data-long') || '';
    var title = $(this).attr('data-title') || '';
    var subtitle = $(this).attr('data-subtitle') || '';
    var credit = $(this).attr('data-credit');
    var credits = $(this).attr('data-credits') || '';

    var $modal = $('#videoModalPopup');
    $modal.find('.vmodal-player').html('');
    $modal.find('.vmodal-screenshots').html('');

    var displayTitle = subtitle ? title + ' \u2014 ' + subtitle : title;
    $modal.find('.vmodal-title').text(displayTitle);

    var $tags = $modal.find('.vmodal-tags').empty();
    if (author) {
        author.split(',').forEach(function(tag) {
            tag = tag.trim();
            if (tag) $tags.append('<span class="vmodal-tag">' + tag + '</span>');
        });
    }

    if (longVideo && longVideo.indexOf('<') !== -1) {
        $modal.find('.vmodal-player').html(longVideo);
    } else if (longVideo && longVideo.indexOf('http') === 0) {
        $modal.find('.vmodal-player').html(
            '<div style="width:100%;height:0;position:relative;padding-bottom:56.25%;"><iframe src="' + longVideo + '" style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;" allow="autoplay" allowfullscreen></iframe></div>'
        );
    }

    if (credit === 'yes' && credits) {
        $modal.find('.vmodal-credits-content').html(credits);
        $modal.find('.vmodal-credits-bar').show();
    } else {
        $modal.find('.vmodal-credits-bar').hide();
    }

    prevs.forEach(function(src) {
        $modal.find('.vmodal-screenshots').append('<li><img src="' + src + '" loading="lazy"></li>');
    });

    $modal.modal('show');
});

$('#videoModalPopup').on('hidden.bs.modal', function () {
    $('#videoModalPopup .vmodal-player').html('');
});

$(document).ready(function(){
    $('header .logo').fadeIn();
    $('header .menu').fadeIn();
    $('div.innerBody ul.heading').fadeIn(); 
    $('div.innerBody .allLists').fadeIn();
});
$(document).on('mouseenter','div.innerBody div.detailedBox li a',function(){
    var previewImage = $(this).attr('data-image');
    var previewAuthor = $(this).attr('data-author');
    previewAuthor=previewAuthor.split(',');
    $('div.backgroundImage').attr('style','opacity:0;visibility:hidden;');
    $('div.backgroundImage.'+previewImage).attr('style','opacity:1;visibility:visible;');
    $('div.innerBody ul.heading a').removeClass('active');
    if(jQuery.inArray("EDIT", previewAuthor) !== -1){
        $('div.innerBody ul.heading a[data-author="EDIT"]').addClass('active');
    }
    if(jQuery.inArray("COLOR", previewAuthor) !== -1){
        $('div.innerBody ul.heading a[data-author="COLOR"]').addClass('active');
    }
    if(jQuery.inArray("SOUND", previewAuthor) !== -1){
        $('div.innerBody ul.heading a[data-author="SOUND"]').addClass('active');
    }
    if(jQuery.inArray("VFX", previewAuthor) !== -1){
        $('div.innerBody ul.heading a[data-author="VFX"]').addClass('active');
    }
});
// loader start
document.addEventListener("DOMContentLoaded", function(event){
$(document).ready(function() {
    var video = document.getElementById('videoLoader');
    var loaderHidden = false;
    var globalFallbackTimer = null;
    var videoIsPlaying = false;
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    
    video.muted = true;
    video.defaultMuted = true;
    video.volume = 0;
    video.setAttribute('muted', 'true');
    video.setAttribute('playsinline', 'true');
    video.setAttribute('webkit-playsinline', 'true');
    video.setAttribute('autoplay', 'true');
    
    if (isMobile) {
        video.src = '<?php echo htmlspecialchars($settings['preloader_video_mobile'] ?? 'home-new/mobilehomepreloadervideo.mp4'); ?>';
    } else {
        video.src = '<?php echo htmlspecialchars($settings['preloader_video_desktop'] ?? 'home-new/homepreloadervideo.mp4'); ?>';
    }
    
    video.load();
    
    function hideLoaderAndInit() {
        if (loaderHidden) return;
        loaderHidden = true;
        if (globalFallbackTimer) {
            clearTimeout(globalFallbackTimer);
            globalFallbackTimer = null;
        }
        $('#videoLoaderDiv').addClass('fallback-hide');
        setTimeout(function() {
            $('#videoLoaderDiv').hide();
            $('header .logo').fadeIn();
            $('header .menu').fadeIn();
            $('div.innerBody ul.heading').fadeIn(); 
            $('div.innerBody .allLists').fadeIn();
        }, 500);
    }
    
    $(video).on('ended', function() {
        videoIsPlaying = false;
        video.pause();
        hideLoaderAndInit();
    });
    
    $(video).on('playing', function() {
        videoIsPlaying = true;
        if (globalFallbackTimer) {
            clearTimeout(globalFallbackTimer);
            globalFallbackTimer = null;
        }
    });
    
    $(video).on('error', function(e) {
        videoIsPlaying = false;
        if (globalFallbackTimer) clearTimeout(globalFallbackTimer);
        hideLoaderAndInit();
    });
    
    function tryPlay() {
        try {
            var playPromise = video.play();
            if (playPromise && typeof playPromise.then === 'function') {
                playPromise.then(function() {
                    videoIsPlaying = true;
                    if (globalFallbackTimer) {
                        clearTimeout(globalFallbackTimer);
                        globalFallbackTimer = null;
                    }
                }).catch(function(error) {
                    videoIsPlaying = false;
                    setTimeout(function() {
                        if (!loaderHidden) {
                            hideLoaderAndInit();
                        }
                    }, isMobile ? 1500 : 1000);
                });
            }
        } catch (e) {
            setTimeout(function() {
                if (!loaderHidden) {
                    hideLoaderAndInit();
                }
            }, 1000);
        }
    }
    
    var playAttempted = false;
    if (video.readyState >= 3) {
        tryPlay();
        playAttempted = true;
    }
    
    video.addEventListener('canplay', function() {
        if (!playAttempted) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    video.addEventListener('canplaythrough', function() {
        if (!playAttempted) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    video.addEventListener('loadeddata', function() {
        if (!playAttempted && video.readyState >= 2) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    setTimeout(function() {
        if (!playAttempted && !loaderHidden) {
            tryPlay();
            playAttempted = true;
        }
    }, 500);
    
    globalFallbackTimer = setTimeout(function() {
        if (!loaderHidden) {
            hideLoaderAndInit();
        }
    }, 8000);
});
});
// loader end
$(document).ready(function() {
    var $heading = $("div.innerBody ul.heading");
    var elementOffset = $heading.offset().top;
    var placeholder = $("<div></div>").hide().height($heading.outerHeight());
    $heading.before(placeholder);
    $(window).scroll(function() {
        if ($(window).scrollTop() >= elementOffset) {
            placeholder.show();
            $heading.addClass("fixed");
        } else {
            placeholder.hide();
            $heading.removeClass("fixed");
        }
    });
    window.scrollTo(0, 0);
});
</script>
</body>
</html>
