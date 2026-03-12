<!DOCTYPE html>
<html>
<head>
    <title>APOLLO</title>
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
<div class="backgroundImage bgimage8" style="opacity:1;visibility:visible;">
    <a class="openModelItem" 
       data-image='bgimage8' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/tf0b2EFiRC3XnFSc1Qlj3w/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="EDIT,SOUND,VFX" 
       data-title="Travis Scott x Jumpman" 
       data-subtitle="TREXX" 
       data-credit="yes" 
       data-credits="">
        <video src="videos/short/compressed/trexx cover-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Travis Scott x Jumpman</h3>
        <p style="display:none;">TREXX</p>
    </a> 
</div>
<div class="backgroundImage bgimage14" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage14' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/bxBkupgh_a-_FZxvkuCM5w/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="VFX" 
       data-title="JID" 
       data-subtitle="Jimmy Fallon" 
       data-credit="yes" 
       data-credits="">
        <video src="videos/short/compressed/JID - Jimmy Fallen Live Performance Cover-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">JID</h3>
        <p style="display:none;">Jimmy Fallon</p>
    </a> 
</div>
<div class="backgroundImage bgimage2" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage2' 
       data-prev1="/roster/images/colorist/Arcteryx 1.jpg" 
       data-prev2="/roster/images/colorist/Arcteryx 2.jpg" 
       data-prev3="/roster/images/colorist/Arcteryx 3.jpg" 
       data-prev4="/roster/images/colorist/Arcteryx 4.jpg" 
       data-prev5="/roster/images/colorist/Arcteryx 5.jpg" 
       data-prev6="/roster/images/colorist/Arcteryx 6.jpg" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/HmR1n4iJqvPcP-fVDBwfgA/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="COLORIST" 
       data-title="Arcteryx" 
       data-subtitle="" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;Colorist: Avery Niles&lt;br&gt;Color Producer: Vic Brandt&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Dogma Studios&lt;br&gt;Producers: Lindo Arturo&lt;br&gt;Director: Nicholas Buckwalte&lt;br&gt;DP: Eli Leibow">
        <video src="videos/short/Arcteryx Cover New.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Arcteryx</h3>
        <p style="display:none;"></p>
    </a> 
</div>
<div class="backgroundImage bgimage2" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage2' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/LEBuu0ZcM5vQKF9vyFajNA/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="EDIT" 
       data-title="Nike" 
       data-subtitle="Return to Football" 
       data-credit="no" 
       data-credits="">
        <video src="videos/short/compressed/nv2.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Nike</h3>
        <p style="display:none;">Return to Football</p>
    </a> 
</div>
<div class="backgroundImage bgimage3" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage3' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="SOUND" 
       data-title="Terrace Martin &amp; Alex Isley" 
       data-subtitle="Paradise" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Sound Design: Ayo Douson&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Director: child&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: Galileo Mondol&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: Lopes&lt;/b&gt;&lt;br&gt;&lt;b&gt;Producer: Tashi Bhutia &lt;/b&gt;">
        <video src="videos/short/nv28.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Terrace Martin &amp; Alex Isley</h3>
        <p style="display:none;">Paradise</p>
    </a> 
</div>
<div class="backgroundImage bgimage4" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage4' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT,SOUND" 
       data-title="Under Armour" 
       data-subtitle="The Unstoppable Collection" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt;Head of Post: Alex Peterson&lt;br&gt;Post Supervisor: Chris Carson&lt;br&gt;Editor: Griffin Olis&lt;br&gt;Music: Jile&lt;br&gt;Sound Design: Ayo Douson&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Parallel Studios&lt;br&gt;Director: Michael Kelly&lt;br&gt;Executive Producers: Tony Pillow, Simon Chasalow&lt;br&gt;Lead Producer: Amanda Jones">
        <video src="videos/short/to_compress/nv20.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Under Armour</h3>
        <p style="display:none;">The Unstoppable Collection</p>
    </a> 
</div>
<div class="backgroundImage bgimage5" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage5' 
       data-prev1="images/colorist/penderdyn1.jpg" 
       data-prev2="images/colorist/penderdyn2.jpg" 
       data-prev3="images/colorist/penderdyn3.jpg" 
       data-prev4="images/colorist/penderdyn4.jpg" 
       data-prev5="images/colorist/penderdyn5.jpg" 
       data-prev6="images/colorist/penderdyn6.jpg" 
       data-long="&lt;div style=" 
       data-author="COLOR" 
       data-title="Penderdyn" 
       data-subtitle="Distillery" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Colorist: Wilhends Norvil&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Production Company: neufcinq films&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director: Keirana Scott&lt;/b&gt;">
        <video src="videos/short/compressed/Penderdyn_Distillery 1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Penderdyn</h3>
        <p style="display:none;">Distillery</p>
    </a> 
</div>
<div class="backgroundImage bgimage6" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage6' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT" 
       data-title="OKEM" 
       data-subtitle="Short Film" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt; &lt;b&gt;Editor:&lt;/b&gt; Devon Solwold&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;br&gt; &lt;b&gt;Director:&lt;/b&gt; Joshua Okwuosa&lt;br&gt; &lt;b&gt;DP:&lt;/b&gt; Kai Dickson&lt;br&gt; &lt;b&gt;Producer:&lt;/b&gt; Elizabeth Kraushaar">
        <video src="videos/short/to_compress/eds3.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">OKEM</h3>
        <p style="display:none;">Short Film</p>
    </a> 
</div>
<div class="backgroundImage bgimage7" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage7' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT,SOUND,COLOR,VFX" 
       data-title="Guinness" 
       data-subtitle="The Most Wonderful Pint" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Editor: Alex Peterson&lt;/b&gt;&lt;br&gt;&lt;b&gt;VFX Artist: Ben Gillespie&lt;/b&gt;&lt;br&gt;&lt;b&gt;Sound Design: Ayo Douson&lt;/b&gt;&lt;br&gt;&lt;b&gt;Colorist: Brian Charles&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Creative: Taylor Agency&lt;/b&gt;&lt;br&gt;&lt;b&gt;DP: Jon Cospito&lt;/b&gt;">
        <video src="videos/short/ben-gillespie-guiness.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Guinness</h3>
        <p style="display:none;">The Most Wonderful Pint</p>
    </a> 
</div>
<div class="backgroundImage bgimage9" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage9' 
       data-prev1="/roster/images/colorist/Indio 1.jpg" 
       data-prev2="/roster/images/colorist/Indio 2.jpg" 
       data-prev3="/roster/images/colorist/Indio 3.jpg" 
       data-prev4="/roster/images/colorist/Indio 4.jpg" 
       data-prev5="/roster/images/colorist/Indio 5.jpg" 
       data-prev6="/roster/images/colorist/Indio 6.jpg" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/BuQLAccOTNWLrBVmdRdZDw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="COLORIST" 
       data-title="EvenOdd" 
       data-subtitle="Remezcla - Cerveza Indio" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;VFX Producer: Chris Carson&lt;br&gt;VFX: Ben Gillespie&lt;br&gt;Colorist: Avery Niles&lt;br&gt;Color Producer: Vic Brandt&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Even Odd Studio&lt;br&gt;Director: Ashley Rodholm&lt;br&gt;DP: Chiao Chen">
        <video src="videos/short/indio cover.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">EvenOdd</h3>
        <p style="display:none;">Remezcla - Cerveza Indio</p>
    </a> 
</div>
<div class="backgroundImage bgimage10" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage10' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="SOUND" 
       data-title="New Balance" 
       data-subtitle="Prosperity Be the Prize" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Sounds Design: Ayo Douson&lt;/b&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: &lt;b&gt;Better Days&lt;/b&gt;&lt;br&gt;&lt;b&gt;Directed by: NAT PRINZI&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: NAT PRINZI&lt;/b&gt;">
        <video src="videos/short/nv25.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">New Balance</h3>
        <p style="display:none;">Prosperity Be the Prize</p>
    </a> 
</div>
<div class="backgroundImage bgimage11" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage11' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT" 
       data-title="7uice" 
       data-subtitle="Vanson Leathers" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo:&lt;/h3&gt;&lt;b&gt;Editor: Zack Pelletier&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Production Company: Parallel studios&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director: Drew Cigna, &amp; Medulla Media&lt;/b&gt;&lt;br&gt;&lt;b&gt;DP: Thomas Marchese&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producers: Simon Chasalow &amp; Tony Pillow&lt;/b&gt;">
        <video src="videos/short/ezp3.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">7uice</h3>
        <p style="display:none;">Vanson Leathers</p>
    </a> 
</div>
<div class="backgroundImage bgimage12" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage12' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT" 
       data-title="Kai Cenat" 
       data-subtitle="Going Professional" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;Editor: Griffin Olis&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Black Screen Productions Inc&lt;br&gt;Director: Michael Daniel, Lachlan McClellan&lt;br&gt;Executive Producers: Monique Carrillo, Michael Daniel&lt;br&gt;DP: Jonathan Charles">
        <video src="videos/short/to_compress/nv19.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Kai Cenat</h3>
        <p style="display:none;">Going Professional</p>
    </a> 
</div>
<div class="backgroundImage bgimage13" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage13' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="VFX" 
       data-title="The North Face" 
       data-subtitle="Fall/Winter 2024" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;VFX Artist: Ben Gillespie&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Producer: Will Beihoffer&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director/DP: Cole Pates&lt;/b&gt;">
        <video src="videos/short/nv33.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">The North Face</h3>
        <p style="display:none;">Fall/Winter 2024</p>
    </a> 
</div>
<div class="backgroundImage bgimage1" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage1' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT,SOUND,VFX" 
       data-title="MLS &amp; Apple TV" 
       data-subtitle="Beyond the Pitch" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt;Post Supervisor: Alex Peterson&lt;br&gt;Editor: Griffin Olis&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Parallel Studios&lt;br&gt;Director: Don Newkirk Jr.&lt;br&gt;Executive Producers: Alex Peterson, Nate Loucks&lt;br&gt;Media Company: Boardroom">
        <video src="videos/short/to_compress/MLS_Episode_4.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">MLS &amp; Apple TV</h3>
        <p style="display:none;">Beyond the Pitch</p>
    </a> 
</div>
<div class="backgroundImage bgimage15" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage15' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=" 
       data-author="EDIT" 
       data-title="Brooks" 
       data-subtitle="Sounds of Trail Running" 
       data-credit="yes" 
       data-credits="&lt;h3&gt;Apollo&lt;/h3&gt; Editor: Liam Tangum &lt;br&gt;&lt;br&gt; &lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Production Comapny:&lt;/b&gt; Stept Studios&lt;br&gt; &lt;b&gt;DP:&lt;/b&gt; Nash Howe&lt;br&gt; &lt;b&gt;Head of Post:&lt;/b&gt; Connor Scofield&lt;br&gt;">
        <video src="videos/short/to_compress/nv13.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Brooks</h3>
        <p style="display:none;">Sounds of Trail Running</p>
    </a> 
</div>
<div class="backgroundImage bgimage16" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" 
       data-image='bgimage16' 
       data-prev1="" 
       data-prev2="" 
       data-prev3="" 
       data-prev4="" 
       data-prev5="" 
       data-prev6="" 
       data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
       data-author="VFX" 
       data-title="David Kushner" 
       data-subtitle="Sweet Oblivion" 
       data-credit="yes" 
       data-credits="">
        <video src="videos/short/compressed/david kushner sweet oblivion-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">David Kushner</h3>
        <p style="display:none;">Sweet Oblivion</p>
    </a> 
</div>

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
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage8' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT,SOUND,VFX" 
                   data-title="Travis Scott x Jumpman" 
                   data-subtitle="TREXX" 
                   data-credit="yes" 
                   data-credits="">
                    Travis Scott x Jumpman - TREXX                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage14' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="VFX" 
                   data-title="JID" 
                   data-subtitle="Jimmy Fallon" 
                   data-credit="yes" 
                   data-credits="">
                    JID - Jimmy Fallon                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage2' 
                   data-prev1="/roster/images/colorist/Arcteryx 1.jpg" 
                   data-prev2="/roster/images/colorist/Arcteryx 2.jpg" 
                   data-prev3="/roster/images/colorist/Arcteryx 3.jpg" 
                   data-prev4="/roster/images/colorist/Arcteryx 4.jpg" 
                   data-prev5="/roster/images/colorist/Arcteryx 5.jpg" 
                   data-prev6="/roster/images/colorist/Arcteryx 6.jpg" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="COLORIST" 
                   data-title="Arcteryx" 
                   data-subtitle="" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;Colorist: Avery Niles&lt;br&gt;Color Producer: Vic Brandt&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Dogma Studios&lt;br&gt;Producers: Lindo Arturo&lt;br&gt;Director: Nicholas Buckwalte&lt;br&gt;DP: Eli Leibow">
                    Arcteryx                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage2' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT" 
                   data-title="Nike" 
                   data-subtitle="Return to Football" 
                   data-credit="no" 
                   data-credits="">
                    Nike - Return to Football                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage3' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="SOUND" 
                   data-title="Terrace Martin &amp; Alex Isley" 
                   data-subtitle="Paradise" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Sound Design: Ayo Douson&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Director: child&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: Galileo Mondol&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: Lopes&lt;/b&gt;&lt;br&gt;&lt;b&gt;Producer: Tashi Bhutia &lt;/b&gt;">
                    Terrace Martin &amp; Alex Isley - Paradise                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage4' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT,SOUND" 
                   data-title="Under Armour" 
                   data-subtitle="The Unstoppable Collection" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt;Head of Post: Alex Peterson&lt;br&gt;Post Supervisor: Chris Carson&lt;br&gt;Editor: Griffin Olis&lt;br&gt;Music: Jile&lt;br&gt;Sound Design: Ayo Douson&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Parallel Studios&lt;br&gt;Director: Michael Kelly&lt;br&gt;Executive Producers: Tony Pillow, Simon Chasalow&lt;br&gt;Lead Producer: Amanda Jones">
                    Under Armour - The Unstoppable Collection                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage5' 
                   data-prev1="images/colorist/penderdyn1.jpg" 
                   data-prev2="images/colorist/penderdyn2.jpg" 
                   data-prev3="images/colorist/penderdyn3.jpg" 
                   data-prev4="images/colorist/penderdyn4.jpg" 
                   data-prev5="images/colorist/penderdyn5.jpg" 
                   data-prev6="images/colorist/penderdyn6.jpg" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="COLOR" 
                   data-title="Penderdyn" 
                   data-subtitle="Distillery" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Colorist: Wilhends Norvil&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Production Company: neufcinq films&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director: Keirana Scott&lt;/b&gt;">
                    Penderdyn - Distillery                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage6' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT" 
                   data-title="OKEM" 
                   data-subtitle="Short Film" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt; &lt;b&gt;Editor:&lt;/b&gt; Devon Solwold&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;br&gt; &lt;b&gt;Director:&lt;/b&gt; Joshua Okwuosa&lt;br&gt; &lt;b&gt;DP:&lt;/b&gt; Kai Dickson&lt;br&gt; &lt;b&gt;Producer:&lt;/b&gt; Elizabeth Kraushaar">
                    OKEM - Short Film                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage7' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT,SOUND,COLOR,VFX" 
                   data-title="Guinness" 
                   data-subtitle="The Most Wonderful Pint" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Editor: Alex Peterson&lt;/b&gt;&lt;br&gt;&lt;b&gt;VFX Artist: Ben Gillespie&lt;/b&gt;&lt;br&gt;&lt;b&gt;Sound Design: Ayo Douson&lt;/b&gt;&lt;br&gt;&lt;b&gt;Colorist: Brian Charles&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Creative: Taylor Agency&lt;/b&gt;&lt;br&gt;&lt;b&gt;DP: Jon Cospito&lt;/b&gt;">
                    Guinness - The Most Wonderful Pint                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage9' 
                   data-prev1="/roster/images/colorist/Indio 1.jpg" 
                   data-prev2="/roster/images/colorist/Indio 2.jpg" 
                   data-prev3="/roster/images/colorist/Indio 3.jpg" 
                   data-prev4="/roster/images/colorist/Indio 4.jpg" 
                   data-prev5="/roster/images/colorist/Indio 5.jpg" 
                   data-prev6="/roster/images/colorist/Indio 6.jpg" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="COLORIST" 
                   data-title="EvenOdd" 
                   data-subtitle="Remezcla - Cerveza Indio" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;VFX Producer: Chris Carson&lt;br&gt;VFX: Ben Gillespie&lt;br&gt;Colorist: Avery Niles&lt;br&gt;Color Producer: Vic Brandt&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Even Odd Studio&lt;br&gt;Director: Ashley Rodholm&lt;br&gt;DP: Chiao Chen">
                    EvenOdd - Remezcla - Cerveza Indio                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage10' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="SOUND" 
                   data-title="New Balance" 
                   data-subtitle="Prosperity Be the Prize" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;Sounds Design: Ayo Douson&lt;/b&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: &lt;b&gt;Better Days&lt;/b&gt;&lt;br&gt;&lt;b&gt;Directed by: NAT PRINZI&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producer: NAT PRINZI&lt;/b&gt;">
                    New Balance - Prosperity Be the Prize                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage11' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT" 
                   data-title="7uice" 
                   data-subtitle="Vanson Leathers" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo:&lt;/h3&gt;&lt;b&gt;Editor: Zack Pelletier&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;&lt;b&gt;Production Company: Parallel studios&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director: Drew Cigna, &amp; Medulla Media&lt;/b&gt;&lt;br&gt;&lt;b&gt;DP: Thomas Marchese&lt;/b&gt;&lt;br&gt;&lt;b&gt;Executive Producers: Simon Chasalow &amp; Tony Pillow&lt;/b&gt;">
                    7uice - Vanson Leathers                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage12' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT" 
                   data-title="Kai Cenat" 
                   data-subtitle="Going Professional" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;Editor: Griffin Olis&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Black Screen Productions Inc&lt;br&gt;Director: Michael Daniel, Lachlan McClellan&lt;br&gt;Executive Producers: Monique Carrillo, Michael Daniel&lt;br&gt;DP: Jonathan Charles">
                    Kai Cenat - Going Professional                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage13' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="VFX" 
                   data-title="The North Face" 
                   data-subtitle="Fall/Winter 2024" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;b&gt;VFX Artist: Ben Gillespie&lt;/b&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Producer: Will Beihoffer&lt;/b&gt;&lt;br&gt;&lt;b&gt;Director/DP: Cole Pates&lt;/b&gt;">
                    The North Face - Fall/Winter 2024                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage1' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT,SOUND,VFX" 
                   data-title="MLS &amp; Apple TV" 
                   data-subtitle="Beyond the Pitch" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt;&lt;br&gt;Post Supervisor: Alex Peterson&lt;br&gt;Editor: Griffin Olis&lt;br&gt;&lt;br&gt;&lt;h3&gt;Production&lt;/h3&gt;Production Company: Parallel Studios&lt;br&gt;Director: Don Newkirk Jr.&lt;br&gt;Executive Producers: Alex Peterson, Nate Loucks&lt;br&gt;Media Company: Boardroom">
                    MLS &amp; Apple TV - Beyond the Pitch                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage15' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="EDIT" 
                   data-title="Brooks" 
                   data-subtitle="Sounds of Trail Running" 
                   data-credit="yes" 
                   data-credits="&lt;h3&gt;Apollo&lt;/h3&gt; Editor: Liam Tangum &lt;br&gt;&lt;br&gt; &lt;h3&gt;Production&lt;/h3&gt; &lt;b&gt;Production Comapny:&lt;/b&gt; Stept Studios&lt;br&gt; &lt;b&gt;DP:&lt;/b&gt; Nash Howe&lt;br&gt; &lt;b&gt;Head of Post:&lt;/b&gt; Connor Scofield&lt;br&gt;">
                    Brooks - Sounds of Trail Running                </a> 
            </li>
                        <li>
                <a class="openModelItem" 
                   data-image='bgimage16' 
                   data-prev1="" 
                   data-prev2="" 
                   data-prev3="" 
                   data-prev4="" 
                   data-prev5="" 
                   data-prev6="" 
                   data-long="&lt;div style=&quot;width:100%;height:0;position: relative;padding-bottom:56.25000%;margin-bottom:10px;&quot;&gt;&lt;iframe src=&quot;https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/&quot; name=&quot;SimianEmbed&quot; scrolling=&quot;no&quot; style=&quot;position: absolute;top: 0; left: 0; width: 100%; height: 100%;padding:0 !important;margin:0 !important;background:#000000&quot; frameborder=&quot;0&quot; allowFullScreen webkitAllowFullScreen&gt;&lt;/iframe&gt;&lt;/div&gt;" 
                   data-author="VFX" 
                   data-title="David Kushner" 
                   data-subtitle="Sweet Oblivion" 
                   data-credit="yes" 
                   data-credits="">
                    David Kushner - Sweet Oblivion                </a> 
            </li>
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
        video.src = 'home-new/mobilehomepreloadervideo.mp4';
    } else {
        video.src = 'home-new/homepreloadervideo.mp4';
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
