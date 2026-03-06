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
        z-index: 999999; /* Higher than header (9999) and any other elements */
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
        z-index: 999999; /* Maintain high z-index during animation */
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
                <a href="work/">ROSTER</a>
                <!--<ol>--> 
                <!--   <li>-->
                <!--        <a href="/roster-update-new/?author=EDITOR">Editor</a>-->
                <!--        <ol class="last">-->
                <!--            <li>-->
             <!--                   <a href="/roster-update-new/?author=EDITOR&writer=GRIFFIN OLIS">Griffin Olis</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?author=EDITOR&writer=ALEX PETERSON">Alex Peterson</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?author=EDITOR&writer=DEVON SOLWOLD">Devon Solwold</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?author=EDITOR&writer=ZACK PELLETIER">Zack Pelletier</a>-->
             <!--               </li>-->
                <!--        </ol>-->
                <!--   </li>-->
                <!--   <li>-->
                <!--        <a href="/roster-update-new/?author=COLORIST">Color</a>-->
                <!--        <ol class="last">-->
                <!--            <li>-->
             <!--                   <a href="/roster-update-new/?author=COLORIST&writer=WILHENDS NORVIL">Wilhends Norvil</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?author=COLORIST&writer=MIKE DE LA LUZ">Mike De La Luz</a>-->
             <!--               </li>-->
                <!--        </ol>-->
                <!--   </li>-->
                <!--   <li>-->
                <!--        <a href="/roster-update-new/?author=SOUND">Sound</a>-->
                <!--        <ol class="last">-->
                <!--            <li>-->
             <!--                   <a href="/roster-update-new/?author=SOUND&writer=DOUSON">Douson</a>-->
             <!--               </li>-->
                <!--        </ol>-->
                <!--   </li>-->
                <!--   <li>-->
                <!--        <a href="/roster-update-new/?author=VFX">VFX</a>-->
                <!--        <ol class="last">-->
                <!--            <li>-->
             <!--                   <a href="/roster-update-new/?author=VFX&writer=JUMPER">Jumper</a>-->
             <!--               </li>-->
                <!--        </ol>-->
                <!--   </li>-->
                <!--</ol>-->
            </li>
            <li>
                <a href="contact/">CONTACT</a>
            </li>
        </ul>
    </div>
</header>    
<div class="backgroundImage bgimage8" style="opacity:1;visibility:visible;">
    <a class="openModelItem" data-image='bgimage8' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/tf0b2EFiRC3XnFSc1Qlj3w/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,VFX" data-title="Travis Scott x Jumpman" data-subtitle="TREXX" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Editor: Nasser Boulaich<br>Sound Design: Ayo Douson<br>VFX: Le Jumper<br><br><h3>Production</h3>Agency: Game Seven<br>Production Company: Offsite Works<br>Director: Hannan Hussain<br>Sr. Creative Producer: Ramy Elsokary<br>Executive Producer: Mossa Projects<br>DP: Mike Koziel">
        <video src="roster/videos/short/compressed/trexx cover-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Travis Scott x Jumpman</h3>
        <p style="display:none;">TREXX</p>
    </a> 
</div>
<div class="backgroundImage bgimage14" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage14' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/bxBkupgh_a-_FZxvkuCM5w/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="JID" data-subtitle="Jimmy Fallon" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Post Supervisor: Nasser Boulaich<br>Edit/VFX: Fonzel<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Waboosh">
        <video src="roster/videos/short/compressed/JID - Jimmy Fallen Live Performance Cover-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">JID</h3>
        <p style="display:none;">Jimmy Fallon</p>
    </a> 
</div>  
<div class="backgroundImage bgimage2" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage2' data-prev1="/roster/images/colorist/Arcteryx 1.jpg" data-prev2="/roster/images/colorist/Arcteryx 2.jpg" data-prev3="/roster/images/colorist/Arcteryx 3.jpg" data-prev4="/roster/images/colorist/Arcteryx 4.jpg" data-prev5="/roster/images/colorist/Arcteryx 5.jpg" data-prev6="/roster/images/colorist/Arcteryx 6.jpg" data-long="https://apollo.gosimian.com/share/v/HmR1n4iJqvPcP-fVDBwfgA/false/auto/auto/ffffff/000000/" data-author="COLORIST" data-title="Arcteryx" data-subtitle="" data-credit="yes" data-credits="<h3>Apollo</h3>Colorist: Avery Niles<br>Color Producer: Vic Brandt<br><br><h3>Production</h3>Production Company: Dogma Studios<br>Producers: Lindo Arturo<br>Director: Nicholas Buckwalte<br>DP: Eli Leibow">
        <video src="roster/videos/short/Arcteryx Cover New.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Arcteryx</h3>
        <p style="display:none;"></p>
    </a> 
</div>
<!-- <div class="backgroundImage bgimage2" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage2' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/LEBuu0ZcM5vQKF9vyFajNA/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Nike" data-subtitle="Return to Football">
        <video src="roster/videos/short/compressed/nv2.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Nike</h3>
        <p style="display:none;">Return to Football</p>
    </a> 
</div> -->
<div class="backgroundImage bgimage3" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage3' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/mk71YHvlAjqKmE2SMuihew/false/auto/auto/ffffff/000000/"  data-author="SOUND" data-title="Terrace Martin & Alex Isley" data-subtitle="Paradise" data-credit="yes" data-credits="<h3>Apollo</h3><b>Sound Design: Ayo Douson</b><br><br><h3>Production</h3><b>Director: child</b><br><b>Executive Producer: Galileo Mondol</b><br><b>Executive Producer: Lopes</b><br><b>Producer: Tashi Bhutia </b>">
        <video src="roster/videos/short/compressed/nv28.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Terrace Martin & Alex Isley</h3>
        <p style="display:none;">Paradise</p>
    </a> 
</div>
<div class="backgroundImage bgimage4" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage4' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/eHWf8zsSuiwys697NlDV3A/false/auto/auto/ffffff/000000/"  data-author="EDIT,SOUND" data-title="Under Armour" data-subtitle="The Unstoppable Collection" data-credit="yes" data-credits="<h3>Apollo</h3><br>Head of Post: Alex Peterson<br>Post Supervisor: Chris Carson<br>Editor: Griffin Olis<br>Music: Jile<br>Sound Design: Ayo Douson<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Michael Kelly<br>Executive Producers: Tony Pillow, Simon Chasalow<br>Lead Producer: Amanda Jones">
        <video src="roster/videos/short/compressed/nv20.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Under Armour</h3>
        <p style="display:none;">The Unstoppable Collection</p>
    </a> 
</div>
<div class="backgroundImage bgimage5" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage5' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/X9KW-za1rOfAhEgrYOvm-w/false/auto/auto/ffffff/000000/" data-author="COLOR" data-title="Penderdyn" data-subtitle="Distillery" data-credit="yes" data-credits="<h3>Apollo</h3><b>Colorist: Wilhends Norvil</b><br><br><h3>Production</h3><b>Director: Keirana Scott</b><br><b>Production: neufcinq films</b>">
        <video src="roster/videos/short/compressed/Penderdyn_Distillery.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Penderdyn</h3>
        <p style="display:none;">Distillery</p>
    </a> 
</div>
<div class="backgroundImage bgimage6" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage6' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/Kj037VYYf3TRWAyj2X9grw/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="OKEM" data-subtitle="Short Film" data-credit="yes" data-credits="<h3>Apollo</h3><br> <b>Editor:</b> Devon Solwold<br><br><h3>Production</h3><br> <b>Director:</b> Joshua Okwuosa<br> <b>DP:</b> Kai Dickson<br> <b>Producer:</b> Elizabeth Kraushaar">
        <video src="roster/videos/short/compressed/OKEM-Short Film.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">OKEM</h3>
        <p style="display:none;">Short Film</p>
    </a> 
</div>
<div class="backgroundImage bgimage7" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage7' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/6jqEx2rQsXxfcIoiabqIvw/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,COLOR,VFX" data-title="Guinness" data-subtitle="The Most Wonderful Pint" data-credit="yes" data-credits="<h3>Apollo</h3><b>Editor: Alex Peterson</b><br><b>VFX Artist: Ben Gillespie</b><br><b>Sound Design: Ayo Douson</b><br><b>Colorist: Brian Charles</b><br><br><h3>Production</h3> <b>Creative: Taylor Agency</b><br><b>DP: Jon Cospito</b>">
        <video src="roster/videos/short/compressed/ben-gillespie-guiness.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Guinness</h3>
        <p style="display:none;">The Most Wonderful Pint</p>
    </a> 
</div>
<div class="backgroundImage bgimage9" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage9' data-prev1="/roster/images/colorist/Indio 1.jpg" data-prev2="/roster/images/colorist/Indio 2.jpg" data-prev3="/roster/images/colorist/Indio 3.jpg" data-prev4="/roster/images/colorist/Indio 4.jpg" data-prev5="/roster/images/colorist/Indio 5.jpg" data-prev6="/roster/images/colorist/Indio 6.jpg" data-long="https://apollo.gosimian.com/share/v/BuQLAccOTNWLrBVmdRdZDw/false/auto/auto/ffffff/000000/" data-author="COLORIST" data-title="EvenOdd" data-subtitle="Remezcla - Cerveza Indio" data-credit="yes" data-credits="<h3>Apollo</h3>VFX Producer: Chris Carson<br>VFX: Ben Gillespie<br>Colorist: Avery Niles<br>Color Producer: Vic Brandt<br><br><h3>Production</h3>Production Company: Even Odd Studio<br>Director: Ashley Rodholm<br>DP: Chiao Chen">
        <video src="roster/videos/short/indio cover.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">EvenOdd</h3>
        <p style="display:none;">Remezcla - Cerveza Indio</p>
    </a> 
</div>
<div class="backgroundImage bgimage10" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage10' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/_cBrDrn0LQod1q6m8cml6A/false/auto/auto/ffffff/000000/" data-author="SOUND" data-title="New Balance" data-subtitle="Prosperity Be the Prize" data-credit="yes" data-credits="<h3>Apollo:</h3><b>Sounds Design: Ayo Douson</b><br><br><h3>Production</h3>Production Company: <b>Better Days</b><br><b>Directed by: NAT PRINZI</b><br><b>Executive Producer: NAT PRINZI</b>">
        <video src="roster/videos/short/compressed/nv25.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">New Balance</h3>
        <p style="display:none;">Prosperity Be the Prize</p>
    </a> 
</div> 
<div class="backgroundImage bgimage11" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage11' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/F-iBZ5QVpkJnpMEDcCBj0g/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="7uice" data-subtitle="Vanson Leathers" data-credit="yes" data-credits="<h3>Apollo:</h3><b>Editor: Zack Pelletier</b><br><br><h3>Production</h3> <b>Director: Drew Cigna, & Medulla Media</b><br><b>DP: Thomas Marchese</b><br><b>Produced by: Parallel studios</b><br><b>Executive Producer: Simon Chasalow & Tony Pillow</b>">
        <video src="roster/videos/short/compressed/7uicexVansonLeathers.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">7uice</h3>
        <p style="display:none;">Vanson Leathers</p>
    </a> 
</div> 
<div class="backgroundImage bgimage12" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage12' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/n0LFcwPS9X72xQRkpvugzw/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Kai Cenat" data-subtitle="Going Professional" data-credit="yes" data-credits="<h3>Apollo</h3><br>Editor: Griffin Olis<br><br><h3>Production</h3>Production Company: Black Screen Productions Inc<br>Director: Michael Daniel, Lachlan McClellan<br>Executive Producers: Monique Carrillo, Michael Daniel<br>DP: Jonathan Charles">
        <video src="roster/videos/short/compressed/nv19.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Kai Cenat</h3>
        <p style="display:none;">Going Professional</p>
    </a> 
</div> 
<div class="backgroundImage bgimage13" style="opacity:0;visibility:hidden;">     
    <a class="openModelItem" data-image='bgimage13' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/NKUOtAvy-_d2e9dCv-bB5A/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="The North Face" data-subtitle="Fall/Winter 2024" data-credit="yes" data-credits="<h3>Apollo</h3><b>VFX Artist: Ben Gillespie</b><br><br><h3>Production</h3> <b>Producer: Will Beihoffer</b><br><b>Director/DP: Cole Pates</b>">
        <video src="roster/videos/short/compressed/nv33.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">The North Face</h3>
        <p style="display:none;">Fall/Winter 2024</p>
    </a> 
</div> 
<div class="backgroundImage bgimage1"  style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage1' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/_m2_Z8QG2n7FMj9u6qLWZA/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,VFX" data-title="MLS & Apple TV" data-subtitle="Beyond the Pitch" data-credit="yes" data-credits="<h3>Apollo</h3><br>Post Supervisor: Alex Peterson<br>Editor: Griffin Olis<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Don Newkirk Jr.<br>Executive Producers: Alex Peterson, Nate Loucks<br>Media Company: Boardroom">
        <video src="roster/videos/short/compressed/MLS_Episode_4.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">MLS & Apple TV</h3>
        <p style="display:none;">Beyond the Pitch</p>
    </a>  
</div>
<div class="backgroundImage bgimage15" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage15' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/2RyALL3vM1bbYlXn6hEOjQ/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Brooks" data-subtitle="Sounds of Trail Running" data-credit="yes" data-credits="<h3>Apollo</h3>Editor: Liam Tangum<br><br><h3>Production</h3> Production Company: Stept Studios<br> <b>DP:</b> Nash Howe<br> <b>Head of Post:</b> Connor Scofield">
        <video src="roster/videos/short/compressed/nv13.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">Brooks</h3>
        <p style="display:none;">Sounds of Trail Running</p>
    </a> 
</div> 
<!-- <div class="backgroundImage bgimage16" style="opacity:0;visibility:hidden;">
    <a class="openModelItem" data-image='bgimage16' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="David Kushner" data-subtitle="Sweet Oblivion" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Editor: Erik Rojas<br>Colorist: Jared Rosenthal<br>CG Leads: Jack Phoenix, Gino Fernandez, Vitaly Havrylyuk<br>VFX Artists: Sinsterz, Joey Sperger<br>Comp Lead: Anurag Raj<br><br><h3>Production</h3>Production Company: BT Studios<br>Director: Erik Rojas<br>Executive Producers: Galileo Mondol, Carlos Lopes, Alex Alvga<br>DP: Rob Russell">
        <video src="roster/videos/short/compressed/david kushner sweet oblivion-1080p.mp4" muted autoplay loop playsinline></video>
        <h3 style="display:none;">David Kushner</h3>
        <p style="display:none;">Sweet Oblivion</p>
    </a> 
</div>  -->
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
                <a class="openModelItem" data-image='bgimage8' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/tf0b2EFiRC3XnFSc1Qlj3w/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,VFX" data-title="Travis Scott x Jumpman" data-subtitle="TREXX" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Editor: Nasser Boulaich<br>Sound Design: Ayo Douson<br>VFX: Le Jumper<br><br><h3>Production</h3>Agency: Game Seven<br>Production Company: Offsite Works<br>Director: Hannan Hussain<br>Sr. Creative Producer: Ramy Elsokary<br>Executive Producer: Mossa Projects<br>DP: Mike Koziel">Travis Scott x Jumpman - TREXX</a> 
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage14' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/bxBkupgh_a-_FZxvkuCM5w/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="JID" data-subtitle="Jimmy Fallon" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Post Supervisor: Nasser Boulaich<br>Edit/VFX: Fonzel<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Waboosh">JID - Jimmy Fallon</a>
            </li> 
            <li>
                <a class="openModelItem" data-image='bgimage2' data-prev1="/roster/images/colorist/Arcteryx 1.jpg" data-prev2="/roster/images/colorist/Arcteryx 2.jpg" data-prev3="/roster/images/colorist/Arcteryx 3.jpg" data-prev4="/roster/images/colorist/Arcteryx 4.jpg" data-prev5="/roster/images/colorist/Arcteryx 5.jpg" data-prev6="/roster/images/colorist/Arcteryx 6.jpg" data-long="https://apollo.gosimian.com/share/v/HmR1n4iJqvPcP-fVDBwfgA/false/auto/auto/ffffff/000000/" data-author="COLORIST" data-title="Arcteryx" data-subtitle="" data-credit="yes" data-credits="<h3>Apollo</h3>Colorist: Avery Niles<br>Color Producer: Vic Brandt<br><br><h3>Production</h3>Production Company: Dogma Studios<br>Producers: Lindo Arturo<br>Director: Nicholas Buckwalte<br>DP: Eli Leibow">Arcteryx</a>
            </li>
            <!-- <li>
                <a class="openModelItem" data-image='bgimage2' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/LEBuu0ZcM5vQKF9vyFajNA/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Nike" data-subtitle="Return to Football">Nike - Return to Football</a>
            </li> -->
            <li>
                <a class="openModelItem" data-image='bgimage3' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/mk71YHvlAjqKmE2SMuihew/false/auto/auto/ffffff/000000/"  data-author="SOUND" data-title="Terrace Martin & Alex Isley" data-subtitle="Paradise" data-credit="yes" data-credits="<h3>Apollo</h3><b>Sound Design: Ayo Douson</b><br><br><h3>Production</h3><b>Director: child</b><br><b>Executive Producer: Galileo Mondol</b><br><b>Executive Producer: Lopes</b><br><b>Producer: Tashi Bhutia </b>">Terrace Martin & Alex Isley - Paradise</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage4' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/eHWf8zsSuiwys697NlDV3A/false/auto/auto/ffffff/000000/"  data-author="EDIT,SOUND" data-title="Under Armour" data-subtitle="The Unstoppable Collection" data-credit="yes" data-credits="<h3>Apollo</h3><br>Head of Post: Alex Peterson<br>Post Supervisor: Chris Carson<br>Editor: Griffin Olis<br>Music: Jile<br>Sound Design: Ayo Douson<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Michael Kelly<br>Executive Producers: Tony Pillow, Simon Chasalow<br>Lead Producer: Amanda Jones">Under Armour - The Unstoppable Collection</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage5' data-prev1="roster/images/colorist/penderdyn1.jpg" data-prev2="roster/images/colorist/penderdyn2.jpg" data-prev3="roster/images/colorist/penderdyn3.jpg" data-prev4="roster/images/colorist/penderdyn4.jpg" data-prev5="roster/images/colorist/penderdyn5.jpg" data-prev6="roster/images/colorist/penderdyn6.jpg" data-long="https://apollo.gosimian.com/share/v/X9KW-za1rOfAhEgrYOvm-w/false/auto/auto/ffffff/000000/" data-author="COLOR" data-title="Penderdyn" data-subtitle="Distillery" data-credit="yes" data-credits="<h3>Apollo</h3><b>Colorist: Wilhends Norvil</b><br><br><h3>Production</h3><b>Director: Keirana Scott</b><br><b>Production: neufcinq films</b>">Penderdyn Distillery</a>
            </li>
            <li> 
                <a class="openModelItem" data-image='bgimage6' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/Kj037VYYf3TRWAyj2X9grw/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="OKEM" data-subtitle="Short Film" data-credit="yes" data-credits="<h3>Apollo</h3><br> <b>Editor:</b> Devon Solwold<br><br><h3>Production</h3><br> <b>Director:</b> Joshua Okwuosa<br> <b>DP:</b> Kai Dickson<br> <b>Producer:</b> Elizabeth Kraushaar">OKEM - Short Film</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage7' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/6jqEx2rQsXxfcIoiabqIvw/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,COLOR,VFX" data-title="Guinness" data-subtitle="The Most Wonderful Pint" data-credit="yes" data-credits="<h3>Apollo</h3><b>Editor: Alex Peterson</b><br><b>VFX Artist: Ben Gillespie</b><br><b>Sound Design: Ayo Douson</b><br><b>Colorist: Brian Charles</b><br><br><h3>Production</h3> <b>Creative: Taylor Agency</b><br><b>DP: Jon Cospito</b>">Guinness - The Most Wonderful Pint</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage9' data-prev1="/roster/images/colorist/Indio 1.jpg" data-prev2="/roster/images/colorist/Indio 2.jpg" data-prev3="/roster/images/colorist/Indio 3.jpg" data-prev4="/roster/images/colorist/Indio 4.jpg" data-prev5="/roster/images/colorist/Indio 5.jpg" data-prev6="/roster/images/colorist/Indio 6.jpg" data-long="https://apollo.gosimian.com/share/v/BuQLAccOTNWLrBVmdRdZDw/false/auto/auto/ffffff/000000/" data-author="COLORIST" data-title="EvenOdd" data-subtitle="Remezcla - Cerveza Indio" data-credit="yes" data-credits="<h3>Apollo</h3>VFX Producer: Chris Carson<br>VFX: Ben Gillespie<br>Colorist: Avery Niles<br>Color Producer: Vic Brandt<br><br><h3>Production</h3>Production Company: Even Odd Studio<br>Director: Ashley Rodholm<br>DP: Chiao Chen">EvenOdd - Remezcla - Cerveza Indio</a> 
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage10' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/_cBrDrn0LQod1q6m8cml6A/false/auto/auto/ffffff/000000/" data-author="SOUND" data-title="New Balance" data-subtitle="Prosperity Be the Prize" data-credit="yes" data-credits="<h3>Apollo:</h3><b>Sounds Design: Ayo Douson</b><br><br><h3>Production</h3>Production Company: <b>Better Days</b><br><b>Directed by: NAT PRINZI</b><br><b>Executive Producer: NAT PRINZI</b>">New Balance - Prosperity Be the Prize</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage11' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/F-iBZ5QVpkJnpMEDcCBj0g/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="7uice" data-subtitle="Vanson Leathers" data-credit="yes" data-credits="<h3>Apollo:</h3><b>Editor: Zack Pelletier</b><br><br><h3>Production</h3> <b>Director: Drew Cigna, & Medulla Media</b><br><b>DP: Thomas Marchese</b><br><b>Produced by: Parallel studios</b><br><b>Executive Producer: Simon Chasalow & Tony Pillow</b>">7uice - Vanson Leathers</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage12' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/n0LFcwPS9X72xQRkpvugzw/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Kai Cenat" data-subtitle="Going Professional" data-credit="yes" data-credits="<h3>Apollo</h3><br>Editor: Griffin Olis<br><br><h3>Production</h3>Production Company: Black Screen Productions Inc<br>Director: Michael Daniel, Lachlan McClellan<br>Executive Producers: Monique Carrillo, Michael Daniel<br>DP: Jonathan Charles">Kai Cenat - Going Professional</a>
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage13' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/NKUOtAvy-_d2e9dCv-bB5A/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="The North Face" data-subtitle="Fall/Winter 2024" data-credit="yes" data-credits="<h3>Apollo</h3><b>VFX Artist: Ben Gillespie</b><br><br><h3>Production</h3> <b>Producer: Will Beihoffer</b><br><b>Director/DP: Cole Pates</b>">The North Face - Fall/Winter 2024</a>
            </li>
            <li>   
                <a class="openModelItem" data-image='bgimage1' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/_m2_Z8QG2n7FMj9u6qLWZA/false/auto/auto/ffffff/000000/" data-author="EDIT,SOUND,VFX" data-title="MLS & Apple TV" data-subtitle="Beyond the Pitch" data-credit="yes" data-credits="<h3>Apollo</h3><br>Post Supervisor: Alex Peterson<br>Editor: Griffin Olis<br><br><h3>Production</h3>Production Company: Parallel Studios<br>Director: Don Newkirk Jr.<br>Executive Producers: Alex Peterson, Nate Loucks<br>Media Company: Boardroom">MLS & Apple TV - Beyond the Pitch</a>  
            </li>
            <li>
                <a class="openModelItem" data-image='bgimage15' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/2RyALL3vM1bbYlXn6hEOjQ/false/auto/auto/ffffff/000000/" data-author="EDIT" data-title="Brooks" data-subtitle="Sounds of Trail Running" data-credit="yes" data-credits="<h3>Apollo</h3>Editor: Liam Tangum<br><br><h3>Production</h3> Production Company: Stept Studios<br> <b>DP:</b> Nash Howe<br> <b>Head of Post:</b> Connor Scofield">Brooks - Sounds of Trail Running</a>
            </li>
            <!-- <li>
                <a class="openModelItem" data-image='bgimage16' data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-long="https://apollo.gosimian.com/share/v/8SNhuWKzlg6gCP60gUeDxw/false/auto/auto/ffffff/000000/" data-author="VFX" data-title="David Kushner" data-subtitle="Sweet Oblivion" data-credit="yes" data-credits="<h3>Apollo</h3>Post Producer: Alex Peterson<br>Editor: Erik Rojas<br>Colorist: Jared Rosenthal<br>CG Leads: Jack Phoenix, Gino Fernandez, Vitaly Havrylyuk<br>VFX Artists: Sinsterz, Joey Sperger<br>Comp Lead: Anurag Raj<br><br><h3>Production</h3>Production Company: BT Studios<br>Director: Erik Rojas<br>Executive Producers: Galileo Mondol, Carlos Lopes, Alex Alvga<br>DP: Rob Russell">David Kushner - Sweet Oblivion</a>
            </li> -->
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
    if(jQuery.inArray("COLOR", previewAuthor) !== -1 || jQuery.inArray("COLORIST", previewAuthor) !== -1){
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
    
    console.log('Device type:', isMobile ? 'Mobile' : 'Desktop');
    
    // Ensure video has all necessary attributes for autoplay
    video.muted = true;
    video.defaultMuted = true;
    video.volume = 0;
    video.setAttribute('muted', 'true');
    video.setAttribute('playsinline', 'true');
    video.setAttribute('webkit-playsinline', 'true');
    video.setAttribute('autoplay', 'true');
    
    // Set video source based on device
    if (isMobile) {
        video.src = 'home-new/mobilehomepreloadervideo.mp4';
        console.log('Set mobile video source');
    } else {
        video.src = 'home-new/homepreloadervideo.mp4';
        console.log('Set desktop video source');
    }
    
    // Force video to load with new source
    video.load();
    
    // Monitor video loading
    video.addEventListener('loadstart', function() {
        console.log('Video load started');
    });
    
    video.addEventListener('progress', function() {
        console.log('Video loading progress');
    });
    
    // Apply CSS fallback class only if video completely fails to load
    setTimeout(function() {
        if (!videoIsPlaying && !loaderHidden && video.networkState === 3) {
            console.log('Video failed to load - applying CSS fallback');
            $('#videoLoaderDiv').addClass('css-fallback');
        }
    }, 6000);
    
    // Function to hide loader and initialize gallery
    function hideLoaderAndInit() {
        if (loaderHidden) return; // Prevent multiple calls
        loaderHidden = true;
        
        // Clear any remaining timers
        if (globalFallbackTimer) {
            clearTimeout(globalFallbackTimer);
            globalFallbackTimer = null;
        }
        
        // Add fade out animation class before hiding
        $('#videoLoaderDiv').addClass('fallback-hide');
        
        setTimeout(function() {
            $('#videoLoaderDiv').hide();
            // Ensure main content is visible
            $('header .logo').fadeIn();
            $('header .menu').fadeIn();
            $('div.innerBody ul.heading').fadeIn(); 
            $('div.innerBody .allLists').fadeIn();
            
            // Initialize gallery if available
            if (typeof g_resize !== 'undefined') {
                g_resize(); 
            }
            if (typeof pgal !== 'undefined') {
                pgal.init(); 
            }
            
            // Check for additional content
            setTimeout(function(){
                var checkContentLoaded = setInterval(function() {
                    if ($('#gall').children().length>=120) {
                        if(typeof firstAnimationAutovideo !== 'undefined' && firstAnimationAutovideo){ 
                            clearInterval(checkContentLoaded);
                            $('.particles-gallery-videos video:nth-child(1)').removeAttr('data-bs-target');
                            $('.particles-gallery-videos video:nth-child(1)').click();
                            $('.particles-gallery-videos video:nth-child(1)').attr('data-bs-target','#videoModalPopup');
                            firstAnimationAutovideo=false;
                        }
                    }
                }, 100);
            }, 1500);
        }, 500); // Wait for fade animation
    }
    
    // Already set attributes above, no need to repeat

    // Handle video ended event - this is the normal path
    $(video).on('ended', function() {
        console.log('Video ended normally');
        videoIsPlaying = false;
        video.pause();
        hideLoaderAndInit();
    });
    
    // Track when video actually starts playing
    $(video).on('playing', function() {
        console.log('Video is playing - will wait for it to end');
        videoIsPlaying = true;
        // Clear the global fallback timer since video is playing
        if (globalFallbackTimer) {
            clearTimeout(globalFallbackTimer);
            globalFallbackTimer = null;
            console.log('Cleared fallback timer - video is playing');
        }
    });
    
    // Track video timeupdate to see progress
    $(video).on('timeupdate', function() {
        if (video.currentTime > 0 && !videoIsPlaying) {
            console.log('Video time updating:', video.currentTime);
            videoIsPlaying = true;
        }
    });

    // Handle video error event
    $(video).on('error', function(e) {
        console.log('Video loader error:', e);
        videoIsPlaying = false;
        if (globalFallbackTimer) clearTimeout(globalFallbackTimer);
        hideLoaderAndInit();
    });

    // Try to play the video
    function tryPlay() {
        console.log('Attempting to play video, readyState:', video.readyState, 'duration:', video.duration);
        
        // Attempt to play
        try {
            var playPromise = video.play();
            
            if (playPromise && typeof playPromise.then === 'function') {
                playPromise.then(function() {
                    // Video started playing successfully
                    console.log('Video playing successfully');
                    videoIsPlaying = true;
                    // Clear any fallback timers
                    if (globalFallbackTimer) {
                        clearTimeout(globalFallbackTimer);
                        globalFallbackTimer = null;
                    }
                    // Let video play to completion - ended event will hide loader
                }).catch(function(error) {
                    // Autoplay was prevented
                    console.log('Autoplay prevented:', error);
                    videoIsPlaying = false;
                    
                    // Set fallback to hide loader
                    setTimeout(function() {
                        if (!loaderHidden) {
                            console.log('Hiding loader after autoplay failure');
                            hideLoaderAndInit();
                        }
                    }, isMobile ? 1500 : 1000);
                });
            } else {
                // Older browser - just try to play
                console.log('No promise support - attempting play anyway');
            }
        } catch (e) {
            console.log('Error playing video:', e);
            // Hide loader on error
            setTimeout(function() {
                if (!loaderHidden) {
                    hideLoaderAndInit();
                }
            }, 1000);
        }
    }

    // Multiple attempts to play the video
    var playAttempted = false;
    
    // Check video state and try to play immediately if ready
    console.log('Initial video state - readyState:', video.readyState, 'networkState:', video.networkState);
    
    if (video.readyState >= 3) {
        console.log('Video ready immediately');
        tryPlay();
        playAttempted = true;
    } else {
        console.log('Waiting for video to load...');
    }
    
    // Wait for video to be ready
    video.addEventListener('canplay', function() {
        console.log('Video can play');
        if (!playAttempted) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    video.addEventListener('canplaythrough', function() {
        console.log('Video can play through');
        if (!playAttempted) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    // Also try on loadeddata
    video.addEventListener('loadeddata', function() {
        console.log('Video data loaded');
        if (!playAttempted && video.readyState >= 2) {
            tryPlay();
            playAttempted = true;
        }
    });
    
    // Try after a small delay if nothing else worked
    setTimeout(function() {
        if (!playAttempted && !loaderHidden) {
            console.log('Delayed play attempt');
            tryPlay();
            playAttempted = true;
        }
    }, 500);
    
    // Global fallback timer - ensures loader always hides eventually
    globalFallbackTimer = setTimeout(function() {
        if (!loaderHidden) {
            console.log('Global fallback - maximum wait reached');
            hideLoaderAndInit();
        }
    }, 8000); // 8 seconds maximum for all devices
});
});
// loader end
$(document).ready(function() {
    var $heading = $("div.innerBody ul.heading");
    var elementOffset = $heading.offset().top;
    var placeholder = $("<div></div>").hide().height($heading.outerHeight());

    // Insert the placeholder before the heading
    $heading.before(placeholder);

    $(window).scroll(function() {
        if ($(window).scrollTop() >= elementOffset) {
            placeholder.show(); // Show the placeholder to maintain layout
            $heading.addClass("fixed");
        } else {
            placeholder.hide(); // Hide the placeholder when not fixed
            $heading.removeClass("fixed");
        }
    });
    window.scrollTo(0, 0);
});
</script>
</body>
</html>