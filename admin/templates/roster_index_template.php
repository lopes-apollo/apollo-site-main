<?php
// All videos page template - generates roster/index.php
// This shows all videos from all artists in one scrolling page
$visible_artists = array_filter($artists, function($a) { return $a['visible'] ?? true; });
usort($visible_artists, function($a, $b) {
    $cat_order = ['EDIT' => 0, 'COLOR' => 1, 'SOUND' => 2, 'VFX' => 3];
    $a_cat = $cat_order[$a['category'] ?? 'EDIT'] ?? 999;
    $b_cat = $cat_order[$b['category'] ?? 'EDIT'] ?? 999;
    if ($a_cat !== $b_cat) return $a_cat <=> $b_cat;
    return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
});

function formatVideoLong($video_long) {
    if (strpos($video_long, '<iframe') === false && strpos($video_long, 'http') === 0) {
        return '<div style="width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;"><iframe src="' . htmlspecialchars($video_long) . '" name="SimianEmbed" scrolling="no" style="position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000" frameborder="0" allowFullScreen webkitAllowFullScreen></iframe></div>';
    }
    return $video_long;
}
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
    .video-preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: black;
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }
    
    .video-preloader.fade-in {
      opacity: 1;
    }
    
    .video-preloader.fade-out {
      opacity: 0;
    }
    
    .preloader-content {
      text-align: center;
      color: white;
    }
    
    .preloader-spinner {
      width: 50px;
      height: 50px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-top: 3px solid #fff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .preloader-text {
      font-size: 16px;
      font-weight: 300;
    }
  </style>
</head>
<body>
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
	            <a href="/work/">ROSTER</a>
	        </li>
	        <li>
	            <a href="/contact/">CONTACT</a>
	       </li>
	    </ul>
	</div> 
      </div> 
    </header>
  <div class="video-container">  
    <?php 
    $category_map = ['EDIT' => 'EDITOR', 'COLOR' => 'COLORIST', 'SOUND' => 'SOUND', 'VFX' => 'VFX'];
    foreach ($visible_artists as $artist): 
        $videos = $artist['videos'] ?? [];
        usort($videos, function($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });
        $artist_slug = strtolower(str_replace(' ', '-', $artist['name']));
        $author_label = $category_map[$artist['category'] ?? 'EDIT'] ?? 'EDITOR';
        
        foreach ($videos as $idx => $video):
            $video_long = formatVideoLong($video['videoLong'] ?? '');
            $video_class = ($idx === 0) ? $artist_slug . ' ' . $artist['category'] : '';
    ?>
    <div class="video <?php echo $video_class; ?>" 
         data-longVideo="<?php echo htmlspecialchars($video_long, ENT_QUOTES); ?>" 
         data-title="<?php echo htmlspecialchars($artist['name']); ?>" 
         data-author="<?php echo $author_label; ?>" 
         data-prev1="<?php echo htmlspecialchars($video['previewImages'][0] ?? ''); ?>" 
         data-prev2="<?php echo htmlspecialchars($video['previewImages'][1] ?? ''); ?>" 
         data-prev3="<?php echo htmlspecialchars($video['previewImages'][2] ?? ''); ?>" 
         data-prev4="<?php echo htmlspecialchars($video['previewImages'][3] ?? ''); ?>" 
         data-prev5="<?php echo htmlspecialchars($video['previewImages'][4] ?? ''); ?>" 
         data-prev6="<?php echo htmlspecialchars($video['previewImages'][5] ?? ''); ?>" 
         data-videoName="<?php echo htmlspecialchars($video['videoName']); ?>" 
         data-videoSubName="<?php echo htmlspecialchars($video['videoSubName'] ?? ''); ?>" 
         data-credit="<?php echo ($video['hasCredit'] ?? false) ? 'yes' : 'no'; ?>" 
         data-credits="<?php echo htmlspecialchars($video['credits'] ?? '', ENT_QUOTES); ?>">
        <video poster="<?php echo htmlspecialchars($video['poster'] ?? ''); ?>" 
               src="<?php echo htmlspecialchars($video['videoShort']); ?>" 
               muted autoplay loop></video>
        <label><?php echo htmlspecialchars($video['videoName']); ?><?php if ($video['videoSubName']): ?> - <?php echo htmlspecialchars($video['videoSubName']); ?><?php endif; ?></label>
    </div>
    <?php 
        endforeach;
    endforeach; 
    ?>
  </div>
  
  <div class="editorsMain editorsLeftMain" style="padding-top: 2rem;">
        <ul class="editorsLeft editors">
            <li class="active" data-start=0><a href="/roster/edit">EDIT</a></li>
            <li data-start=1><a href="/roster/color">COLOR</a></li>
            <li data-start=2><a href="/roster/sound">SOUND</a></li>
            <li data-start=3><a href="/roster/vfx">VFX</a></li>
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
                $('#videoModalPopup div.creditPopupVideo h3').text(title+' - '+subtitle);
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

        setTimeout(() => {
            window.scrollTo(0, 320);
        }, 300);
        
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
        
    document.addEventListener("DOMContentLoaded", function(event){
        document.querySelectorAll('div.video video').forEach(function(v){
            v.setAttribute('playsinline','');
            v.setAttribute('webkit-playsinline','');
            v.muted = true;
        });
    });
  </script>
  <script>
    $(document).ready(function () {
        var maxWidth = 0;
        $('ul.editorsLeft.editors li[data-start]').each(function() {
            if ($(this).width() > maxWidth) {
                maxWidth = $(this).width();
            }
        });
        $('ul.editorsLeft.editors li[data-start]').width(maxWidth / 2);

        function updateOpacityBasedOnDistance($scrollArea) {
            if (!$scrollArea || $scrollArea.length === 0) return;
            
            var $items = $scrollArea.children('li[data-start]');
            if ($items.length === 0) return;
            
            var scrollAreaHeight = $scrollArea.height();
            var scrollTop = $scrollArea.scrollTop();
            var centerY = scrollAreaHeight / 2; // Center of visible area
            var maxDistance = scrollAreaHeight / 2; // Maximum distance for opacity calculation
            
            $items.each(function() {
                var $item = $(this);
                var itemOffset = $item.position().top; // Position relative to scroll container
                var itemHeight = $item.outerHeight();
                var itemCenterY = itemOffset + (itemHeight / 2);
                
                // Calculate distance from center line
                var distanceFromCenter = Math.abs(itemCenterY - centerY);
                
                // Calculate opacity: 1.0 at center, decreasing as distance increases
                // Using a smooth curve for better visual effect
                var normalizedDistance = Math.min(distanceFromCenter / maxDistance, 1);
                var opacity = 1 - (normalizedDistance * 0.4); // Fade from 1.0 to 0.6
                opacity = Math.max(opacity, 0.6); // Minimum opacity of 0.6
                
                $item.find('a').css('opacity', opacity);
            });
        }
        
        function setupScrollableList(selector) {
            var $scrollArea = $(selector);
            if ($scrollArea.length === 0) {
                console.log('Scroll area not found:', selector);
                return;
            }
            var $items = $scrollArea.children('li[data-start]');
            if ($items.length === 0) {
                console.log('No items with data-start found in:', selector);
                return;
            }
            
            // Ensure the scroll area can scroll by adding padding if needed
            var scrollAreaHeight = $scrollArea.height();
            var totalItemsHeight = 0;
            $items.each(function() {
                totalItemsHeight += $(this).outerHeight(true);
            });
            
            // Add padding to ensure scrolling is possible
            if (totalItemsHeight < scrollAreaHeight) {
                var paddingNeeded = (scrollAreaHeight - totalItemsHeight) / 2;
                $scrollArea.css({
                    'padding-top': paddingNeeded + 'px',
                    'padding-bottom': paddingNeeded + 'px'
                });
            }
            
            var currentIndex = $items.index($scrollArea.find('li.active'));
            if (currentIndex === -1) currentIndex = 0;
            var isScrolling = false;
        
            // Initial opacity update
            updateOpacityBasedOnDistance($scrollArea);
            
            // Update opacity on scroll
            $scrollArea.on('scroll', function() {
                updateOpacityBasedOnDistance($scrollArea);
            });
        
            // Attach wheel event to both the scroll area and its parent container
            var $parentContainer = $scrollArea.closest('.editorsMain');
            
            function handleWheel(e) {
                // Check if mouse is over the scroll area
                var rect = $scrollArea[0].getBoundingClientRect();
                var mouseX = e.originalEvent.clientX;
                var mouseY = e.originalEvent.clientY;
                
                // Only handle if mouse is over the panel
                if (!(mouseX >= rect.left && mouseX <= rect.right && 
                      mouseY >= rect.top && mouseY <= rect.bottom)) {
                    // Mouse is not over the panel, allow normal scrolling
                    return;
                }
                
                // Prevent default scrolling for this panel
                e.preventDefault();
                e.stopPropagation();
                
                if (isScrolling) return;
                isScrolling = true;
        
                if (e.originalEvent.deltaY > 0) {
                    // Scroll down - move to next item
                    if (currentIndex < $items.length - 1) {
                        currentIndex++;
                    }
                } else {
                    // Scroll up - move to previous item
                    if (currentIndex > 0) {
                        currentIndex--;
                    }
                }
        
                var $targetItem = $items.eq(currentIndex);
                if (selector === 'ul.editorsLeft.editors' || selector.indexOf('editorsLeft') !== -1) {
                    // Left panel - categories (EDIT, COLOR, SOUND, VFX)
                    $items.removeClass('active').removeClass('scrollActive');
                    $targetItem.addClass('active').addClass('scrollActive');
                }
                
                if ($targetItem.length > 0) {
                    // Calculate scroll position to center the item
                    var itemOffset = $targetItem.position().top;
                    var scrollAreaHeight = $scrollArea.height();
                    var itemHeight = $targetItem.outerHeight();
                    var scrollTo = itemOffset + $scrollArea.scrollTop() - (scrollAreaHeight / 2) + (itemHeight / 2);
                    
                    $scrollArea.stop().animate({ scrollTop: scrollTo }, 300, function() {
                        isScrolling = false;
                        updateOpacityBasedOnDistance($scrollArea);
                    });
                } else {
                    isScrolling = false;
                }
            }
            
            // Attach to both the scroll area and parent for better detection
            $scrollArea.on('wheel', handleWheel);
            $parentContainer.on('wheel', handleWheel);
        }

        setupScrollableList('ul.editorsLeft.editors');
        
        // Initial opacity update after a short delay to ensure layout is complete
        setTimeout(function() {
            updateOpacityBasedOnDistance($('ul.editorsLeft.editors'));
        }, 100);
    });
  </script>
</body>
</html>
