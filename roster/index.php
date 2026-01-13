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
    /* Preloader Styles */
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
	            <a href="/work/">ROSTER</a>
	            <!--<ol>-->
	            <!--   <li>-->
	            <!--        <a href="/roster/?page=EDITOR">Editor</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster/?page=GRIFFIN OLIS">Griffin Olis</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster/?page=ALEX PETERSON">Alex Peterson</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster/?page=DEVON SOLWOLD">Devon Solwold</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster/?page=ZACK PELLETIER">Zack Pelletier</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster/?page=COLORIST">Color</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster/?page=WILHENDS NORVIL">Wilhends Norvil</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster/?page=MIKE DE LA LUZ">Mike De La Luz</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster/?page=SOUND">Sound</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster/?page=DOUSON">Douson</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster/?page=VFX">VFX</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster/?page=JUMPER">Jumper</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--</ol>-->
	        </li>
	        <li>
	            <a href="/contact/">CONTACT</a>
	       </li>
	    </ul>
	</div> 
      </div> 
    </header>
  <div class="video-container">  
    <!-- EDITOR Videos -->
    <div class="video jamil-shaukat" data-longVideo="https://apollo.gosimian.com/share/v/-q-nJk-MzyUmkAPIljAdAw/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Look" data-videoSubName="Fantastic" data-credit="yes" data-credits="Post House: Ride The Lightning<br>Post Producer: Polly Ward <br>Director: Paddy McGowan<br>DP: Miguel Cármenes<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv2.jpg" src="videos/short/nv2.mp4" muted autoplay loop></video><label>Look Fantastic</label></div>
    <div class="video EDITOR" data-longVideo="https://apollo.gosimian.com/share/v/7w52-uK-KwO2eWCfwCEDjQ/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Ruroc" data-videoSubName="Berserker" data-credit="yes" data-credits="PRODUCTION:<br>Director: KC Locke<br>Executive Producer: KC Locke<br>Producer: Lewis Nicholson<br>Production Company: Swords & Eagles<br><br>APOLLO:<br>Editor: Jamil Shaukat"><video poster="videos/images/nv1.jpg" src="videos/short/nv1.mp4" muted autoplay loop></video><label>Ruroc - Berserker</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/Z_N4ZKx8zseoxuWWEO5J9A/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Drama Call" data-videoSubName="Heaviest in the Game" data-credit="yes" data-credits="Director: Rory A Wood<br>Production Company: Ant farm film services<br>DP: James Killeen<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv3.jpg" src="videos/short/nv3.mp4" muted autoplay loop></video><label>Drama Call - Heaviest in the Game</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/OoYHiz7arVaXh-_3xR3o7g/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="CP Company" data-videoSubName="Manchester City" data-credit="yes" data-credits="Director: Rory A Wood<br>Producer: Fin Mulligan Wild<br>Agency: LAW Magazine <br>Production Company: Antfarm <br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv4.jpg" src="videos/short/nv4.mp4" muted autoplay loop></video><label>CP Company x Manchester City</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/4QqEVVuhldXN_i8Bnr1ZYw/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Boohoo Man" data-videoSubName="World Cup" data-credit="yes" data-credits="Director: KC Locke <br>Producer: Lewis Nicholson <br>Production Company: Swords & Eagles<br>DP: Rowan Biddiscombe<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv5.jpg" src="videos/short/nv5.mp4" muted autoplay loop></video><label>Boohoo Man - World Cup</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/rfxS53q1G8VO6asIkOW-mg/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Meekz" data-videoSubName="Mini Me" data-credit="yes" data-credits="Director: KC Locke <br>Producer: Fin Mulligan Wild<br>Production Company: swordsandeagles<br>Executive Producers: KC Locke & Jenny O'Sullivan<br>DP: James Killeen<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv6.jpg" src="videos/short/nv6.mp4" muted autoplay loop></video><label>Meekz - Mini Me's </label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/7FWkr5CFwzqaqdHiwrvlww/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Ed Sheeran" data-videoSubName="Take Me Back To London feat. Stormzy, Jaykae & Aitch" data-credit="yes" data-credits="Director: KC Locke <br>Executive Producer: Gwil Doe<br>Producer: samona O Manoela Chiabai Gwil Doe<br>DP: Sam Meyer<br><br>Editor: JAMIL SHAUKAT"><video poster="videos/images/nv7.jpg" src="videos/short/nv7.mp4" muted autoplay loop></video><label>Ed Sheeran - Take Me Back To London feat. Stormzy, Jaykae & Aitch</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/qhF_Zr-_wpZEXebRRPM4YA/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Aitch" data-videoSubName="Learning Curve" data-credit="yes" data-credits="Director: KC LOCKE <br>Production Company: Swords & Eagles <br>Exec Producer/Directors: Rep Marisa Garner<br>DOP: Pieter Synman<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv8.jpg" src="videos/short/nv8.mp4" muted autoplay loop></video><label>Aitch - Learning Curve</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/L3HZIYNTMRPdQazo9r5jIQ/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="M Huncho & Headie One" data-videoSubName="Warzone" data-credit="yes" data-credits="Director: KC Locke<br>Producer: Lewis Nicholson<br>Production Company: Swords & Eagles <br>DOP: Matthew Emvin Taylor<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv9.jpg" src="videos/short/nv9.mp4" muted autoplay loop></video><label>M Huncho & Headie One - Warzone</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/e_xK1H4Fp-Y8rhQhkSCckA/false/auto/auto/ffffff/000000/" data-title="Jamil Shaukat" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="David Guetta" data-videoSubName="BEBE" data-credit="yes" data-credits="Director: KC Locke<br>Production Company: Swords & Eagles<br>DOP: Beatriz Sastre<br><br>Editor: Jamil Shaukat"><video poster="videos/images/nv10.jpg" src="videos/short/nv10.mp4" muted autoplay loop></video><label>David Guetta x BEBE</label></div>
    <div class="video liam-tangum" data-longVideo="https://apollo.gosimian.com/share/v/l4iJTcmvUc9kqSQ3mcktIA/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Oakely" data-videoSubName="Kylian Mbappe" data-credit="yes" data-credits="Creative and Production : Stept Studios<br>Producer: Alexa Hinson<br>Director: Joaquim Bayle<br>DP: Angelo Marques<br><br>Editor: LIAM TANGUM"><video poster="videos/images/nv11.jpg" src="videos/short/nv11.mp4" muted autoplay loop></video><label>Oakely - Kylian Mbappe</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/dV859sXWTPiERH5CF6iyTQ/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="RFM" data-videoSubName="Jeans" data-credit="yes" data-credits="Director: SOFIA CRISTINA ALVAREZ<br>Producer: MARLYN RODRIGUEZ<br><br>Editor: LIAM TANGUM"><video poster="videos/images/nv12.jpg" src="videos/short/nv12.mp4" muted autoplay loop></video><label>RFM Jeans</label></div>
    <div class="video brooks" data-longVideo="https://apollo.gosimian.com/share/v/2RyALL3vM1bbYlXn6hEOjQ/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Brooks" data-videoSubName="Sounds of Trail Running" data-credit="yes" data-credits="Production: Stept Studios<br>DP: Nash Howe Head of Post: Connor Scofield<br><br>Editor: Liam Tangum"><video poster="videos/images/nv13.jpg" src="videos/short/nv13.mp4" muted autoplay loop></video><label>Brooks - Sounds of Trail Running</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/0oRqHg7RMp9cRtecFGac4g/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Bevel" data-videoSubName="Kyle Pitts" data-credit="yes" data-credits="Director / DP: FRANKLIN RICART<br>Produced by: The Kitchen Table<br><br>Head of Post: Alex Peterson <br>Post Supervisor: Nasser Boulaich<br>Editor: Liam Tangum<br>Colorist: Brian Charles"><video poster="videos/images/nv14.jpg" src="videos/short/nv14.mp4" muted autoplay loop></video><label>Bevel - Kyle Pitts</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/QnNDO5jJPiweNaYkDbVNkQ/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Nowness" data-videoSubName="Short Film" data-credit="yes" data-credits="Director: Leo Pfeifer<br>Production Company: Alto Visuals<br><br>Editor: Liam Tangum"><video poster="videos/images/nv15.jpg" src="videos/short/nv15.mp4" muted autoplay loop></video><label>Nowness - Short Film</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/CmHy4CgsSoqo5K58skbxDw/false/auto/auto/ffffff/000000/" data-title="Liam Tangum" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="A Slice of Paradise" data-videoSubName="Short Film" data-credit="yes" data-credits="Director: Liam Tangum<br>Executive Producers: No Laying Up<br><br>Editors: Liam Tangum & Lindsay Wilkins"><video poster="videos/images/nv16.jpg" src="videos/short/nv16.mp4" muted autoplay loop></video><label>A Slice of Paradise - Short Film</label></div>
    <div class="video griffin-olis" data-longVideo="https://apollo.gosimian.com/share/v/1z2wxMuQOojv0_l3j_3BUA/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Adidas" data-videoSubName="Speed Juice" data-credit="yes" data-credits="Director: Danny Paul McNabb <br>Production Company: Resin projects<br>DP: Cory Burmester<br><br>Editor: Griffin Olis"><video poster="videos/images/nv17.jpg" src="videos/short/nv17.mp4" muted autoplay loop></video><label>Adidas - Speed Juice</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/hpcySoCWdlWWHzaW6P5WWA/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Fear of God" data-videoSubName=""><video poster="videos/images/nv18.jpg" src="videos/short/nv18.mp4" muted autoplay loop></video><label>Fear of God </label></div>
    <div class="video kai-cenat" data-longVideo="https://apollo.gosimian.com/share/v/n0LFcwPS9X72xQRkpvugzw/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Kai Cenat" data-videoSubName="Going Professional" data-credit="yes" data-credits="Production Company Black Screen Productions Inc<br>Director: Michael Daniel, Lachlan McClellan<br>Executive Producers: Monique Carrillo Michael Daniel<br>DP: Jonathan Charles<br><br>Editor: Griffin Olis"><video poster="videos/images/nv19.jpg" src="videos/short/nv19.mp4" muted autoplay loop></video><label>Kai Cenat - Going Professional</label></div>
    <div class="video under-armour" data-longVideo="https://apollo.gosimian.com/share/v/eHWf8zsSuiwys697NlDV3A/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Under Armour" data-videoSubName="Men Unstoppable Collection" data-credit="yes" data-credits="Director: Michael Kelly<br>Executive Producers/Parallel Studios: Tony Pillow Simon Chasalow<br>Lead Producer: Amanda Jones<br>DP: Cory Burmester<br><br>Head of Post: Alex Peterson<br>Post Supervisor: Chris Carson<br>Editor: Griffin Olis<br>Music: Jile<br>Sound Design: Ayo Douson"><video poster="videos/images/nv20.jpg" src="videos/short/nv20.mp4" muted autoplay loop></video><label>Under Armour - Men's Unstoppable Collection </label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/k84zVfx6eUANCz9rc-axFQ/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Kai Cenat" data-videoSubName="iShowSpeed" data-credit="yes" data-credits="Production Company: Black Screen Productions Inc<br>Director: Michael Daniel, Lachlan McClellan<br>Executive Producers: Monique Carrillo, Michael Daniel<br>DP: Jonathan Charles<br><br>Editor: Griffin Olis"><video poster="videos/images/nv21.jpg" src="videos/short/nv21.mp4" muted autoplay loop></video><label>Kai Cenat x iShowSpeed</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/5jtkQ-J-7bk3e1C4p_1hwQ/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="MLS & Apple TV" data-videoSubName="Beyond the Pitch - Episode 2" data-credit="yes" data-credits="Director: Don Newkirk Jr.<br>Executive Producers: Alex Peterson, Nate Loucks<br>Media Company: Boardroom<br>Production Co: Parallel Studios<br><br>Post Supervisor: Alex Peterson <br>Editor: Griffin Olis "><video poster="videos/images/MLS_Episode_2.png" src="videos/short/MLS_Episode_2.mp4" muted autoplay loop></video><label>MLS & Apple TV - Beyond the Pitch - Episode 2</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/_m2_Z8QG2n7FMj9u6qLWZA/false/auto/auto/ffffff/000000/" data-title="Griffin Olis" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="MLS & Apple TV" data-videoSubName="Beyond the Pitch - Episode 4" data-credit="yes" data-credits="Director: Don Newkirk Jr.<br>Executive Producers: Alex Peterson, Nate Loucks<br>Media Company: Boardroom<br>Production Co: Parallel Studios<br><br>Post Supervisor: Alex Peterson <br>Editor: Griffin Olis "><video poster="videos/images/MLS_Episode_4.png" src="videos/short/MLS_Episode_4.mp4" muted autoplay loop></video><label>MLS & Apple TV - Beyond the Pitch- Episode 4</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/hKEJPCvrM6F1f_D8m775gw/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Bodega" data-videoSubName="New Balance" data-credit="yes" data-credits="Director: NotTonightMike<br>Executive Producer: Alex Majher<br>Producer: Elizabeth Kraushaar<br>DP: Kai Dickson<br><br>Edit & Sound Design: Devon Solwold"><video poster="videos/images/nei1.png" src="videos/short/BodegaxNewBalance.mp4" muted autoplay loop></video><label>Bodega x New Balance</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/Kj037VYYf3TRWAyj2X9grw/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="OKEM" data-videoSubName="Short Film" data-credit="yes" data-credits="Director - Joshua Okwuosa<br>Cinematography - Kai Dickson<br>Producer - Elizabeth Kraushaar<br><br>Editor: Devon Solwold"><video poster="videos/images/nei2.png" src="videos/short/OKEM-Short Film.mp4" muted autoplay loop></video><label>OKEM - Short Film</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/MdBuv2VRG7aBrCpyi2NlzQ/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Eem Triplin" data-videoSubName="What Da Opp Said" data-credit="yes" data-credits="Director: Michael Kelly<br>Executive Producers: Tony Pillow, Simon Chasalow, Lucas Alexander<br>Producer: Nour Sayeh<br>Production Company: Parallel Studios<br>Post Supervisor: Alex Peterson<br>Edit & Sound Design: Devon Solwold<br>VFX: Ben Gillespie"><video poster="videos/images/nei3.png" src="videos/short/EemTriplinWhatDaOppSaid.mp4" muted autoplay loop></video><label>Eem Triplin - What Da Opp Said</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/OajoX7MS0eM11zx97Mov9Q/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Run that Shit!" data-videoSubName="Short Film" data-credit="yes" data-credits="EXECUTIVE PRODUCERS - Tristan Kim, Harrison Kracht<br>DIRECTOR - Tristan Kim<br>WRITTEN BY - Tristan Kim, Will Allyn Robinson<br>DP - Harrison Kracht<br><br>Edit, Sound, VFX: Devon Solwold"><video poster="videos/images/nei4.png" src="videos/short/RunthatShitShortFilm.mp4" muted autoplay loop></video><label>Run that Shit! Short Film</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/pnUrDJ8rUy0z_wgrQsLUPg/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="PURPLE DENIM" data-videoSubName="Daytrippin" data-credit="yes" data-credits="Studio: drinkadmilk<br>Producer: Alex Majher<br><br>Edit, Sound, VFX: Devon Solwold"><video poster="videos/images/nei5.png" src="videos/short/PURPLEDENIM-Daytrippin.mp4" muted autoplay loop></video><label>PURPLE DENIM - Daytrippin</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/tP8hab455lYbINecxlO4UA/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Bodega x G Shock" data-videoSubName="Anytime, Anywhere" data-credit="yes" data-credits="<h3>Apollo</h3><b>Edit & Sound Design: Devon Solwold</b><br><br><h3>Agency</h3><b>Agency: drinkadmilk</b><br><b>Director: Michael B Janey</b><br><b>Cinematographer: Kai Dickson</b>"><video poster="videos/short/bodega-g-shock-anytime-anywhere.png" src="videos/short/bodega-g-shock-anytime-anywhere.mp4" muted autoplay loop></video><label>Bodega x G Shock - Anytime, Anywhere</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/roJJm677DwOEfWAHUBszjw/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="$NOT feat. Zilla Kami" data-videoSubName="0 PERCENT" data-credit="yes" data-credits="<h3>Apollo</h3><b>Head of Post: Alex Peterson</b><br><b>Post Supervisor: Chris Carson</b><br><b>Editor: Devon Solwold & JMP</b><br><b>Sound Design: Devon Solwold</b><br><b>VFX: Auraj Raj</b><br><br><h3>Production</h3><b>Production Company: Paperwork</b><br><b>Director: JMP-James Pereira</b><br><b>Executive Producer: Joey Szela</b><br><b>Producer: ANDREW PERCIVAL</b><br><b>DP: Joel Wolt</b>"><video poster="videos/short/NOT-Ft-Zilla-Kami-0-PERCENT.png" src="videos/short/NOT-Ft-Zilla-Kami-0-PERCENT.mp4" muted autoplay loop></video><label>$NOT feat. Zilla Kami - 0 PERCENT</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/YfJ8EddylT5GPOKe8xi0hA/false/auto/auto/ffffff/000000/" data-title="DEVON SOLWOLD " data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="OnJuno Banking" data-videoSubName="Granny" data-credit="yes" data-credits="<h3>Apollo</h3><b>Editor: Devon Solwold</b><br><br><h3>Production</h3><b>Agency + Production: drinkadmilk</b><br><b>Writer/Director: Tristan Kim</b><br><b>Executive Producer: Alex Majher</b><br><b>Producer: Kevin Wall</b>"><video poster="videos/short/OnJunoBankingGranny.png" src="videos/short/OnJunoBankingGranny.mp4" muted autoplay loop></video><label>OnJuno Banking - Granny</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/18ZVg50By1N1CR9pvnKjhQ/false/auto/auto/ffffff/000000/" data-title="ZACK PELLETIER" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="NFLPA" data-videoSubName="Rookie of the Year 2023" data-credit="yes" data-credits="Creative agency/ Production company: OM Digital<br>Executive Producer: Dave Clark<br>Director: Julia Pitch<br>Producer: Sofie rhw<br><br>Editor: Zack Pelletier"><video poster="videos/images/nei6.png" src="videos/short/NFLPA-RookieoftheYear2023.mp4" muted autoplay loop></video><label>NFLPA - Rookie of the Year 2023</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/F-iBZ5QVpkJnpMEDcCBj0g/false/auto/auto/ffffff/000000/" data-title="ZACK PELLETIER" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="7uice" data-videoSubName="Vanson Leathers" data-credit="yes" data-credits="Director: Drew Cigna, & Medulla Media<br>DP: Thomas Marchese<br>Produced by: Parallel studios<br>Executive Producers: Simon Chasalow & Tony Pillow<br><br>Editor: ZACK PELLETIER"><video poster="videos/images/nei7.png" src="videos/short/7uicexVansonLeathers.mp4" muted autoplay loop></video><label>7uice x Vanson Leathers </label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/3uSaBKukVQFuCKZxqVRCpA/false/auto/auto/ffffff/000000/" data-title="ZACK PELLETIER" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Chris Brown" data-videoSubName="Nightmares" data-credit="yes" data-credits="DIRECTOR : Travis Colbert<br>PRODUCTION COMPANY : Projektstu<br>DP: Henri Taillon<br><br>EDITORS: Zack Pelletier & Henri Taillon & Travis Colbert<br>Colorist: Thomas Dauteuille"><video poster="videos/images/nei8.png" src="videos/short/ChrisBrownNightmares.mp4" muted autoplay loop></video><label>Chris Brown - Nightmares</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/s7w_utug7_nyaoW0tp05cw/false/auto/auto/ffffff/000000/" data-title="ZACK PELLETIER" data-author="EDITOR" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Louis the Child" data-videoSubName="How High" data-credit="yes" data-credits="Director: Drew Cigna<br>Executive Producer: Simon Chasalow & Tony Pillow<br>Production CO: Parallel Studios <br>DP: Owen Schatz  Drew Cigna<br><br>Post Supervisor: Alex Peterson <br>Editor: Zack Pelletier"><video poster="videos/images/nei9.png" src="videos/short/LouistheChildHowHigh.mp4" muted autoplay loop></video><label>Louis the Child - How High</label></div> 

    <!-- COLORIST Videos -->
    <div class="video COLORIST wilhends-norvil" data-longVideo="https://apollo.gosimian.com/share/v/4A_9ELDRtpep6cFAj6oKHQ/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil"  data-prev1="images/colorist/bridge1.jpg" data-prev2="images/colorist/bridge2.jpg" data-prev3="images/colorist/bridge3.jpg" data-prev4="images/colorist/bridge4.jpg" data-prev5="images/colorist/bridge5.jpg" data-prev6="images/colorist/bridge6.jpg" data-author="COLORIST" data-videoName="BRIDGE" data-videoSubName="Fate Loves Irony" data-credit="yes" data-credits="Director: Nicolas Manterola<br>DOP: Kai Dickson <br>Executive Producers: Simon Chasalow & Tony Pillow<br>Production Company: Parallel Studios<br><br>Colorist: Wilhends Norvil<br>Color Producer: Christopher Carson"><video poster="videos/images/cnv10.png" src="videos/short/cnv10.mp4" muted autoplay loop></video><label>BRIDGE - Fate Loves Irony</label></div>
    <div class="video wilhends-norvil" data-longVideo="https://apollo.gosimian.com/share/v/uft9UnysoZEtFBFpQsDbwA/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil"  data-prev1="images/colorist/EO1.jpg" data-prev2="images/colorist/EO2.jpg" data-prev3="images/colorist/EO3.jpg" data-prev4="images/colorist/EO4.jpg" data-prev5="images/colorist/EO5.jpg" data-prev6="images/colorist/EO6.jpg" data-author="COLORIST" data-videoName="SKUFL" data-videoSubName="Eyes Open" data-credit="yes" data-credits="Director: Nasser Boulaich<br><br>Post Supervisor: Alex Peterson <br>Editor: Nasser Boulaich<br>Colorist: Wilhends Norvil<br>Color Producer: Christopher Carson"><video poster="videos/images/SKUFL_Eyes_Open.png" src="videos/short/SKUFL_Eyes_Open.mp4" muted autoplay loop></video><label>SKUFL - Eyes Open</label></div>
    <div class="video wilhends-norvil" data-longVideo="https://apollo.gosimian.com/share/v/X9KW-za1rOfAhEgrYOvm-w/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil"  data-prev1="images/colorist/penderdyn1.jpg" data-prev2="images/colorist/penderdyn2.jpg" data-prev3="images/colorist/penderdyn3.jpg" data-prev4="images/colorist/penderdyn4.jpg" data-prev5="images/colorist/penderdyn5.jpg" data-prev6="images/colorist/penderdyn6.jpg" data-author="COLORIST" data-videoName="Penderdyn" data-videoSubName="Distillery" data-credit="yes" data-credits="Director: Keirana Scott<br>Production: neufcinq films<br><br>Colorist: Wilhends Norvil"><video poster="videos/images/Penderdyn_Distillery.png" src="videos/short/Penderdyn_Distillery.mp4" muted autoplay loop></video><label>Penderdyn Distillery</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/H5tTgamoIVgf6fzFoGJQpw/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil"  data-prev1="images/colorist/Doritos1.jpg" data-prev2="images/colorist/Doritos2.jpg" data-prev3="images/colorist/Doritos3.jpg" data-prev4="images/colorist/Doritos4.jpg" data-prev5="images/colorist/Doritos5.jpg" data-prev6="images/colorist/Doritos6.jpg" data-author="COLORIST" data-videoName="Doritos Crash" data-videoSubName="Abduction" data-credit="yes" data-credits="Directors: Dylan Bradshaw & Nate Norell<br>DP: Dave Cortez<br><br>Colorist: Wilhends Norvil<br>Post Producer: Christopher Carson"><video poster="videos/images/Doritos_Crash_Abduction.png" src="videos/short/Doritos_Crash_Abduction.mp4" muted autoplay loop></video><label>Doritos Crash - Abduction</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/PzDWbmEJugKJNNnO65K_nA/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil"  data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-author="COLORIST" data-videoName="Bravest Studios" data-videoSubName="Kid Cudi" data-credit="yes" data-credits="Director / Creative Director: Brenton L Roberson<br>Line Producer: Brenton L Roberson<br><br>Post Supervisor: Alex Peterson<br>VFX: Jack Phoenix<br>Colorist: Wilhends Norvil"><video poster="videos/images/Bravest_Studios.png" src="videos/short/Bravest_Studios.mp4" muted autoplay loop></video><label>Bravest Studios x Kid Cudi</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/6o9ZK0-x4F_sclY3QNmfnQ/false/auto/auto/ffffff/000000/" data-title="Wilhends Norvil" data-author="COLORIST" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Movado" data-videoSubName="Bold Evolution 2.0" data-credit="yes" data-credits="<h3>Apollo</h3><b>Post Producer: Alex Peterson</b><br><b>Post Supervisor: Christopher Carson</b><br><b>Editor: Devon Solwold</b><br><b>Colorist: Wilhends Norvil</b><br><b>Sound Design: Douson Yuan</b><br><br><h3>Agency</h3><b>Agency: uvtagency</b>"><video poster="videos/short/MovadoBoldEvolution2.png" src="videos/short/MovadoBoldEvolution2.mp4" muted autoplay loop></video><label>Movado - Bold Evolution 2.0</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/xF13CxnZT2MHWaGAkmN4ww/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Rema LOTUS 1.jpg" data-prev2="/roster/images/colorist/Rema LOTUS 2.jpg" data-prev3="/roster/images/colorist/Rema LOTUS 3.jpg" data-prev4="/roster/images/colorist/Rema LOTUS 4.jpg" data-prev5="/roster/images/colorist/Rema LOTUS 5.jpg" data-prev6="/roster/images/colorist/Rema LOTUS 6.jpg" data-videoName="Rema" data-videoSubName="Outlander - LOTUS"><video poster="videos/short/Rema - Outlander - LOTUS Cover.mp4" src="videos/short/Rema - Outlander - LOTUS Cover.mp4" muted autoplay loop></video><label>Rema - Outlander - LOTUS</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/1b1_50VRFm0EcdS7sVq-vQ/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Walmart 1.jpg" data-prev2="/roster/images/colorist/Walmart 2.jpg" data-prev3="/roster/images/colorist/Walmart 3.jpg" data-prev4="/roster/images/colorist/Walmart 4.jpg" data-prev5="/roster/images/colorist/Walmart 5.jpg" data-prev6="/roster/images/colorist/Walmart 6.jpg" data-videoName="Walmart" data-videoSubName="Beach"><video poster="videos/short/walmart cover.mp4" src="videos/short/walmart cover.mp4" muted autoplay loop></video><label>Walmart Beach</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/e62d0mNOWW3pXvTB4RNbaw/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Belair 1.jpg" data-prev2="/roster/images/colorist/Belair 2.jpg" data-prev3="/roster/images/colorist/Belair 3.jpg" data-prev4="/roster/images/colorist/Belair 4.jpg" data-prev5="/roster/images/colorist/Belair 5.jpg" data-prev6="/roster/images/colorist/Belair 6.jpg" data-videoName="Belair" data-videoSubName="Athletics"><video poster="videos/short/belair athletics new.mp4" src="videos/short/belair athletics new.mp4" muted autoplay loop></video><label>Belair Athletics</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/agPXRdGNYFEeg00hZHvlmw/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Vertigo 1.jpg" data-prev2="/roster/images/colorist/Vertigo 2.jpg" data-prev3="/roster/images/colorist/Vertigo 3.jpg" data-prev4="/roster/images/colorist/Vertigo 4.jpg" data-prev5="/roster/images/colorist/Vertigo 5.jpg" data-prev6="/roster/images/colorist/Vertigo 6.jpg" data-videoName="Duckwrth" data-videoSubName="Vertigo"><video poster="videos/short/Vertigo Cover.mp4" src="videos/short/Vertigo Cover.mp4" muted autoplay loop></video><label>Duckwrth - Vertigo</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/1gfWca1v7qeuo30U0tN6EA/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/meta saquan 1.jpg" data-prev2="/roster/images/colorist/meta saquan 2.jpg" data-prev3="/roster/images/colorist/meta saquan 3.jpg" data-prev4="/roster/images/colorist/meta saquan 4.jpg" data-prev5="/roster/images/colorist/meta saquan 5.jpg" data-prev6="/roster/images/colorist/meta saquan 6.jpg" data-videoName="Meta Quest" data-videoSubName="Offset"><video poster="videos/short/meta quest offset.mp4" src="videos/short/meta quest offset.mp4" muted autoplay loop></video><label>Meta Quest - Offset</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/LOgECzH1piP0HpOvWHB50w/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Elephant 1.jpg" data-prev2="/roster/images/colorist/Elephant 2.jpg" data-prev3="/roster/images/colorist/Elephant 3.jpg" data-prev4="/roster/images/colorist/Elephant 4.jpg" data-prev5="/roster/images/colorist/Elephant 5.jpg" data-prev6="/roster/images/colorist/Elephant 6.jpg" data-videoName="Tommy Richman" data-videoSubName="Elephant in the Room"><video poster="videos/short/Tommy Richman - Elephant Covers.mp4" src="videos/short/Tommy Richman - Elephant Covers.mp4" muted autoplay loop></video><label>Tommy Richman - Elephant in the Room</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/HmR1n4iJqvPcP-fVDBwfgA/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Arcteryx 1.jpg" data-prev2="/roster/images/colorist/Arcteryx 2.jpg" data-prev3="/roster/images/colorist/Arcteryx 3.jpg" data-prev4="/roster/images/colorist/Arcteryx 4.jpg" data-prev5="/roster/images/colorist/Arcteryx 5.jpg" data-prev6="/roster/images/colorist/Arcteryx 6.jpg" data-videoName="Arcteryx" data-videoSubName=""><video poster="videos/short/Arcteryx Cover New.mp4" src="videos/short/Arcteryx Cover New.mp4" muted autoplay loop></video><label>Arcteryx</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/BuQLAccOTNWLrBVmdRdZDw/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Indio 1.jpg" data-prev2="/roster/images/colorist/Indio 2.jpg" data-prev3="/roster/images/colorist/Indio 3.jpg" data-prev4="/roster/images/colorist/Indio 4.jpg" data-prev5="/roster/images/colorist/Indio 5.jpg" data-prev6="/roster/images/colorist/Indio 6.jpg" data-videoName="EvenOdd" data-videoSubName="Remezcla - Cerveza Indio"><video poster="videos/short/indio cover.mp4" src="videos/short/indio cover.mp4" muted autoplay loop></video><label>EvenOdd - Remezcla - Cerveza Indio</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/sDbEXGV9oa47wSXerMXvNA/false/auto/auto/ffffff/000000/" data-title="Avery Niles" data-author="COLORIST" data-credit="yes" data-credits="Colorist: Avery Niles" data-prev1="/roster/images/colorist/Rare Beauty 1.jpg" data-prev2="/roster/images/colorist/Rare Beauty 2.jpg" data-prev3="/roster/images/colorist/Rare Beauty 3.jpg" data-prev4="/roster/images/colorist/Rare Beauty 4.jpg" data-prev5="/roster/images/colorist/Rare Beauty 5.jpg" data-prev6="/roster/images/colorist/Rare Beauty 6.jpg" data-videoName="Rare Beauty" data-videoSubName="Summer 2025"><video poster="videos/short/Rare beauty cover.mp4" src="videos/short/Rare beauty cover.mp4" muted autoplay loop></video><label>Rare Beauty - Summer 2025</label></div>

    <!-- SOUND Videos -->
    <div class="video SOUND ayo-douson" data-longVideo="https://apollo.gosimian.com/share/v/9cOJ5PfnvPgZdbZlzrsBjg/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="The Weeknd" data-videoSubName="São Paulo Recap" data-credit="yes" data-credits="Director: Evan Larsen<br>Concert Creative Direction: Lamar C Taylor<br>Concert Visual CGI: Alexander Wessely<br><br>Sounds Design: Ayo Douson"><video poster="videos/images/nv22.jpg" src="videos/short/nv22.mp4" muted autoplay loop></video><label>The Weeknd - São Paulo Recap</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/qKQRRSXRh6LpERHQK9gdgg/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="F1" data-videoSubName="Miami" data-credit="yes" data-credits="Directed By: B Cruz  x KENDRI RODRIGUEZ<br>Executive Producer: B Cruz<br>Producer: KENDRI RODRIGUEZ<br><br><br>Sound Design: Ayo Douson"><video poster="videos/images/nv23.jpg" src="videos/short/nv23.mp4" muted autoplay loop></video><label>F1 Miami</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/aArPD9VVhawRT4mQlsymUg/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="A$AP Rocky" data-videoSubName="Riot" data-credit="yes" data-credits="Directed by Asap Rocky & Chris Villa <br>Sound Design: Ayo Douson"><video poster="videos/images/nv24.jpg" src="videos/short/nv24.mp4" muted autoplay loop></video><label>A$AP Rocky - Riot</label></div>
    <div class="video new-balance" data-longVideo="https://apollo.gosimian.com/share/v/_cBrDrn0LQod1q6m8cml6A/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="New Balance" data-videoSubName="Prosperity Be the Prize" data-credit="yes" data-credits="Directed by: NAT PRINZI<br>Production Company: Better Days<br>Executive Producer: NAT PRINZI<br><br><br>Sounds Design: Ayo Douson"><video poster="videos/images/nv25.jpg" src="videos/short/nv25.mp4" muted autoplay loop></video><label>New Balance - Prosperity Be the Prize</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/kF2Fh2X7DUalIDti0akahg/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Lil Tecca" data-videoSubName="Plan A" data-credit="yes" data-credits="Sounds Design: Ayo Douson"><video poster="videos/images/nv26.jpg" src="videos/short/nv26.mp4" muted autoplay loop></video><label>Lil Tecca - Plan A </label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/m-gW5HkJcJDTh1vFpWzaSQ/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="AB Soul" data-videoSubName="Soul Burger" data-credit="yes" data-credits="Sounds Design: Ayo Douson"><video poster="videos/images/nv27.jpg" src="videos/short/nv27.mp4" muted autoplay loop></video><label>AB Soul - Soul Burger </label></div>
    <div class="video terrace-martin" data-longVideo="https://apollo.gosimian.com/share/v/mk71YHvlAjqKmE2SMuihew/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Terrace Martin" data-videoSubName="Paradise" data-credit="yes" data-credits="Director: child.<br>Executive Producer: Galileo Mondol <br>Executive Producer: Lopes<br>Producer: Tashi Bhutia <br><br>Sounds Design: Ayo Douson"><video poster="videos/images/nv28.jpg" src="videos/short/nv28.mp4" muted autoplay loop></video><label>Terrace Martin - Paradise</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/1ny7tHXPskhTuu7soraYkw/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Cadence" data-videoSubName="" data-credit="yes" data-credits="Director: Nick Buska<br>Producers: Sydnyfuruichi Brentassayag<br>Production Co: Anno<br>DOPs: Cory Burmester & MASON K PRENDERGAST<br><br>Sound Design: Ayo Douson & Ken Psalms & "><video poster="videos/images/nv29.jpg" src="videos/short/nv29.mp4" muted autoplay loop></video><label>Cadence</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/i13UKcOr269oMWvZjEk6hg/false/auto/auto/ffffff/000000/" data-title="Ayo Douson" data-author="SOUND" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Chris Brown" data-videoSubName="Hmmm (Official Video) feat. Davido" data-credit="yes" data-credits="Director / Executive Producer: Travis Colbert <br>Executive Producer: Samuel King <br>Production Company: Projekt Studios<br><br>Post Supervisor: Zack Pelletier<br>Editor: Alex Peterson<br>VFX: Le Jumper<br>Sound Design: Ayo Douson<br>Colorist: Thomas Dautueil<br>Sound Producer: Sean Carroll"><video poster="videos/images/ChrisBrown-Hmmm.jpg" src="videos/short/ChrisBrown-Hmmm.mp4" muted autoplay loop></video><label>Chris Brown - Hmmm (Official Video) feat. Davido</label></div>

    <!-- VFX Videos -->
    <div class="video VFX ben-gillespie" data-longVideo="https://apollo.gosimian.com/share/v/eq-VBZ1e5JqStnRWV8oS_w/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Fortrock" data-videoSubName=""><video poster="videos/images/nv30.jpg" src="videos/short/nv30.mp4" muted autoplay loop></video><label>Fortrock</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/-0HDXbViKWXNq8RIzvPdcA/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Garmin Watch" data-videoSubName="" data-credit="yes" data-credits="Production Company: Fortem<br><br>VFX Artist: Ben Gillespie"><video poster="videos/images/nv31.jpg" src="videos/short/nv31.mp4" muted autoplay loop></video><label>Garmin Watch</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/k62H4kkopEBX7_P3JK1jlA/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Happytown" data-videoSubName="Promo" data-credit="yes" data-credits="VFX Artist: Ben Gillespie"><video poster="videos/images/nv32.jpg" src="videos/short/nv32.mp4" muted autoplay loop></video><label>Happytown Promo</label></div>
    <div class="video the-north-face" data-longVideo="https://apollo.gosimian.com/share/v/NKUOtAvy-_d2e9dCv-bB5A/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="The North Face" data-videoSubName="Fall/Winter 2024" data-credit="yes" data-credits="Producer: Will Beihoffer<br>Director/DP: Cole Pates<br><br>VFX Artist: Ben Gillespie"><video poster="videos/images/nv33.jpg" src="videos/short/nv33.mp4" muted autoplay loop></video><label>The North Face - Fall/Winter 2024</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/LIvr2NNxajOp1WeUZWER0w/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Arqui Vistas" data-videoSubName="" data-credit="yes" data-credits="VFX Artist: Ben Gillespie"><video poster="videos/images/nv34.jpg" src="videos/short/nv34.mp4" muted autoplay loop></video><label>Arqui Vistas</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/6jqEx2rQsXxfcIoiabqIvw/false/auto/auto/ffffff/000000/" data-title="Ben Gillespie" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Guiness" data-videoSubName="The Most Wonderful Pint of the Year" data-credit="yes" data-credits="<h3>Apollo</h3><b>Editor: Alex Peterson</b><br><b>VFX Artist: Ben Gillespie</b><br><b>Sound Design: Ayo Douson</b><br><b>Colorist: Brian Charles</b><br><br><h3>Production</h3><b>Creative: Taylor Agency</b><br><b>DP: Jon Cospito</b>"><video poster="videos/short/ben-gillespie-guiness.png" src="videos/short/ben-gillespie-guiness.mp4" muted autoplay loop></video><label>Guiness - The Most Wonderful Pint of the Year</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/X8Zz1QOwA-VG9plVIAN_1Q/false/auto/auto/ffffff/000000/" data-title="Le Jumper" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="When We Die" data-videoSubName="Yung Blud feat. Lil Yachty" data-credit="yes" data-credits="<h3>Apollo</h3><b>VFX: Le Jumper</b><br><br><h3>Production</h3><b>Directed by: Logan Fields & Yussef Haridy</b><br><b>Executive Producers: Michael Kelly, Tony Pillow, Simon Chasalow</b><br><b>Producer: William Hickox</b><br><b>Production Company: Parallel Studios</b>"><video poster="videos/short/when-we-die-le-jumper.png" src="videos/short/when-we-die-le-jumper.mp4" muted autoplay loop></video><label>When We Die - Yung Blud feat. Lil Yachty</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/cU9FNVgBO8eQYBXByLyyXw/false/auto/auto/ffffff/000000/" data-title="Le Jumper" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Chris Brown" data-videoSubName="Residuals" data-credit="yes" data-credits="<h3>Apollo</h3><b>Head of Post: Alex Peterson</b><br><b>Post Supervisor: Lynn He</b><br><b>Editor: Zack Pelletier</b><br><b>Edit Producer: Nasser Boulaich</b><br><b>Colorist: Houmam Abdallah</b><br><b>3D Artist: Le Jumper</b><br><b>Sound Design: Ayo Douson</b><br><br><h3>Production</h3><b>Director: TRAVIS COLBERT</b><br><b>Producer: SAMUEL KING </b><br><b>Executive Producer / CD: TRAVIS COLBERT & SAM KING</b><br><b>Production Company: PROJEKT STUDIOS</b>"><video poster="videos/short/ChrisBrownNightmares.png" src="videos/short/chris-brown-nightmares-le-jumper.mp4" muted autoplay loop></video><label>Chris Brown - Residuals</label></div>
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/P_xhBd9YvodngKBvTLwp3g/false/auto/auto/ffffff/000000/" data-title="Le Jumper" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Jaylen Brown" data-videoSubName="741 Performance" data-credit="yes" data-credits="Director: Drew Cigna<br>CD: Shawn Plata<br>DP: Drew Cigna<br>Executive Producers: Shawn Plata & Energy Shifter<br><br>Edit/VFX/Sound: Le Jumper"><video poster="videos/images/nv35.jpg" src="videos/short/nv35.mp4" muted autoplay loop></video><label>Jaylen Brown - 741 Performance</label></div> 
    <div class="video" data-longVideo="https://apollo.gosimian.com/share/v/TPBRLF-RNvz4AyMzX4KzRw/false/auto/auto/ffffff/000000/" data-title="Le Jumper" data-author="VFX" data-prev1="" data-prev2="" data-prev3="" data-prev4="" data-prev5="" data-prev6="" data-videoName="Shakira" data-videoSubName="Grammy's Short Film" data-credit="yes" data-credits="<h3>Apollo</h3><b>VFX: Le Jumper</b><br><br><h3>Production</h3><b>Production Company: Fulwell</b>"><video poster="videos/short/Shakira - Grammy's Short Film.png" src="videos/short/Shakira - Grammy's Short Film .mp4" muted autoplay loop></video><label>Shakira - Grammy's Short Film</label></div>
  </div> 
  
  <div class="editorsMain editorsLeftMain">
        <ul class="editorsLeft editors">
            <li><a></a></li>
            <li class="active" data-start=00><a>EDIT</a></li>
            <li data-start=037><a>COLOR</a></li>
            <li data-start=052><a>SOUND</a></li>
            <li data-start=056><a>VFX</a></li>
        </ul>
    </div>
    
    <div class="editorsMain editorsRightMain">
        <ul class="editorsRight editors EditorGroupUL">
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li class="active" data-start=0><a>Jamil Shaukat</a></li>  
            <li data-start=10><a>Liam Tangum</a></li>
            <li data-start=16><a>Griffin Olis</a></li>
            <li data-start=23><a>Devon Solwold</a></li>
            <li data-start=31><a>Zack Pelletier</a></li>
            <li data-start=36><a>Wilhends Norvil</a></li>
            <li data-start=42><a>Avery Niles</a></li>
            <li data-start=51><a>Ayo Douson</a></li>
            <li data-start=60><a>Ben Gillespie</a></li>
            <li data-start=66><a>Le Jumper</a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
            <li><a></a></li>
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script>
        // Preloader function
        function showPreloader() {
            $('#videoPreloader').css('display', 'flex').removeClass('fade-out').addClass('fade-in');
        }
        
        function hidePreloader() {
            $('#videoPreloader').removeClass('fade-in').addClass('fade-out');
            setTimeout(function() {
                $('#videoPreloader').css('display', 'none');
            }, 300); // Wait for fade-out animation to complete
        }
        
        function navigateToVideo(targetVideo, offset = null) {
            if (targetVideo.length) {
                showPreloader();
                // Scroll immediately while preloader is covering the screen
                setTimeout(function() {
                    // Calculate dynamic offset to center video vertically
                    var viewportHeight = $(window).height();
                    var videoElement = targetVideo[0];
                    var videoHeight = videoElement.offsetHeight;
                    var videoTop = targetVideo.offset().top;
                    
                    // Calculate position to center video in viewport (with slight downward adjustment for better visual balance)
                    var centerOffset = (viewportHeight - videoHeight) / 2;
                    var visualAdjustment = viewportHeight * 0.11; // Push down by 30% of viewport height for better visual centering
                    var scrollPosition = videoTop - centerOffset - visualAdjustment;
                    
                    // Ensure we don't scroll above the top of the page
                    scrollPosition = Math.max(0, scrollPosition);
                    
                    window.scrollTo(0, scrollPosition);
                    // Keep preloader visible for a bit longer after scrolling
                    setTimeout(function() {
                        hidePreloader();
                    }, 800);
                }, 50); // Very short delay to ensure preloader is fully visible
            }
        }

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

        $(document).on('click', 'ul.editorsLeft.editors li', function() {
            var $clickedLi = $(this);
            var category = $clickedLi.find('a').text();

            if (category) {
                var author = category.toUpperCase();
                if (author === 'COLOR') {
                    author = 'COLORIST';
                }

                $('div.editorsMain ul.editorsRight li').removeClass('active');
                if (author === 'EDITOR') {
                    $('div.editorsMain ul.editorsRight li[data-start="0"]').addClass('active');
                    $('div.insideHeader div.menuRight h4.authorsNames').text('Jamil Shaukat');
                } else if (author === 'COLORIST') {
                    $('div.editorsMain ul.editorsRight li[data-start="36"]').addClass('active');
                    $('div.insideHeader div.menuRight h4.authorsNames').text('Wilhends Norvil');
                } else if (author === 'SOUND') {
                    $('div.editorsMain ul.editorsRight li[data-start="51"]').addClass('active');
                    $('div.insideHeader div.menuRight h4.authorsNames').text('Ayo Douson');
                } else if (author === 'VFX') {
                    $('div.editorsMain ul.editorsRight li[data-start="60"]').addClass('active');
                    $('div.insideHeader div.menuRight h4.authorsNames').text('Ben Gillespie');
                }

                var targetVideo;
                switch (author) {
                    case 'EDITOR':
                        // Prioritize videos with proper CSS classes, fallback to first match
                        targetVideo = $('.video-container .video.EDITOR[data-author="' + author + '"]').first();
                        if (targetVideo.length === 0) {
                            targetVideo = $('.video-container .video[data-author="' + author + '"]').first();
                        }
                        navigateToVideo(targetVideo);
                        break;
                    case 'COLORIST':
                        targetVideo = $('.video-container .video.COLORIST[data-author="' + author + '"]').first();
                        if (targetVideo.length === 0) {
                            targetVideo = $('.video-container .video[data-author="' + author + '"]').first();
                        }
                        navigateToVideo(targetVideo);
                        break;
                    case 'SOUND':
                        targetVideo = $('.video-container .video.SOUND[data-author="' + author + '"]').first();
                        if (targetVideo.length === 0) {
                            targetVideo = $('.video-container .video[data-author="' + author + '"]').first();
                        }
                        navigateToVideo(targetVideo);
                        break;
                    case 'VFX':
                        targetVideo = $('.video-container .video.VFX[data-author="' + author + '"]').first();
                        if (targetVideo.length === 0) {
                            targetVideo = $('.video-container .video[data-author="' + author + '"]').first();
                        }
                        navigateToVideo(targetVideo);
                        break;
                }
            }
        });

        $(document).on('click', 'ul.editorsRight.editors li', function() {
            var artistName = $(this).find('a').text().trim();
            if (artistName) {
                // Create a CSS class-friendly version of the artist name
                var artistClass = artistName.toLowerCase().replace(/\s+/g, '-');
                
                // First try to find video with specific artist class
                var targetVideo = $('.video-container .video.' + artistClass).filter(function() {
                    return $(this).data('title').trim().toLowerCase() === artistName.toLowerCase();
                }).first();
                
                // If not found, fallback to any video with matching title
                if (targetVideo.length === 0) {
                    targetVideo = $('.video-container .video').filter(function() {
                        return $(this).data('title').trim().toLowerCase() === artistName.toLowerCase();
                    }).first();
                }

                navigateToVideo(targetVideo);
            }
        });

        setTimeout(() => {
            window.scrollTo(0, 320);
            handleScroll();
            $('ul.editorsLeft.editors li').removeClass('active');
            $('ul.editorsLeft.editors li[data-start="00"]').addClass('active');
            $('ul.editorsLeft.editors').animate({ scrollTop: 8 }, 0);
            $('div.editorsMain ul.editorsRight li').removeClass('active');
            $('div.editorsMain ul.editorsRight li[data-start="0"]').addClass('active');
            $('ul.editorsRight.editors.EditorGroupUL').animate({ scrollTop: 1 }, 0);
            
            <?php if(isset($_GET['video']) && $_GET['video']=='terrace-martin'){ ?>
                navigateToVideo($(".video-container div.video.terrace-martin"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='under-armour'){ ?>
                navigateToVideo($(".video-container div.video.under-armour"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='clairo'){ ?>
                navigateToVideo($(".video-container div.video.clairo"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='new-balance'){ ?>
                navigateToVideo($(".video-container div.video.new-balance"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='kai-cenat'){ ?>
                navigateToVideo($(".video-container div.video.kai-cenat"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='the-north-face'){ ?>
                navigateToVideo($(".video-container div.video.the-north-face"));
            <?php } ?>
            <?php if(isset($_GET['video']) && $_GET['video']=='brooks'){ ?>
                navigateToVideo($(".video-container div.video.brooks"));
            <?php } ?>
            
            <?php if(isset($_GET['author']) && $_GET['author']=='EDITOR'){ ?>
                navigateToVideo($(".video-container div.video.EDITOR").first());
            <?php } ?>
            <?php if(isset($_GET['author']) && $_GET['author']=='COLORIST'){ ?>
                navigateToVideo($(".video-container div.video.COLORIST"));
            <?php } ?>
            <?php if(isset($_GET['author']) && $_GET['author']=='VFX'){ ?>
                navigateToVideo($(".video-container div.video.VFX"));
            <?php } ?>
            <?php if(isset($_GET['author']) && $_GET['author']=='SOUND'){ ?>
                navigateToVideo($(".video-container div.video.SOUND"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Jamil Shaukat'){ ?>
                navigateToVideo($(".video-container div.video.jamil-shaukat").first());
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Liam Tangum'){ ?>
                navigateToVideo($(".video-container div.video.liam-tangum"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Griffin Olis'){ ?>
                navigateToVideo($(".video-container div.video.griffin-olis"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Wilhends Norvil'){ ?>
                navigateToVideo($(".video-container div.video.wilhends-norvil"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Ayo Douson'){ ?>
                navigateToVideo($(".video-container div.video.ayo-douson"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Ben Gillespie'){ ?>
                navigateToVideo($(".video-container div.video.ben-gillespie"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Le Jumper'){ ?>
                navigateToVideo($(".video-container div.video.le-jumper"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Devon Solwold'){ ?>
                navigateToVideo($('.video-container .video').filter(function() { return $(this).data('title').trim().toLowerCase() === 'devon solwold'; }).first());
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Zack Pelletier'){ ?>
                navigateToVideo($('.video-container .video').filter(function() { return $(this).data('title').trim().toLowerCase() === 'zack pelletier'; }).first());
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Wilhends Norvil'){ ?>
                navigateToVideo($(".video-container div.video.wilhends-norvil"));
            <?php } ?>
            <?php if(isset($_GET['writer']) && $_GET['writer']=='Avery Niles'){ ?>
                navigateToVideo($('.video-container .video').filter(function() { return $(this).data('title').trim() === 'Avery Niles'; }).first());
            <?php } ?>
            
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
                if (scale > 1.2) {
                    const currentAuthor = video.getAttribute("data-author"); 
                    const currentTitle = video.getAttribute("data-title");
                    if (currentAuthor === 'EDITOR') {
                        $('ul.editorsLeft.editors li').removeClass('active');
                        $('ul.editorsLeft.editors li[data-start="00"]').addClass('active');
                    }
                    if (currentAuthor === 'COLORIST') {
                        $('ul.editorsLeft.editors li').removeClass('active');
                        $('ul.editorsLeft.editors li[data-start="037"]').addClass('active');
                    }
                    if (currentAuthor === 'SOUND') {
                        $('ul.editorsLeft.editors li').removeClass('active');
                        $('ul.editorsLeft.editors li[data-start="052"]').addClass('active');
                    }
                    if (currentAuthor === 'VFX') {
                        $('ul.editorsLeft.editors li').removeClass('active');
                        $('ul.editorsLeft.editors li[data-start="056"]').addClass('active');
                    }
                    if (currentTitle === 'Jamil Shaukat') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="0"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Jamil Shaukat');
                    }
                    if (currentTitle === 'Liam Tangum') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="10"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Liam Tangum');
                    }
                    if (currentTitle === 'Griffin Olis') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="16"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Griffin Olis');
                    }
                    if (currentTitle === 'DEVON SOLWOLD' || currentTitle === 'DEVON SOLWOLD ') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="23"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Devon Solwold');
                    }
                    if (currentTitle === 'Zack Pelletier' || currentTitle === 'ZACK PELLETIER') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="31"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Zack Pelletier');
                    }
                    if (currentTitle === 'Wilhends Norvil') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="36"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Wilhends Norvil');
                    }
                    if (currentTitle === 'Avery Niles') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="42"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Avery Niles');
                    }
                    if (currentTitle === 'Ayo Douson') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="51"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Ayo Douson');
                    }
                    if (currentTitle === 'Ben Gillespie') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="60"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Ben Gillespie');
                    }
                    if (currentTitle === 'Le Jumper') {
                        $('div.editorsMain ul.editorsRight li').removeClass('active');
                        $('div.editorsMain ul.editorsRight li[data-start="66"]').addClass('active');
                        $('div.insideHeader div.menuRight h4.authorsNames').text('Le Jumper');
                    }
                }
            });
        }
    // });
  </script>
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
