<?php
// Individual artist page template
// $current_artist is set by sync.php, $artists is available globally
$artist_slug = strtolower(str_replace(' ', '-', $current_artist['name']));
$artist_category = strtoupper($current_artist['category'] ?? 'EDIT');

$category_artists = array_values(array_filter($artists, function($a) use ($current_artist) {
    return ($a['category'] ?? '') === ($current_artist['category'] ?? '') && ($a['visible'] ?? true);
}));
usort($category_artists, function($a, $b) {
    return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
});

$current_index = 0;
foreach ($category_artists as $idx => $a) {
    if ($a['id'] === $current_artist['id']) {
        $current_index = $idx;
        break;
    }
}

$category_index_map = ['EDIT' => 0, 'COLOR' => 1, 'SOUND' => 2, 'VFX' => 3];
$left_active_index = $category_index_map[$artist_category] ?? 0;

$left_padding_map = [
    0 => ['top' => '13rem', 'bottom' => '0'],
    1 => ['top' => '7.3rem', 'bottom' => '0'],
    2 => ['top' => '1.6rem', 'bottom' => '0'],
    3 => ['top' => '0', 'bottom' => '4.1rem'],
];
$left_pad = $left_padding_map[$left_active_index];

$right_padding_map = [
    0 => ['top' => '13rem', 'bottom' => '0'],
    1 => ['top' => '7.3rem', 'bottom' => '0'],
    2 => ['top' => '1.6rem', 'bottom' => '0'],
];
$right_pad = $right_padding_map[$current_index] ?? ['top' => '13rem', 'bottom' => '0'];

if (!function_exists('formatVideoLong')) {
    function formatVideoLong($video_long) {
        if (strpos($video_long, '<iframe') === false && strpos($video_long, 'http') === 0) {
            return '<div style="width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;"><iframe src="' . htmlspecialchars($video_long) . '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0;        left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
        }
        return $video_long;
    }
}

$videos = $current_artist['videos'] ?? [];
usort($videos, function($a, $b) {
    return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
});

// Build video HTML once, reuse for container and infinite scroll
ob_start();
$first_video = true;
foreach ($videos as $video):
    $video_long = formatVideoLong($video['videoLong'] ?? '');
    $video_class = $first_video ? ($artist_category . ' ' . $artist_slug) : '';
    $first_video = false;
    $video_name = $video['videoName'] ?? '';
    $video_sub = $video['videoSubName'] ?? '';
    $label = htmlspecialchars($video_name);
    if ($video_sub) $label .= ' - ' . htmlspecialchars($video_sub);
    $credit = ($video['hasCredit'] ?? false) ? 'yes' : 'no';
    // Single-quote data-longVideo with raw HTML, only escape single quotes
    $safe_long = str_replace("'", "&#39;", $video_long);
    // Double-quote data-credits with raw HTML, only escape double quotes  
    $safe_credits = str_replace('"', '&quot;', $video['credits'] ?? '');
?>
  <div class="video <?php echo $video_class; ?>" data-longVideo='<?php echo $safe_long; ?>' data-title="<?php echo htmlspecialchars($current_artist['name']); ?>" data-author="<?php echo $artist_category; ?>" data-prev1="<?php echo htmlspecialchars($video['previewImages'][0] ?? ''); ?>" data-prev2="<?php echo htmlspecialchars($video['previewImages'][1] ?? ''); ?>" data-prev3="<?php echo htmlspecialchars($video['previewImages'][2] ?? ''); ?>" data-prev4="<?php echo htmlspecialchars($video['previewImages'][3] ?? ''); ?>" data-prev5="<?php echo htmlspecialchars($video['previewImages'][4] ?? ''); ?>" data-prev6="<?php echo htmlspecialchars($video['previewImages'][5] ?? ''); ?>" data-videoName="<?php echo htmlspecialchars($video_name); ?>" data-videoSubName="<?php echo htmlspecialchars($video_sub); ?>" data-credit="<?php echo $credit; ?>" data-credits="<?php echo $safe_credits; ?>"><video poster="<?php echo htmlspecialchars($video['poster'] ?? ''); ?>" src="<?php echo htmlspecialchars($video['videoShort'] ?? ''); ?>" muted autoplay loop></video><label><?php echo $label; ?></label></div>
    
<?php endforeach;
$video_block = ob_get_clean();

// data-start for right sidebar uses incremental values starting at 44 for consistency
$right_start_base = 44;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>roster | APOLLO</title>
  <link rel="stylesheet" href="/roster/style.css?v=10.2.8"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    
    div.editorsMain {
        top: 100px;
    }
    div.editorsRightMain {
        top: 30px;
    }
  </style>
</head>
<body>
  <!-- Preloader -->
  <div class="video-preloader" id="videoPreloader">
    <div class="preloader-content">
      <div class="preloader-spinner"></div>
    </div>
  </div>
  <header>
      <div class="insideHeader">
    	<div class="menu"> 
    		<a href="/"><img src="../fonts/logo.png" /></a>
    	</div>
    	<div class="menuRight">
    	<h4 class="authorsNames" style="display:none;"></h4>
	    <ul>
	        <li>
	            <a href="/roster/">ROSTER</a>
	        </li>
	        <li>
	            <a href="/contact/">CONTACT</a>
	       </li>
	    </ul>
	</div> 
      </div> 
    </header>
  <div class="video-container">  
  <?php echo $video_block; ?>
  </div> 
  
  <div class="editorsMain editorsLeftMain" >
        <ul class="editorsLeft editors">
            <li <?php if ($left_active_index === 0): ?>class="active"<?php endif; ?> data-start=0><a href="/roster/edit">EDIT</a></li>
            <li <?php if ($left_active_index === 1): ?>class="active"<?php endif; ?> data-start=1><a href="/roster/color">COLOR</a></li>
            <li <?php if ($left_active_index === 2): ?>class="active"<?php endif; ?> data-start=2><a href="/roster/sound">SOUND</a></li>
            <li <?php if ($left_active_index === 3): ?>class="active"<?php endif; ?> data-start=3><a href="/roster/vfx">VFX</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
        </ul>
    </div>
    
    <div class="editorsMain editorsRightMain">
        <ul class="editorsRight editors EditorGroupUL">
            <?php foreach ($category_artists as $idx => $artist): ?>
            <li <?php if ($idx === $current_index): ?>class="active"<?php endif; ?> data-start=<?php echo $right_start_base + $idx; ?>><a href="/roster/<?php echo htmlspecialchars($artist['slug']); ?>"><?php echo htmlspecialchars($artist['name']); ?></a></li>
            <?php endforeach; ?>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li>
            <li><a style="color:transparent;">Inner</a></li> 
        </ul>
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
                    <div class="video-placeholder"></div>
                    <h3></h3>
                    <h4></h4>
                    <h5></h5>
                </div>
                <div class="creditPopupVideo" style="display:none;">
                    <div class="creditDetail">
                        <div class="leftSide">
                            <h3></h3>
                            <div class="video-placeholder"></div>
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script>
         $(document).on('click','div.video-container div.video',function(){
            var author = $(this).attr('data-author');
            var prev1 = $(this).attr('data-prev1');
            var prev2 = $(this).attr('data-prev2');
            var prev3 = $(this).attr('data-prev3');
            var prev4 = $(this).attr('data-prev4');
            var prev5 = $(this).attr('data-prev5');
            var prev6 = $(this).attr('data-prev6');
            var longVideo = $(this).attr('data-longVideo');
            var title = $(this).attr('data-videoName');
            var subtitle = $(this).attr('data-videoSubName');
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
            $('#videoModalPopup .video-placeholder').html('');
            if(credit=='yes'){
                $('#videoModalPopup div.creditPopupVideo .video-placeholder').html(longVideo);
                if (subtitle!=''){
                    $('#videoModalPopup div.creditPopupVideo h3').text(title+' - '+subtitle);
                }else{
                    $('#videoModalPopup div.creditPopupVideo h3').text(title);
                }
                $('#videoModalPopup div.creditPopupVideo div.rightSide').html(credits);
                $('#videoModalPopup div.popupVideo').hide();
                $('#videoModalPopup div.creditPopupVideo').show();
            }else{
                $('#videoModalPopup div.popupVideo .video-placeholder').html(longVideo);
                $('#videoModalPopup div.popupVideo h3').text(title);
                $('#videoModalPopup div.popupVideo h4').text(subtitle);
                $('#videoModalPopup div.popupVideo h5').text(author);
                $('#videoModalPopup div.creditPopupVideo').hide();
                $('#videoModalPopup div.popupVideo').show();
            }
            $('div#videoModalPopup').modal('show');
        });

        $('div#videoModalPopup').on('hidden.bs.modal', function () {
            $('#videoModalPopup .video-placeholder').html('');
        });
        
        function showPreloader() {
            $('#videoPreloader').css('display', 'flex').removeClass('fade-out').addClass('fade-in');
        }
        
        function hidePreloader() {
            $('#videoPreloader').removeClass('fade-in').addClass('fade-out');
            setTimeout(function() {
                $('#videoPreloader').css('display', 'none');
            }, 300);
        }

        setTimeout(() => {
            $('div.editorsMain ul.editorsRight li').removeClass('active');
            $('div.editorsMain ul.editorsRight li[data-start="<?php echo $right_start_base + $current_index; ?>"]').addClass('active');
            var $scrollArea = $('ul.editorsRight.editors.EditorGroupUL');
            var $targetItem = $scrollArea.find('li.active');
            if ($targetItem.length) {
                var scrollTo = $targetItem.position().top + $scrollArea.scrollTop() - ($scrollArea.height() - $targetItem.height()) / 2;
                $scrollArea.scrollTop(scrollTo);
            }

            var $scrollAreaLeft = $('ul.editorsLeft.editors');
            var $targetItemLeft = $scrollAreaLeft.find('li.active');
            if ($targetItemLeft.length) {
                var scrollToLeft = $targetItemLeft.position().top + $scrollAreaLeft.scrollTop() - ($scrollAreaLeft.height() - $targetItemLeft.height()) / 2;
                $scrollAreaLeft.scrollTop(scrollToLeft);
            }
            
            $('div.editorsRightMain').css('padding-bottom', '<?php echo $right_pad['bottom']; ?>').css('padding-top', '<?php echo $right_pad['top']; ?>');
            $('div.editorsLeftMain').css('padding-top', '<?php echo $left_pad['top']; ?>');
            $('div.insideHeader div.menuRight h4.authorsNames').text('<?php echo htmlspecialchars($current_artist['name'], ENT_QUOTES); ?>');
            $("html, body").animate({
                scrollTop: $(".video-container div.video.<?php echo $artist_slug; ?>").offset().top-330 
            }, 1500, function() {
                hidePreloader();
            });
        }, 100);
        window.addEventListener("scroll", handleScroll);
        function handleScroll() {
            const viewportHeight = window.innerHeight;
            const videos = document.querySelectorAll("div.video");
            videos.forEach(video => {
                const rect = video.getBoundingClientRect();
                const distanceFromCenter = Math.abs(rect.top + rect.height / 2 - viewportHeight / 2);
                const scale = Math.max(1.3 - distanceFromCenter / viewportHeight, 0.5);
                const opacity = Math.max(1.3 - distanceFromCenter / viewportHeight, 0.5);
                video.style.transform = `scale(${scale})`;
                video.style.opacity = opacity;
                
            });
        }
    // });
    document.addEventListener("DOMContentLoaded", function(event){
        var videoContainer = document.querySelector('.video-container');
        var videoHTML = `
       <?php echo $video_block; ?>
                `;
        videoContainer.insertAdjacentHTML("afterbegin", videoHTML);
        window.addEventListener('scroll', () => {
            var scrollable = document.documentElement.scrollHeight - window.innerHeight;
            var scrolled = window.scrollY;
            if (Math.ceil(scrolled) >= scrollable) {
                videoContainer.insertAdjacentHTML('beforeend', videoHTML);
            }
            if (scrolled === 0) {
                const oldHeight = videoContainer.offsetHeight;
                videoContainer.insertAdjacentHTML("afterbegin", videoHTML);
                window.scrollTo(0, videoContainer.offsetHeight);
                const newHeight = videoContainer.offsetHeight;
                window.scrollTo({ top: newHeight - oldHeight, behavior: 'instant' });
            }
        });
    });

    $(document).ready(function () {
        var maxWidth = 0;
        $('ul.editorsRight.editors li[data-start]').each(function() {
            if ($(this).width() > maxWidth) {
                maxWidth = $(this).width();
            }
        });
        $('ul.editorsRight.editors li[data-start]').width(maxWidth + 10);
        $('ul.editorsLeft.editors li[data-start]').each(function() {
            if ($(this).width() > maxWidth) {
                maxWidth = $(this).width();
            }
        });
        $('ul.editorsLeft.editors li[data-start]').width(maxWidth / 2);

        function setupScrollableList(selector) {
            var $scrollArea = $(selector);
            if ($scrollArea.length === 0) return;

            var $items = $scrollArea.children('li[data-start]');
            var currentIndex = $items.index($scrollArea.find('li.active'));
            if (currentIndex === -1) currentIndex = 0;
            var isScrolling = false;
        
            $scrollArea.on('wheel', function (e) {
                if ($scrollArea.get(0).scrollHeight <= $scrollArea.get(0).clientHeight) {
                    e.preventDefault();
                    return;
                }

                e.preventDefault();
                
                if (isScrolling) return;
                isScrolling = true;
    
                if (e.originalEvent.deltaY > 0) {
                    if (currentIndex < $items.length - 1) {
                        currentIndex++;
                    }
                } else {
                    if (currentIndex > 0) {
                        currentIndex--;
                    }
                }
    
                var $targetItem = $items.eq(currentIndex);

                if (selector === 'ul.editorsLeft.editors') {
                        $items.removeClass('active').removeClass('scrollActive');
                        $targetItem.addClass('active').addClass('scrollActive');

                        $('div.editorsLeftMain').removeClass('padding-0 padding-1 padding-2 padding-3');
                        
                        if (currentIndex === 0) {
                            $('div.editorsLeftMain').css('padding-bottom', '0').css('padding-top', '13rem');
                        } else if (currentIndex === 1) {
                            $('div.editorsLeftMain').css({
                                'padding-top': '7.3rem',
                                'padding-bottom': '0'
                            });
                        } else if (currentIndex === 2) {
                            $('div.editorsLeftMain').css({
                                'padding-top': '1.6rem',
                                'padding-bottom': '0'
                            });
                        } else if (currentIndex === 3) {
                            $('div.editorsLeftMain').css({
                                'padding-top': '0',
                                'padding-bottom': '4.1rem'
                            });
                        }
                    }
                
                if ($targetItem.length > 0) {
                    var scrollTo = $targetItem.position().top + $scrollArea.scrollTop() - ($scrollArea.height() - $targetItem.height()) / 2;
                    
                    $scrollArea.stop().scrollTop(scrollTo);
                    
                    setTimeout(function () {
                        isScrolling = false;
                    }, 200);
                } else {
                    isScrolling = false;
                }
            });
        }
        setupScrollableList('ul.editorsLeft.editors');
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      document.querySelectorAll('div.video video').forEach(function(v){
        v.setAttribute('playsinline','');
        v.setAttribute('webkit-playsinline','');
        v.muted = true;
      });
    });
  </script>
</body>
</html>