<!DOCTYPE html>
<html>
<head>
    <title>APOLLO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.css">
    <link rel="stylesheet" type="text/css" href="/work/style-new.css?v=10.1.1">
    <style>
        h3 a{
            text-decoration:unset;
            color:inherit;
        }
        p a{
            text-decoration:unset;
            color:inherit;
        }
        header { position: fixed; top: 0px; left: 0px; z-index: 9999999; transition: all 0.3s linear; } header div.menu div.openbtn { width: 50px; height: 50px; border-radius: 5px; cursor: pointer; position: relative; overflow: hidden; } header div.menu div.openbtn .openbtn-area { transition: all 0.4s; } header div.menu div.openbtn span { position: absolute; background: #fff; display: inline-block; border-radius: 3px; left: 13px; height: 3px; transition: all 0.4s; width: 50%; } header div.menu div.openbtn span:nth-of-type(1) { top: 16px; } header div.menu div.openbtn span:nth-of-type(2) { top: 24px; } header div.menu div.openbtn span:nth-of-type(3) { top: 32px; } header div.menu div.openbtn.active .openbtn-area { transform: rotatex(360deg); } header div.menu div.openbtn.active span:nth-of-type(1) { width: 45%; top: 18px; left: 14px; transform: translateY(6px) rotate(-135deg); } header div.menu div.openbtn.active span:nth-of-type(2) { opacity: 0; } header div.menu div.openbtn.active span:nth-of-type(3) { width: 45%; top: 30px; left: 14px; transform: translateY(-6px) rotate(135deg); } header div.menu label { font-size: 50px; font-weight: 600; font-style: normal; text-align: left; color: #ffffff; text-shadow: 2px 1px black; font-family: BelleStory; padding-left: 6px; }
        header.show {
            right: 0px;
            width: 100%;
            height: 100vh;
            background: #050505 !important;
            z-index: 9999999;
        }
        header .menuList {
            padding-left: 60px;
            padding-top: 50px;
        }
        header .menuList ul {
            padding: 0px;
            margin: 0px;
            list-style-type: none;
        }
        header .menuList ul li {
            margin-bottom: -30px;
        }
        header .menuList ul li a {
            font-size: 80px;
            font-weight: bold;
            font-style: normal;
            text-align: left;
            color: #050505;
            -webkit-text-stroke: 1px #fff;
            text-stroke: 1px #fff;
            text-shadow: none;
            background: transparent;
            text-decoration: unset;
            letter-spacing: 2px;
            text-shadow: -1px -1px 0 #050505, 1px -1px 0 #050505, -1px 1px 0 #050505, 1px 1px 0 #050505;
            transition: all 0.3s linear;
        }
        header .menuList ul li a {
            position: relative;
            text-transform: uppercase;
        }
        header .menuList ul li a:before {
            content: attr(data-text);
            position: absolute;
            top: -12%;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        header .menuList ul li a:not(.active):hover:before {
            animation: animate 1s ease forwards;
            color: #fff;
        }
        header .menuList ul li a.active:before {
            animation: animate 1s ease forwards;
            color: #fff;
        }

        .desktopTitle {
            display: block !important;
        }

        .mobileTitle {
            display: none !important;
        }

        @media (max-width: 800px) {
            .desktopTitle {
                display: none !important;
            }

            .mobileTitle {
                display: block !important;
            }
        }
    </style>
</head>
<body>
<div id="startingAnimationStart"></div>
<header>
	<div class="logo">
	    <a href="/"><img src="../fonts/logo.png" /></a>
	</div>
	<div class="menu">
	    <ul>
	        <li>
	            <a href="/roster/">ROSTER</a>
	            <!--<ol>-->
	            <!--   <li>-->
	            <!--        <a href="/roster-update-new/?author=EDITOR">Editor</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster-update-new/?writer=Jamil Shaukat">Jamil Shaukat</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?writer=Liam Tangum">Liam Tangum</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?writer=Griffin Olis">Griffin Olis</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster-update-new/?author=COLORIST">Color</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster-update-new/?writer=Brian Charles">Brian Charles</a>-->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?writer=Wilhends Norvil">Wilhends Norvil</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster-update-new/?author=SOUND">Sound</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster-update-new/?writer=Ayo Douson">Ayo Douson</a>-->
             <!--               </li>-->
	            <!--        </ol>-->
	            <!--   </li>-->
	            <!--   <li>-->
	            <!--        <a href="/roster-update-new/?author=VFX">VFX</a>-->
	            <!--        <ol class="last">-->
	            <!--            <li>-->
             <!--                   <a href="/roster-update-new/?writer=Ben Gillespie">Ben Gillespie</a> -->
             <!--               </li>-->
             <!--               <li>-->
             <!--                   <a href="/roster-update-new/?writer=Le Jumper">Le Jumper</a> -->
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
</header>
<section id="roster" class="roster">
	<div class="container">
		<div class="row">
			<div class="col-md-12"> 
			    <div class="allWorks">
    				<div class="content">
    					<h3 class="desktopTitle"><a href="/roster/edit">EDIT</a></h3>
                        <h3 class="mobileTitle">EDIT</h3>
    					<div class="innerContent">
                            <p data-author="EDITOR"><a href="/roster/devon-solwold">Devon Solwold</a></p>
                            <p data-author="EDITOR"><a href="/roster/griffin-olis">Griffin Olis</a></p>
                            <p data-author="EDITOR"><a href="/roster/liam-tangum">Liam Tangum</a></p>
        					<p data-author="EDITOR"><a href="/roster/jamil-shaukat">Jamil Shaukat</a></p>
        					<p data-author="EDITOR"><a href="/roster/nasser-boulaich">Nasser Boulaich</a></p>
                            <p data-author="EDITOR"><a href="/roster/zack-pelletier">Zack Pelletier</a></p> 
                        </div>
    				</div>
    				<div class="content">
    					<h3 class="desktopTitle"><a href="/roster/color">COLOR</a></h3>
                        <h3 class="mobileTitle">COLOR</h3>
    					<div class="innerContent">
        					<!-- <p data-author="COLORIST"><a href="/roster/?writer=Brian Charles">Brian Charles</a></p> -->
        					<p data-author="COLORIST"><a href="/roster/avery-niles">Avery Niles</a></p>
                            <p data-author="COLORIST"><a href="/roster/wilhends-norvil">Wilhends Norvil</a></p>
    					</div>
    				</div>
    				<div class="content">
    					<h3 class="desktopTitle"><a href="/roster/sound">SOUND</a></h3>
                        <h3 class="mobileTitle">SOUND</h3>
    					<div class="innerContent">
        					<p data-author="SOUND"><a href="/roster/ayo-douson">Ayo Douson</a></p>
    					</div>
    				</div>
    				<div class="content">
    					<h3 class="desktopTitle"><a href="/roster/vfx">VFX</a></h3>
                        <h3 class="mobileTitle">VFX</h3>
    					<div class="innerContent">
        					<p data-author="VFX"><a href="/roster/ben-gillespie">Ben Gillespie</a></p>
        					<p data-author="VFX"><a href="/roster/le-jumper">Le Jumper</a></p>
    					</div>
    				</div>
				</div>
			</div>
		</div>
	</div>
</section>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    $('div#startingAnimationStart').attr('style','opacity:1;animation: lineAnimation 2s forwards;');
    if($(window).width() <= 800){
        $(document).on('click','section#roster h3',function(){
            var $clickedHeader = $(this);
            var $clickedContent = $clickedHeader.parent().find('.innerContent');
            
            // Check if the clicked header is already active
            if($clickedHeader.hasClass('active')){
                // If already active, close it
                $clickedHeader.removeClass('active');
                $clickedContent.slideUp();
            } else {
                // If not active, close all others and open this one
                $('section#roster h3').removeClass('active');
                $('section#roster .innerContent').slideUp();
                $clickedHeader.addClass('active');
                $clickedContent.slideDown();
            }
        });
    }
});
</script>
</body>
</html>