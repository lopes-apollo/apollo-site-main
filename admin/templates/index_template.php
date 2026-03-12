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
    <link rel="stylesheet" type="text/css" href="home-new/style-new.css?v=10.1.2">
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
            <?php foreach ($visible_projects as $project): ?>
            <li>
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
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="videoSupport">
            <div class="popupVideo" style="display:none;">
                <iframe src="" frameborder="0" allow="autoplay" allowfullscreen=""></iframe>
                <h3></h3>
                <h4></h4>
                <h5></h5>
            </div>
            <div class="creditPopupVideo" style="display:none;">
                <div class="creditDetail">
                    <div class="leftSide">
                        <h3></h3>
                        <iframe src="" frameborder="0" allow="autoplay" allowfullscreen=""></iframe>
                    </div>
                    <div class="rightSide"></div>
                </div>
            </div> 
        </div>
        <ul class="screenshots">
            <li class="preview1">
                <img src="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h16m58s466.jpg">
            </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).on('click','a.openModelItem',function(){
    var author = $(this).attr('data-author');
    var prev1 = $(this).attr('data-prev1');
    var prev2 = $(this).attr('data-prev2');
    var prev3 = $(this).attr('data-prev3');
    var prev4 = $(this).attr('data-prev4');
    var prev5 = $(this).attr('data-prev5');
    var prev6 = $(this).attr('data-prev6');
    var longVideo = $(this).attr('data-long');
    var title = $(this).attr('data-title');
    var subtitle = $(this).attr('data-subtitle');
    var credit = $(this).attr('data-credit');
    var credits = $(this).attr('data-credits');
    $('div#videoModalPopup ul.screenshots').html('');
    if(prev1!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview1"> <img src="'+prev1+'"> </li>');
    }
    if(prev2!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview2"> <img src="'+prev2+'"> </li>');
    }
    if(prev3!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview3"> <img src="'+prev3+'"> </li>');
    }
    if(prev4!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview4"> <img src="'+prev4+'"> </li>');
    }
    if(prev5!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview5"> <img src="'+prev5+'"> </li>');
    }
    if(prev6!=''){
        $('div#videoModalPopup ul.screenshots').append('<li class="preview6"> <img src="'+prev6+'"> </li>');
    }
    $('#videoModalPopup iframe').attr('src','');
    if(credit=='yes'){
        $('#videoModalPopup div.creditPopupVideo iframe').attr('src',longVideo);
        $('#videoModalPopup div.creditPopupVideo h3').text(title+' - '+subtitle);
        $('#videoModalPopup div.creditPopupVideo div.rightSide').html(credits);
        $('#videoModalPopup div.popupVideo').hide();
        $('#videoModalPopup div.creditPopupVideo').show();
    }else{
        $('#videoModalPopup div.popupVideo iframe').attr('src',longVideo);
        $('#videoModalPopup div.popupVideo h3').text(title);
        $('#videoModalPopup div.popupVideo h4').text(subtitle);
        $('#videoModalPopup div.popupVideo h5').text(author);
        $('#videoModalPopup div.creditPopupVideo').hide();
        $('#videoModalPopup div.popupVideo').show();
    }
    $('div#videoModalPopup').modal('show');
});

$('div#videoModalPopup').on('hidden.bs.modal', function () {
    $('#videoModalPopup iframe').attr('src', '');
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
