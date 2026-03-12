
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APOLLO</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Londrina+Shadow&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #000;
            margin: 0;
            overflow: hidden;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
            transition: transform 0.6s ease-in-out;
            max-width: 900px;
        }
        .swiper-wrapper {
            transition-timing-function: ease-in-out !important;
            transition-duration: .9s !important;
            transform: scale(1); /* Start with zoomed out wrapper */
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: self-start;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .swiper-slide.swiper-slide-next {
            align-items: flex-end;
        }
        .swiper-slide-active {
            width: 92%;
            margin: auto;
        }
        .swiper-container div.swiper-wrapper {
            height: auto;
        }
        .swiper-slide .innerSidesSlide {
            width: 100%;
            height: calc(100% - 100px);
            position: relative;
        }
        .swiper-slide .innerSidesSlide div.poster {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 99%;
            height: 99%;
            background-size: cover !important;
            margin: auto;
            right: 0px;
            bottom: 0px;
        }
        .swiper-slide .innerSidesSlide h2.title {
            opacity: 0;
            margin: 0px;
            position: absolute;
            bottom: 30px;
            left: -20px;
            font-family: "Montserrat", sans-serif;
            font-size: 20px;
            color: #fff;
            font-weight: 600;
        }
        .swiper-slide.swiper-slide-active .innerSidesSlide h2.title {
            opacity: 1;
        }
        .swiper-slide .innerSidesSlide div.iframe {
            width: 100%;
            height: 100%;
            position: relative;
            opacity: 0;
            transition: all 0.9s linear;
        }
        .swiper-slide.swiper-slide-active div.iframe {
            opacity: 1;
        }
        .swiper-slide .innerSidesSlide div.iframe iframe {
            width: 100%;
            height: 100%;
            background: #000;
        }
        .swiper-slide.swiper-slide-active .innerSidesSlide {
            height: calc(100% + 135px);
            margin-top: -70px;
        }
        .swiper-slide div.iframe .modalFrame {
            z-index: 99;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
        }
        ul.colorful-list {
            display: inline-flex;
            flex-direction: column;
            justify-content: center;
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 300px;
            padding: 0px;
            margin: 0px;
        }
        ul.colorful-list li {
            list-style-type: none;
            width: 28px;
            height: 35px;
        }
        ul.editors {
            writing-mode: tb-rl;
            padding: 0px;
            text-align: center;
            display: flex;
            transform: rotate(180deg) scale(0);
            gap: 10px;
            margin: auto;
            transition: all 0.3s linear;
            height: 250px;
            overflow-y: scroll;
            z-index: 999;
            width: 50px;
            align-items: center;
            white-space: nowrap;
            position: relative;
        } 
        ul.editors {
            transform: rotate(180deg) scale(1);
        }
        ul.editors li {
            display: inline-block;
            list-style-type: none;
            text-transform: uppercase;
            color: #fff;
            font-family: "Montserrat", sans-serif;
            font-weight: 600;
            cursor: pointer;
            position: unset;
        }
        ul.editors li a {
            cursor: pointer;
        }
        div.editorsMain {
            position: absolute;
            left: 200px;
            top: 0px;
            bottom: 0px;
            display: inline-flex;
            align-items: center;
            height: fit-content;
            margin: auto;
            z-index: 9999;
        }
        div.editorsMain:before {
            content: "";
            box-shadow: 0px 0px 20px 40px #000000c7;
            background: #000;
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 40px;
            z-index: 9999;
        }
        div.editorsMain:after {
            content: "";
            box-shadow: 0px 0px 20px 40px #000000c7;
            background: #000;
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
            height: 35px;
            z-index: 9999;
        }
        div.editorsRightMain {
            left: unset;
            right: 200px;
        }
        ul.editors::-webkit-scrollbar {
          width: 0px;
        }
        div#videoModalPopup {
            position: absolute;
            top: 0px;
            left: 0px;
            right: 0px;
            background: #000;
            z-index: 9999;
        }
        #videoModalPopup ul.screenshots li img {
            width: 100%;
            max-height: 500px;
            height: 100%;
            object-fit: cover;
        }
        #videoModalPopup ul.screenshots li {
            width: 49.5%;
        }
        div#videoModalPopup button.btn-close {
            z-index: 999;
            position: relative;
            font-weight: 400;
        }
        div#videoModalPopup .modal-dialog .modal-content .modal-header {
            top: 20px;
            left: 25px;
        }
        #videoModalPopup ul.screenshots li {
            width: 50%;
            margin: 0px -2px;
        }
        #videoModalPopup ul.screenshots li img {
            height: 400px;
        }
        #videoModalPopup div.popupVideo iframe {
                        width: 100% !important;
                        height: 100vh !important;
                        background: #000;
                    }
        div#videoModalPopup .modal-dialog {
            margin: 0 auto;
            display: flex;
            align-items: center;
            max-width: 100%;
        }
        div#videoModalPopup .modal-dialog .modal-content {
            background: transparent;
            border: unset;
            position: relative;
        }
        div#videoModalPopup .modal-dialog .modal-content .modal-header {
            position: absolute;
            padding: 0px;
            border: unset;
        }
        div#videoModalPopup .modal-dialog .modal-content .modal-body {
            padding: 0px;
        }
        div#videoModalPopup .videoSupport {
            position: relative;
            width: 100%;
            height: 100vh;
        }
        #videoModalPopup ul.screenshots {
            padding: 0px;
            margin: 0px;
            display: block;
        }
        #videoModalPopup ul.screenshots li {
            display: inline-block;
            vertical-align: top;
        }
        div#videoModalPopup .modal-dialog .modal-content .modal-header button.btn-close {
            margin: 0px;
            padding: 0px;
            filter: invert(1);
            opacity: 1;
            font-size: 30px;
            float: unset;
            z-index: 9;
            border: unset;
            outline: unset;
            box-shadow: unset;
            position: relative;
            font-weight: 400;
            appearance: none;
            background-color: transparent;
            cursor: pointer;
            --bs-btn-close-bg: unset;
        }
        div#videoModalPopup .modal-dialog .modal-content .modal-header label {
            font-size: 42px;
            font-weight: 600;
            font-style: normal;
            text-align: left;
            color: #ffffff;
            text-shadow: 2px 1px black;
            font-family: BelleStory;
            padding-left: 25px;
            display:none;
        }
        .swiper-button-prev, .swiper-button-next {
            opacity: 0;
        }
    </style>
</head>
<body> 
    <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php if(!isset($_GET['action']) && !isset($_GET['author'])){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=0>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h47m11s866.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h47m11s866.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h49m03s611.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h52m33s487.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h53m30s259.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h53m41s232.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h55m16s350.jpg"
                        data-long-video="https://player.vimeo.com/video/956088891?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957289050?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">99 Neighbors - 49er</h2>
                </div>
            </div>  
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=1>
                    <div class="poster poster2" id="imagePoster2" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h34m47s993.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h34m47s993.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m16s426.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m41s558.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m56s841.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h38m27s121.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h38m57s747.jpg"
                        data-long-video="https://player.vimeo.com/video/956869696?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video2" src="https://player.vimeo.com/video/957289112?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Drake Cole Dreamville</h2>
                </div>
            </div> 
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=2>
                    <div class="poster poster3" id="imagePoster3" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h18m41s437.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h18m41s437.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m17s663.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m44s823.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m53s492.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h21m33s075.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h23m09s333.jpg"
                        data-long-video="https://player.vimeo.com/video/956102895?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video3" src="https://player.vimeo.com/video/957288850?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Kai Cenat x iShowSpeed - Streamshow</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=3>
                    <div class="poster poster4" id="imagePoster4" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m35s867.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m35s867.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m54s232.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h13m26s655.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h13m31s563.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h14m15s839.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h14m30s241.jpg"
                        data-long-video="https://player.vimeo.com/video/956868957?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video4" src="https://player.vimeo.com/video/957289162?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">MLS & Apple TV - Beyond the Pitch - Episode 2</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=4>
                    <div class="poster poster5" id="imagePoster5" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h16m58s466.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h16m58s466.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h17m18s454.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h18m03s386.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h18m48s756.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h19m14s771.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h19m37s875.jpg"
                        data-long-video="https://player.vimeo.com/video/956870890?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video5" src="https://player.vimeo.com/video/957289209?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">MLS & Apple TV - Beyond the Pitch- Episode 4</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=5>
                    <div class="poster poster6" id="imagePoster6" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h56m32s101.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h56m32s101.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h57m09s467.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h57m44s238.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m29s543.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m42s493.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m57s704.jpg"
                        data-long-video="https://player.vimeo.com/video/957229861?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video6" src="https://player.vimeo.com/video/957288741?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bas feat. J Cole - Passport Bros</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=6>
                    <div class="poster poster7" id="imagePoster7" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m27s024.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m27s024.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m36s463.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h31m19s842.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h31m36s842.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h32m13s410.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h33m05s950.jpg"
                        data-long-video="https://player.vimeo.com/video/956869202?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video7" src="https://player.vimeo.com/video/957288794?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">J.I.D - Van Gogh feat. Lil Yachty</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=7>
                    <div class="poster poster8" id="imagePoster8" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h26m43s828.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h26m43s828.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m00s991.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m08s308.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m26s008.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m33s009.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m58s313.jpg"
                        data-long-video="https://player.vimeo.com/video/956870846?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video8" src="https://player.vimeo.com/video/957288949?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Footlocker</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=8>
                    <div class="poster poster9" id="imagePoster9" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m24s231.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m24s231.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m35s040.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m00s195.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m26s556.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m41s189.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m48s039.jpg"
                        data-long-video="https://player.vimeo.com/video/957238132?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video9" src="https://player.vimeo.com/video/957288997?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Casa Dollero</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=9>
                    <div class="poster poster10" id="imagePoster10" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m32s952.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m32s952.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m57s674.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m06s287.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m21s396.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m37s218.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m51s092.jpg"
                        data-long-video="https://player.vimeo.com/video/956872117?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video10" src="https://player.vimeo.com/video/990819936?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Surgeon General </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=10>
                    <div class="poster poster11" id="imagePoster11" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h41m53s673.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h41m53s673.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m24s172.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m36s476.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m47s862.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h43m01s032.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h43m12s346.jpg"
                        data-long-video="https://player.vimeo.com/video/956875410?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video11" src="https://player.vimeo.com/video/956848417?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">99 Neighbors - Live A Little</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=11>
                    <div class="poster poster12" id="imagePoster12" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m07s881.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m07s881.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m37s368.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m47s401.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m13s734.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m31s561.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m50s420.jpg"
                        data-long-video="https://player.vimeo.com/video/957304974?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video12" src="https://player.vimeo.com/video/956848043?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Vic Mensa feat. Chance The Rapper & G-Eazy - SWISH </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=12>
                    <div class="poster poster13" id="imagePoster13" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m13s769.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m13s769.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m20s993.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m29s912.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m34s236.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m49s897.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h33m19s118.jpg"
                        data-long-video="https://player.vimeo.com/video/956875717?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video13" src="https://player.vimeo.com/video/957364053?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bo Jackson Elite Sports</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=13>
                    <div class="poster poster14" id="imagePoster14" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m02s504.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m02s504.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m16s235.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m43s871.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m56s478.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h26m47s147.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h26m57s925.jpg"
                        data-long-video="https://player.vimeo.com/video/956875984?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video14" src="https://player.vimeo.com/video/956847983?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Celsius Commercial</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=14>
                    <div class="poster poster15" id="imagePoster15" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m47s419.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m47s419.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m52s361.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m58s999.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h52m16s569.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h52m50s318.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h53m41s853.jpg"
                        data-long-video="https://player.vimeo.com/video/956843992?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video15" src="https://player.vimeo.com/video/990820296?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">Chris Brown, Davido - Hmmm</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=15>
                    <div class="poster poster16" id="imagePoster16" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m35s424.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m35s424.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m48s691.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h45m41s829.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h45m53s572.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h46m08s874.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h46m47s489.jpg"
                        data-long-video="https://player.vimeo.com/video/956875169?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video16" src="https://player.vimeo.com/video/990820324?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Rich the Kid - Band Man</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=16>
                    <div class="poster poster17" id="imagePoster17" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h34m47s993.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h34m47s993.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m16s426.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m41s558.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m56s841.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h38m27s121.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h38m57s747.jpg"
                        data-long-video="https://player.vimeo.com/video/956098951?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video17" src="https://player.vimeo.com/video/957366199?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">J Cole x Drake - Dreamville Fest 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=17>
                    <div class="poster poster18" id="imagePoster18" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h56m48s598.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h56m48s598.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h57m36s218.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h57m47s931.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h58m13s583.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h58m38s643.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h59m03s329.jpg"
                        data-long-video="https://player.vimeo.com/video/956878154?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video18" src="https://player.vimeo.com/video/990820402?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">Lucki - Gemini Album Trailer - No Mercy</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=18>
                    <div class="poster poster19" id="imagePoster19" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m32s192.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m32s192.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m36s766.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m46s268.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h47m04s295.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h47m23s172.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h48m19s533.jpg"
                        data-long-video="https://player.vimeo.com/video/956878032?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video19" src="https://player.vimeo.com/video/957280027?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Olamide - JINJA</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=19>
                    <div class="poster poster20" id="imagePoster20" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m35s817.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m35s817.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m42s321.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m47s847.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h55m18s182.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h56m05s437.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h58m58s021.jpg"
                        data-long-video="https://player.vimeo.com/video/957336175?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video20" src="https://player.vimeo.com/video/957279643?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bodega x New Balance</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=20>
                    <div class="poster poster21" id="imagePoster21" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m36s930.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m36s930.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m47s651.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h51m49s460.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m02s503.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m23s166.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m39s460.jpg"
                        data-long-video="https://player.vimeo.com/video/956878001?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video21" src="https://player.vimeo.com/video/957358314?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bodega x G Shock - Anytime, Anywhere</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=21>
                    <div class="poster poster22" id="imagePoster22" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m34s070.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m34s070.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m46s465.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m50s751.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h01m04s035.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h01m26s202.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m40s456.jpg"
                        data-long-video="https://player.vimeo.com/video/956877781?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video22" src="https://player.vimeo.com/video/957279457?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OKEM - Short Film</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=22>
                    <div class="poster poster23" id="imagePoster23" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h03m44s239.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h03m44s239.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h04m00s981.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h04m32s037.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m09s535.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m13s488.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m29s806.jpg"
                        data-long-video="https://player.vimeo.com/video/956877696?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video23" src="https://player.vimeo.com/video/957279968?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Cala App Launch</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=23>
                    <div class="poster poster24" id="imagePoster24" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h07m51s199.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h07m51s199.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m03s659.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m44s240.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m57s160.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h09m15s418.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h09m22s315.jpg"
                        data-long-video="https://player.vimeo.com/video/956877627?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video24" src="https://player.vimeo.com/video/957279818?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Conway the Machine & Jill Scott - Chanel Pearls</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=24>
                    <div class="poster poster25" id="imagePoster25" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m46s895.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m46s895.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m54s560.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m05s810.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m27s701.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m41s346.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m49s741.jpg"
                        data-long-video="https://player.vimeo.com/video/957311583?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video25" src="https://player.vimeo.com/video/957279583?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Eem Triplin - What Da Opp Said</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=25>
                    <div class="poster poster26" id="imagePoster26" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h13m51s427.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h13m51s427.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m06s990.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m15s419.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m35s330.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m52s369.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h15m07s844.jpg"
                        data-long-video="https://player.vimeo.com/video/956877311?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video26" src="https://player.vimeo.com/video/957279412?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">$NOT feat. Zilla Kami - 0 PERCENT</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=26>
                    <div class="poster poster27" id="imagePoster27" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m00s770.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m00s770.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m20s468.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m36s787.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m42s230.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h18m16s405.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h18m27s307.jpg"
                        data-long-video="https://player.vimeo.com/video/956877154?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video27" src="https://player.vimeo.com/video/957279911?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Run that Shit! Short Film</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=27>
                    <div class="poster poster28" id="imagePoster28" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h20m53s708.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h20m53s708.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h21m22s205.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m00s398.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m07s823.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m16s705.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m28s075.jpg"
                        data-long-video="https://player.vimeo.com/video/956877265?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video28" src="https://player.vimeo.com/video/957279749?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OnJuno Banking - Renaissance</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=28>
                    <div class="poster poster29" id="imagePoster29" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m08s893.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m08s893.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m14s137.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m36s096.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m41s613.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m50s839.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h25m02s242.jpg"
                        data-long-video="https://player.vimeo.com/video/956877111?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video29" src="https://player.vimeo.com/video/957279516?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OnJuno Banking - Granny</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=29>
                    <div class="poster poster30" id="imagePoster30" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m18s898.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m18s898.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m44s609.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m48s939.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h27m19s449.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h27m31s892.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h28m08s632.jpg"
                        data-long-video="https://player.vimeo.com/video/956876925?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video30" src="https://player.vimeo.com/video/957279345?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Jack Daniels x GQ</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=30>
                    <div class="poster poster31" id="imagePoster31" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/Copy%20of%20vlcsnap-2024-06-06-05h29m56s841.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/Copy%20of%20vlcsnap-2024-06-06-05h29m56s841.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m23s271.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m32s330.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m44s777.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m49s630.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m56s841.jpg"
                        data-long-video="https://player.vimeo.com/video/956878228?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video31" src="https://player.vimeo.com/video/957279868?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Compromised Voiced by Victoria Pedretti </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=31>
                    <div class="poster poster32" id="imagePoster32" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m55s668.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m16s505.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m25s220.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m45s885.jpg"
                        data-long-video="https://player.vimeo.com/video/956878134?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video32" src="https://player.vimeo.com/video/957352295?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">PURPLE DENIM - Daytrippin</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=32>
                    <div class="poster poster33" id="imagePoster33" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m30s452.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m30s452.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m44s104.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m48s602.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m55s702.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h38m04s635.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h38m28s576.jpg"
                        data-long-video="https://player.vimeo.com/video/956882063?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video33" src="https://player.vimeo.com/video/957286315?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">NFLPA - Rookie of the Year 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=33>
                    <div class="poster poster34" id="imagePoster34" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h16m58s970.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h16m58s970.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h17m07s973.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h17m40s458.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m09s640.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m22s999.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m29s867.jpg"
                        data-long-video="https://player.vimeo.com/video/957220307?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video34" src="https://player.vimeo.com/video/957286315?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">NHL - Hockey is Back</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=34>
                    <div class="poster poster35" id="imagePoster35" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h23m58s904.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h23m58s904.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m06s496.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m10s856.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m51s640.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h27m53s785.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h28m05s001.jpg"
                        data-long-video="https://player.vimeo.com/video/956882092?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video35" src="https://player.vimeo.com/video/957286201?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Le Cartel - Fall/Winter Collection 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=35>
                    <div class="poster poster36" id="imagePoster36" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m06s130.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m06s130.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m27s424.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m38s228.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m50s434.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m57s627.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h41m13s136.jpg"
                        data-long-video="https://player.vimeo.com/video/956882658?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video36" src="https://player.vimeo.com/video/957346184?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Chris Brown - Nightmares</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=36>
                    <div class="poster poster37" id="imagePoster37" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m23s420.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m23s420.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m30s004.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m33s691.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m40s365.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m57s369.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h46m04s590.jpg"
                        data-long-video="https://player.vimeo.com/video/956882433?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video37" src="https://player.vimeo.com/video/957286086?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Louis the Child - How High</h2>
                </div>
            </div>
          <?php }else{ ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='EDITOR') || (isset($_GET['author']) && $_GET['author']=='GRIFFIN OLIS')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=0>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h47m11s866.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h47m11s866.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h49m03s611.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h52m33s487.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h53m30s259.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h53m41s232.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/99neighbours/vlcsnap-2024-06-06-02h55m16s350.jpg"
                        data-long-video="https://player.vimeo.com/video/956088891?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957289050?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">99 Neighbors - 49er</h2>
                </div>
            </div>  
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=1>
                    <div class="poster poster2" id="imagePoster2" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h34m47s993.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h34m47s993.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m16s426.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m41s558.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h36m56s841.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h38m27s121.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/drakecoledreamy/vlcsnap-2024-06-06-03h38m57s747.jpg"
                        data-long-video="https://player.vimeo.com/video/956869696?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video2" src="https://player.vimeo.com/video/957289112?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Drake Cole Dreamville</h2>
                </div>
            </div> 
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=2>
                    <div class="poster poster3" id="imagePoster3" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h18m41s437.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h18m41s437.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m17s663.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m44s823.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h19m53s492.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h21m33s075.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/kaicenatxishowspeed/vlcsnap-2024-06-06-03h23m09s333.jpg"
                        data-long-video="https://player.vimeo.com/video/956102895?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video3" src="https://player.vimeo.com/video/957288850?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Kai Cenat x iShowSpeed - Streamshow</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=3>
                    <div class="poster poster4" id="imagePoster4" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m35s867.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m35s867.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h12m54s232.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h13m26s655.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h13m31s563.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h14m15s839.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode1/vlcsnap-2024-06-06-04h14m30s241.jpg"
                        data-long-video="https://player.vimeo.com/video/956868957?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video4" src="https://player.vimeo.com/video/957289162?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">MLS & Apple TV - Beyond the Pitch - Episode 2</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=4>
                    <div class="poster poster5" id="imagePoster5" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h16m58s466.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h16m58s466.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h17m18s454.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h18m03s386.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h18m48s756.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h19m14s771.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/mlsepisode2/vlcsnap-2024-06-06-04h19m37s875.jpg"
                        data-long-video="https://player.vimeo.com/video/956870890?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video5" src="https://player.vimeo.com/video/957289209?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">MLS & Apple TV - Beyond the Pitch- Episode 4</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=5>
                    <div class="poster poster6" id="imagePoster6" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h56m32s101.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h56m32s101.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h57m09s467.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h57m44s238.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m29s543.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m42s493.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/basfeatjcole/vlcsnap-2024-06-06-03h58m57s704.jpg"
                        data-long-video="https://player.vimeo.com/video/957229861?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video6" src="https://player.vimeo.com/video/957288741?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bas feat. J Cole - Passport Bros</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=6>
                    <div class="poster poster7" id="imagePoster7" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m27s024.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m27s024.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h30m36s463.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h31m19s842.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h31m36s842.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h32m13s410.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/jidvangouh/vlcsnap-2024-06-06-03h33m05s950.jpg"
                        data-long-video="https://player.vimeo.com/video/956869202?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video7" src="https://player.vimeo.com/video/957288794?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">J.I.D - Van Gogh feat. Lil Yachty</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=7>
                    <div class="poster poster8" id="imagePoster8" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h26m43s828.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h26m43s828.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m00s991.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m08s308.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m26s008.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m33s009.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/footlocker/vlcsnap-2024-06-06-03h27m58s313.jpg"
                        data-long-video="https://player.vimeo.com/video/956870846?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video8" src="https://player.vimeo.com/video/957288949?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Footlocker</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=8>
                    <div class="poster poster9" id="imagePoster9" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m24s231.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m24s231.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h02m35s040.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m00s195.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m26s556.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m41s189.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/casadollero/vlcsnap-2024-06-06-04h03m48s039.jpg"
                        data-long-video="https://player.vimeo.com/video/957238132?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video9" src="https://player.vimeo.com/video/957288997?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Casa Dollero</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="GRIFFIN OLIS" data-index=9>
                    <div class="poster poster10" id="imagePoster10" style="background: url('https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m32s952.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m32s952.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h06m57s674.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m06s287.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m21s396.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m37s218.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/griffin-olis/surgeongeneral/vlcsnap-2024-06-06-04h08m51s092.jpg"
                        data-long-video="https://player.vimeo.com/video/956872117?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video10" src="https://player.vimeo.com/video/990819936?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Surgeon General </h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='EDITOR') || (isset($_GET['author']) && $_GET['author']=='ALEX PETERSON')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=10>
                    <div class="poster poster11" id="imagePoster11" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h41m53s673.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h41m53s673.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m24s172.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m36s476.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h42m47s862.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h43m01s032.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/99neighbours-livealittle/vlcsnap-2024-06-06-04h43m12s346.jpg"
                        data-long-video="https://player.vimeo.com/video/956875410?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video11" src="https://player.vimeo.com/video/956848417?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">99 Neighbors - Live A Little</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=11>
                    <div class="poster poster12" id="imagePoster12" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m07s881.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m07s881.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m37s368.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h36m47s401.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m13s734.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m31s561.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/vicmensa/vlcsnap-2024-06-06-04h37m50s420.jpg"
                        data-long-video="https://player.vimeo.com/video/957304974?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video12" src="https://player.vimeo.com/video/956848043?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Vic Mensa feat. Chance The Rapper & G-Eazy - SWISH </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=12>
                    <div class="poster poster13" id="imagePoster13" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m13s769.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m13s769.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m20s993.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m29s912.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m34s236.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h32m49s897.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Bo/vlcsnap-2024-06-06-04h33m19s118.jpg"
                        data-long-video="https://player.vimeo.com/video/956875717?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video13" src="https://player.vimeo.com/video/957364053?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bo Jackson Elite Sports</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=13>
                    <div class="poster poster14" id="imagePoster14" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m02s504.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m02s504.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m16s235.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m43s871.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h25m56s478.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h26m47s147.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Celsius/vlcsnap-2024-06-06-04h26m57s925.jpg"
                        data-long-video="https://player.vimeo.com/video/956875984?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video14" src="https://player.vimeo.com/video/956847983?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Celsius Commercial</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=14>
                    <div class="poster poster15" id="imagePoster15" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m47s419.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m47s419.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m52s361.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h51m58s999.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h52m16s569.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h52m50s318.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Chris%20Brown,%20Davido%20-%20Hmmm/vlcsnap-2024-06-12-02h53m41s853.jpg"
                        data-long-video="https://player.vimeo.com/video/956843992?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video15" src="https://player.vimeo.com/video/990820296?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">Chris Brown, Davido - Hmmm</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=15>
                    <div class="poster poster16" id="imagePoster16" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m35s424.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m35s424.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h44m48s691.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h45m41s829.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h45m53s572.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h46m08s874.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Rich%20the%20kid/vlcsnap-2024-06-12-02h46m47s489.jpg"
                        data-long-video="https://player.vimeo.com/video/956875169?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video16" src="https://player.vimeo.com/video/990820324?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Rich the Kid - Band Man</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=16>
                    <div class="poster poster17" id="imagePoster17" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h34m47s993.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h34m47s993.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m16s426.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m41s558.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h36m56s841.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h38m27s121.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/J%20Cole%20&%20Drake/Copy%20of%20vlcsnap-2024-06-06-03h38m57s747.jpg"
                        data-long-video="https://player.vimeo.com/video/956098951?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video17" src="https://player.vimeo.com/video/957366199?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">J Cole x Drake - Dreamville Fest 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ALEX PETERSON" data-index=17>
                    <div class="poster poster18" id="imagePoster18" style="background: url('https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h56m48s598.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h56m48s598.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h57m36s218.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h57m47s931.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h58m13s583.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h58m38s643.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/alex-peterson/Lucki%20-%20Gemini%20Album%20Trailer%20-%20No%20Mercy/vlcsnap-2024-06-12-02h59m03s329.jpg"
                        data-long-video="https://player.vimeo.com/video/956878154?autoplay=1&muted=1&loop=1"
                            >
                                <div class="modalFrame"></div>
                                <iframe id="video18" src="https://player.vimeo.com/video/990820402?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <h2 class="title">Lucki - Gemini Album Trailer - No Mercy</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='EDITOR') || (isset($_GET['author']) && $_GET['author']=='DEVON SOLWOLD')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=18>
                    <div class="poster poster19" id="imagePoster19" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m32s192.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m32s192.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m36s766.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h46m46s268.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h47m04s295.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h47m23s172.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Olamide/vlcsnap-2024-06-06-04h48m19s533.jpg"
                        data-long-video="https://player.vimeo.com/video/956878032?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video19" src="https://player.vimeo.com/video/957280027?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Olamide - JINJA</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=19>
                    <div class="poster poster20" id="imagePoster20" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m35s817.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m35s817.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m42s321.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h54m47s847.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h55m18s182.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h56m05s437.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/BodegaXnew/vlcsnap-2024-06-06-04h58m58s021.jpg"
                        data-long-video="https://player.vimeo.com/video/957336175?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video20" src="https://player.vimeo.com/video/957279643?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bodega x New Balance</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=20>
                    <div class="poster poster21" id="imagePoster21" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m36s930.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m36s930.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h50m47s651.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h51m49s460.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m02s503.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m23s166.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/BodegaXG/vlcsnap-2024-06-06-04h52m39s460.jpg"
                        data-long-video="https://player.vimeo.com/video/956878001?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video21" src="https://player.vimeo.com/video/957358314?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bodega x G Shock - Anytime, Anywhere</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=21>
                    <div class="poster poster22" id="imagePoster22" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m34s070.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m34s070.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m46s465.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m50s751.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h01m04s035.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h01m26s202.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Okem/vlcsnap-2024-06-06-05h00m40s456.jpg"
                        data-long-video="https://player.vimeo.com/video/956877781?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video22" src="https://player.vimeo.com/video/957279457?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OKEM - Short Film</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=22>
                    <div class="poster poster23" id="imagePoster23" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h03m44s239.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h03m44s239.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h04m00s981.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h04m32s037.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m09s535.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m13s488.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/CalaApp/vlcsnap-2024-06-06-05h05m29s806.jpg"
                        data-long-video="https://player.vimeo.com/video/956877696?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video23" src="https://player.vimeo.com/video/957279968?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Cala App Launch</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=23>
                    <div class="poster poster24" id="imagePoster24" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h07m51s199.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h07m51s199.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m03s659.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m44s240.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h08m57s160.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h09m15s418.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Conway/vlcsnap-2024-06-06-05h09m22s315.jpg"
                        data-long-video="https://player.vimeo.com/video/956877627?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video24" src="https://player.vimeo.com/video/957279818?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Conway the Machine & Jill Scott - Chanel Pearls</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=24>
                    <div class="poster poster25" id="imagePoster25" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m46s895.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m46s895.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h10m54s560.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m05s810.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m27s701.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m41s346.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/EemTriplin/vlcsnap-2024-06-06-05h11m49s741.jpg"
                        data-long-video="https://player.vimeo.com/video/957311583?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video25" src="https://player.vimeo.com/video/957279583?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Eem Triplin - What Da Opp Said</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=25>
                    <div class="poster poster26" id="imagePoster26" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h13m51s427.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h13m51s427.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m06s990.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m15s419.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m35s330.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h14m52s369.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/$NotFT/vlcsnap-2024-06-06-05h15m07s844.jpg"
                        data-long-video="https://player.vimeo.com/video/956877311?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video26" src="https://player.vimeo.com/video/957279412?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">$NOT feat. Zilla Kami - 0 PERCENT</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=26>
                    <div class="poster poster27" id="imagePoster27" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m00s770.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m00s770.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m20s468.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m36s787.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h17m42s230.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h18m16s405.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/Runthatshit!/vlcsnap-2024-06-06-05h18m27s307.jpg"
                        data-long-video="https://player.vimeo.com/video/956877154?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video27" src="https://player.vimeo.com/video/957279911?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Run that Shit! Short Film</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=27>
                    <div class="poster poster28" id="imagePoster28" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h20m53s708.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h20m53s708.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h21m22s205.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m00s398.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m07s823.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m16s705.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingR/vlcsnap-2024-06-06-05h22m28s075.jpg"
                        data-long-video="https://player.vimeo.com/video/956877265?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video28" src="https://player.vimeo.com/video/957279749?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OnJuno Banking - Renaissance</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=28>
                    <div class="poster poster29" id="imagePoster29" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m08s893.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m08s893.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m14s137.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m36s096.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m41s613.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h24m50s839.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/OnjunoBankingG/vlcsnap-2024-06-06-05h25m02s242.jpg"
                        data-long-video="https://player.vimeo.com/video/956877111?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video29" src="https://player.vimeo.com/video/957279516?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">OnJuno Banking - Granny</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=29>
                    <div class="poster poster30" id="imagePoster30" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m18s898.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m18s898.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m44s609.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h26m48s939.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h27m19s449.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h27m31s892.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/JackDaniels/vlcsnap-2024-06-06-05h28m08s632.jpg"
                        data-long-video="https://player.vimeo.com/video/956876925?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video30" src="https://player.vimeo.com/video/957279345?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Jack Daniels x GQ</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=30>
                    <div class="poster poster31" id="imagePoster31" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/Copy%20of%20vlcsnap-2024-06-06-05h29m56s841.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/Copy%20of%20vlcsnap-2024-06-06-05h29m56s841.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m23s271.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m32s330.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m44s777.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m49s630.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/CompromisedVoiced/vlcsnap-2024-06-06-05h29m56s841.jpg"
                        data-long-video="https://player.vimeo.com/video/956878228?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video31" src="https://player.vimeo.com/video/957279868?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Compromised Voiced by Victoria Pedretti </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="DEVON SOLWOLD" data-index=31>
                    <div class="poster poster32" id="imagePoster32" style="background: url('https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m49s180.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h32m55s668.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m16s505.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m25s220.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/devon-solwold/PurpleDenim/vlcsnap-2024-06-06-05h33m45s885.jpg"
                        data-long-video="https://player.vimeo.com/video/956878134?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video32" src="https://player.vimeo.com/video/957352295?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">PURPLE DENIM - Daytrippin</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='EDITOR') || (isset($_GET['author']) && $_GET['author']=='ZACK PELLETIER')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=32>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m30s452.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m30s452.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m44s104.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m48s602.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h37m55s702.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h38m04s635.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/nflpa/vlcsnap-2024-06-06-05h38m28s576.jpg"
                        data-long-video="https://player.vimeo.com/video/956882063?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957286315?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">NFLPA - Rookie of the Year 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=33>
                    <div class="poster poster2" id="imagePoster2" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h16m58s970.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h16m58s970.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h17m07s973.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h17m40s458.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m09s640.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m22s999.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/nhl/vlcsnap-2024-06-08-01h18m29s867.jpg"
                        data-long-video="https://player.vimeo.com/video/957220307?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video2" src="https://player.vimeo.com/video/957286315?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">NHL - Hockey is Back</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=34>
                    <div class="poster poster3" id="imagePoster3" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h23m58s904.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h23m58s904.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m06s496.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m10s856.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h24m51s640.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h27m53s785.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/lecartel/vlcsnap-2024-06-08-01h28m05s001.jpg"
                        data-long-video="https://player.vimeo.com/video/956882092?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video3" src="https://player.vimeo.com/video/957286201?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Le Cartel - Fall/Winter Collection 2023</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=35>
                    <div class="poster poster4" id="imagePoster4" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m06s130.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m06s130.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m27s424.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m38s228.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m50s434.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h40m57s627.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/chrisbrownnightmare/vlcsnap-2024-06-06-05h41m13s136.jpg"
                        data-long-video="https://player.vimeo.com/video/956882658?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video4" src="https://player.vimeo.com/video/957346184?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                        <h2 class="title">Chris Brown - Nightmares</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="EDITOR" data-title="ZACK PELLETIER" data-index=36>
                    <div class="poster poster5" id="imagePoster5" style="background: url('https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m23s420.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m23s420.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m30s004.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m33s691.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m40s365.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h45m57s369.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/zack-pelletier/louisthechild/vlcsnap-2024-06-06-05h46m04s590.jpg"
                        data-long-video="https://player.vimeo.com/video/956882433?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video5" src="https://player.vimeo.com/video/957286086?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Louis the Child - How High</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='COLORIST') || (isset($_GET['author']) && $_GET['author']=='WILHENDS NORVIL')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=37>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m58s412.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m58s412.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h52m48s181.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m03s282.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m07s557.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m40s922.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/aircanada/vlcsnap-2024-06-06-05h53m45s881.jpg"
                        data-long-video="https://player.vimeo.com/video/957251275?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/956847894?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Air Canada - Canada Day</h2>
                </div>
            </div> 
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=38>
                    <div class="poster poster2" id="imagePoster2" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h56m38s685.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h56m38s685.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h55m42s681.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h55m47s076.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h55m55s712.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h56m04s790.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/mercedeseq/vlcsnap-2024-06-06-05h56m21s023.jpg"
                        data-long-video="https://player.vimeo.com/video/957251114?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video2" src="https://player.vimeo.com/video/956848128?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Mercedes EQ </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=39>
                    <div class="poster poster3" id="imagePoster3" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h49m34s068.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h49m34s068.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h49m42s363.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h49m49s891.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h49m58s422.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h50m08s067.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/pimbertendystelleri/vlcsnap-2024-06-06-05h50m08s067.jpg"
                        data-long-video="https://player.vimeo.com/video/957250945?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video3" src="https://player.vimeo.com/video/956849487?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Pembertyn Distillery </h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=40>
                    <div class="poster poster4" id="imagePoster4" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-05h59m28s683.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-05h59m28s683.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-05h59m48s752.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-06h00m12s861.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-06h00m28s967.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-06h00m43s872.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/famwithoutfamily/vlcsnap-2024-06-06-06h00m59s667.jpg"
                        data-long-video="https://player.vimeo.com/video/957252341?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video4" src="https://player.vimeo.com/video/957276970?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Fam Without Blood - SKIIFALL</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=41>
                    <div class="poster poster5" id="imagePoster5" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m30s258.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m30s258.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m36s419.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m39s698.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m43s380.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h05m54s939.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/gasoline/vlcsnap-2024-06-06-06h06m03s072.jpg"
                        data-long-video="https://player.vimeo.com/video/957250554?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video5" src="https://player.vimeo.com/video/957277740?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Gasoline - Apashe x Raga</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=42>
                    <div class="poster poster6" id="imagePoster6" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m26s465.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m26s465.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m33s864.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m37s017.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m40s507.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m47s000.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/emmanuel/vlcsnap-2024-06-06-06h07m51s821.jpg"
                        data-long-video="https://player.vimeo.com/video/957251422?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video6" src="https://player.vimeo.com/video/957279355?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Emanuelle - Valence</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="WILHENDS NORVIL" data-index=43>
                    <div class="poster poster7" id="imagePoster7" style="background: url('https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h09m56s475.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h09m56s475.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h10m05s155.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h10m12s951.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h10m16s331.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h10m26s375.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/wilhends-norvil/coldteashortfilm/vlcsnap-2024-06-06-06h10m38s726.jpg"
                        data-long-video="https://player.vimeo.com/video/957251983?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video7" src="https://player.vimeo.com/video/991787686?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Cold Tea - Short Film</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='COLORIST') || (isset($_GET['author']) && $_GET['author']=='MIKE DE LA LUZ')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=44>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h14m35s086.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h14m35s086.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h14m53s099.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h15m04s610.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h15m14s726.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h15m20s824.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/timhortons/vlcsnap-2024-06-06-06h15m39s171.jpg"
                        data-long-video="https://player.vimeo.com/video/957255740?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281230?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Tim Hortons - Recién Levantados Ver. 30 - STILLS</h2>
                </div>
            </div> 
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=45>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m07s484.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m07s484.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m28s603.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m32s332.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m35s812.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m43s003.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelacasicase/vlcsnap-2024-06-06-06h17m48s147.jpg"
                        data-long-video="https://player.vimeo.com/video/957256826?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281337?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Falabella - Cascais - STILLS</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=46>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m24s343.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m24s343.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m05s180.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m08s236.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m12s122.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m15s177.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/chervelotetraker/vlcsnap-2024-06-06-06h24m18s857.jpg"
                        data-long-video="https://player.vimeo.com/video/957256990?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281384?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Chevrolet Tracker</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=47>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m02s538.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m02s538.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m07s918.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m18s969.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m31s436.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m44s197.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/fellabelaparkas/vlcsnap-2024-06-06-06h50m50s014.jpg"
                        data-long-video="https://player.vimeo.com/video/957257054?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281433?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Falabella - Parkas</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=48>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h53m32s932.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h53m32s932.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h52m14s383.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h52m28s950.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h52m40s271.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h52m59s314.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/groupofontera/vlcsnap-2024-06-06-06h53m05s534.jpg"
                        data-long-video="https://player.vimeo.com/video/957257162?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281478?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Grupo Frontera x Bad Bunny - UN X100TO - STILLS</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=49>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m23s429.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m23s429.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m30s577.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m39s186.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m44s243.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m48s038.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/losbonkers/vlcsnap-2024-06-06-06h55m53s911.jpg"
                        data-long-video="https://player.vimeo.com/video/957258556?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281526?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Los Bunkers - REY - STILLS</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=50>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h56m55s475.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h56m55s475.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h57m02s176.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h57m06s655.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h57m12s834.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h57m17s006.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/losmenoras/vlcsnap-2024-06-06-06h57m39s323.jpg"
                        data-long-video="https://player.vimeo.com/video/957257601?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281580?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Los Mesoneros - Mas Tuyo - STILLS</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="COLORIST" data-title="MIKE DE LA LUZ" data-index=51>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h14m35s086.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h14m35s086.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h14m53s099.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h15m04s610.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h15m14s726.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h15m20s824.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/mike-de-da-luz/marshmelloyoung/vlcsnap-2024-06-06-06h15m39s171.jpg"
                        data-long-video="https://player.vimeo.com/video/957257785?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957281641?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Marshmello, Young Miko - Tempo - STILLS</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='SOUND') || (isset($_GET['author']) && $_GET['author']=='DOUSON')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="SOUND" data-title="DOUSON" data-index=52>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h03m26s969.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h03m26s969.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h05m28s226.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h05m43s761.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h06m46s781.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h07m52s174.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/douson/paradise/vlcsnap-2024-06-06-22h08m25s286.jpg"
                        data-long-video="https://player.vimeo.com/video/957260979?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/990819648?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Paradise</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="SOUND" data-title="DOUSON" data-index=53>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h19m44s292.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h19m44s292.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h19m54s175.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h20m22s541.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h20m38s027.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h20m45s819.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/douson/bmw/vlcsnap-2024-06-06-22h21m03s689.jpg"
                        data-long-video="https://player.vimeo.com/video/957244977?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/990819581?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">BMW</h2>
                </div>
            </div> 
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="SOUND" data-title="DOUSON" data-index=54>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h24m47s687.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h24m47s687.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h25m38s591.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h26m27s469.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h26m33s410.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h26m43s105.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/douson/F1Miami/vlcsnap-2024-06-06-22h26m49s029.jpg"
                        data-long-video="https://player.vimeo.com/video/957245515?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/990819613?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">F1 Miami</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="SOUND" data-title="DOUSON" data-index=55>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h29m51s766.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h29m51s766.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h30m22s232.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h30m28s240.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h30m47s534.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h31m01s317.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/douson/budlightjapan/vlcsnap-2024-06-06-22h31m14s354.jpg"
                        data-long-video="https://player.vimeo.com/video/957244725?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/990819625?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bud Light Japan</h2>
                </div>
            </div>
            <?php } ?>
            <?php if((isset($_GET['action']) && $_GET['action']=='VFX') || (isset($_GET['author']) && $_GET['author']=='JUMPER')){ ?>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="VFX" data-title="JUMPER" data-index=56>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h39m55s586.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h39m55s586.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m00s852.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m09s029.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m18s975.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m40s208.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m53s726.jpg"
                        data-long-video="https://player.vimeo.com/video/957232158?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957283013?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">When We Die - Yung Blud feat. Lil Yachty</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="VFX" data-title="JUMPER" data-index=57>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h42m50s539.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h42m50s539.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h43m01s342.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h43m25s967.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h43m45s187.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h43m53s244.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/jumper/botleg/vlcsnap-2024-06-06-22h44m15s181.jpg"
                        data-long-video="https://player.vimeo.com/video/957232430?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957283068?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">Bootleg - Mister V</h2>
                </div>
            </div>
            <div class="swiper-slide"> 
                <div class="innerSidesSlide" data-author="VFX" data-title="JUMPER" data-index=56>
                    <div class="poster poster1" id="imagePoster1" style="background: url('https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h39m55s586.jpg') no-repeat center center;"></div>
                    <div class="iframe" data-preview1="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h39m55s586.jpg"
                        data-preview2="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m00s852.jpg"
                        data-preview3="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m09s029.jpg"
                        data-preview4="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m18s975.jpg" 
                        data-preview5="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m40s208.jpg"
                        data-preview6="https://appollo.360cloudcenter.com/jumper/whenwedieyoung/vlcsnap-2024-06-06-22h40m53s726.jpg"
                        data-long-video="https://player.vimeo.com/video/957232158?autoplay=1&muted=1&loop=1"
                        >
                            <div class="modalFrame"></div>
                            <iframe id="video1" src="https://player.vimeo.com/video/957283013?autoplay=1&muted=1&loop=1&background=1&dnt=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <h2 class="title">When We Die - Yung Blud feat. Lil Yachty</h2>
                </div>
            </div>
            <?php } ?> 
          <?php } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <ul class="colorful-list" <?php if((isset($_GET['action']) && $_GET['action']=='COLORIST') || (isset($_GET['author']) && ($_GET['author']=='WILHENDS NORVIL' || $_GET['author']=='MIKE DE LA LUZ'))){ ?> style="display:inline-flex;" <?php }else{ ?> style="display:none;" <?php } ?> ></ul>
    <div class="editorsMain editorsLeftMain">
    <ul class="editorsLeft editors">
        <li><a>EDITOR</a></li>
        <li><a>COLORIST</a></li>
        <li><a>SOUND</a></li>
        <li><a>VFX</a></li>
        <li class="active" data-start=0><a>EDITOR</a></li>
        <li data-start=37><a>COLORIST</a></li>
        <li data-start=52><a>SOUND</a></li>
        <li data-start=56><a>VFX</a></li>
        <li><a>Editors</a></li>
        <li><a>COLORIST</a></li>
        <li><a>SOUND</a></li>
        <li><a>VFX</a></li>
    </ul>
    </div>
    <div class="editorsMain editorsRightMain">
    <ul class="editorsRight editors">
        <li><a>GRIFFIN OLIS</a></li>  
        <li><a>ALEX PETERSON</a></li>
        <li><a>DEVON SOLWOLD</a></li>
        <li><a>ZACK PELLETIER</a></li>
        <li><a>WILHENDS NORVIL</a></li>
        <li><a>MIKE DE LA LUZ</a></li>
        <li><a>DOUSON</a></li>
        <li><a>JUMPER</a></li>
        <li class="active" data-start=0><a>GRIFFIN OLIS</a></li>  
        <li data-start=10><a>ALEX PETERSON</a></li>
        <li data-start=18><a>DEVON SOLWOLD</a></li>
        <li data-start=32><a>ZACK PELLETIER</a></li>
        <li data-start=37><a>WILHENDS NORVIL</a></li>
        <li data-start=44><a>MIKE DE LA LUZ</a></li>
        <li data-start=52><a>DOUSON</a></li>
        <li data-start=56><a>JUMPER</a></li>
        <li><a>GRIFFIN OLIS</a></li>  
        <li><a>ALEX PETERSON</a></li>
        <li><a>DEVON SOLWOLD</a></li>
        <li><a>ZACK PELLETIER</a></li>
        <li><a>WILHENDS NORVIL</a></li>
        <li><a>MIKE DE LA LUZ</a></li>
        <li><a>DOUSON</a></li>
        <li><a>JUMPER</a></li>
    </ul>
    </div>
    
    <div class="modal fade show" id="videoModalPopup" tabindex="-1" aria-labelledby="videoModalPopupLabel" aria-hidden="true"> 
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button><label>APOLLO</label>
          </div>
          <div class="modal-body">
            <div class="videoSupport">
                <div class="popupVideo"></div> 
            </div>
            <ul class="screenshots">
                <li class="preview1">
                    <img src="">
                </li>
                <li class="preview2">
                    <img src="">
                </li> 
                <li class="preview3">
                    <img src="">
                </li>
                <li class="preview4">
                    <img src="">
                </li>
                <li class="preview5">
                    <img src="">
                </li>
                <li class="preview6">
                    <img src="">
                </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
    $(document).ready(function () {
        
        var pantoneColors = [
            "#FFB347",
            "#FF6961",
            "#77DD77",
            "#AEC6CF",
            "#FDFD96",
            "#CFCFC4",
            "#836953",
            "#F49AC2",
        ];
        function getRandomPantoneColor() {
            return pantoneColors[Math.floor(Math.random() * pantoneColors.length)];
        }
        
        var swiper = new Swiper('.swiper-container', {
            direction: 'vertical',
            loop: true,
            loopPreventsSliding: false,
            navigation: {
              nextEl: '.swiper-button-next', // Next arrow element
              prevEl: '.swiper-button-prev', // Previous arrow element
            },
            observer: true,
            parallax : false,
            effect: 'coverflow',
            grabCursor: true,
            mousewheel: false,
            centeredSlides: true,
            slidesPerView: 3,
            spaceBetween: 10,
            freeMode: false,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            on: {
                slideChangeTransitionStart: function () {
                    $('.colorful-list').html('');
                    for (let i = 0; i < 8; i++) {
                        $('.colorful-list').append(`<li style="background:${getRandomPantoneColor()}"></li>`);
                    }
                    var currentAuthor=$('.swiper-wrapper .swiper-slide-active .innerSidesSlide').attr('data-author');
                    var currentTitle=$('.swiper-wrapper .swiper-slide-active .innerSidesSlide').attr('data-title');
                    if(currentAuthor=='EDITOR'){
                        $('ul.editorsLeft.editors').animate({scrollTop: 185}, 500);
                    }
                    if(currentAuthor=='COLORIST'){
                        $('ul.editorsLeft.editors').animate({scrollTop: 275}, 500);
                        $('.colorful-list').attr('style','display:inline-flex;');
                    }else{
                        $('.colorful-list').hide();
                    }
                    if(currentAuthor=='SOUND'){
                        $('ul.editorsLeft.editors').animate({scrollTop: 355}, 500);
                    }
                    if(currentAuthor=='VFX'){
                        $('ul.editorsLeft.editors').animate({scrollTop: 410}, 500);    
                    }
                    if(currentTitle=='GRIFFIN OLIS'){
                        $('ul.editorsRight.editors').animate({scrollTop: 970}, 500);
                    }
                    if(currentTitle=='ALEX PETERSON'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1100}, 500);
                    }
                    if(currentTitle=='DEVON SOLWOLD'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1260}, 500);
                    }
                    if(currentTitle=='ZACK PELLETIER'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1410}, 500);
                    }
                    if(currentTitle=='WILHENDS NORVIL'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1570}, 500);
                    }
                    if(currentTitle=='MIKE DE LA LUZ'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1740}, 500);
                    }
                    if(currentTitle=='DOUSON'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1850}, 500);
                    }
                    if(currentTitle=='JUMPER'){
                        $('ul.editorsRight.editors').animate({scrollTop: 1930}, 500);  
                    }
                    $('.swiper-container').css('transform', 'scale(1)');
                    setTimeout(function () {
                        $('.swiper-container').css('transform', 'scale(1.2)');
                    }, 1000);
                },
                slideChangeTransitionEnd: function () {
                    
                }
            },
        });
        
        $('.swiper-container').css('transform', 'scale(1.2)');
        
        $('.swiper-container').on('wheel', function(event) {
            if(event.originalEvent.deltaY < 0){
               $('.swiper-button-prev').click();
            }else{
               $('.swiper-button-next').click();   
            }
        });
        
        $(document).on('click', 'ul.editorsLeft li', function() {
              var checkText=$(this).find('a').text();
              if(checkText=='EDITOR'){
                window.location.href = "/work/roster.php?action=EDITOR";
              }
              if(checkText=='COLORIST'){
                window.location.href = "/work/roster.php?action=COLORIST";
              }
              if(checkText=='SOUND'){
                window.location.href = "/work/roster.php?action=SOUND";
              }
              if(checkText=='VFX'){
                window.location.href = "/work/roster.php?action=VFX";
              }
        });
        
        $(document).on('click', 'ul.editorsRight li', function() {
              var checkText=$(this).find('a').text();
              if(checkText=='GRIFFIN OLIS'){
                  window.location.href = "/work/roster.php?author=GRIFFIN OLIS";
              }
              if(checkText=='ALEX PETERSON'){
                window.location.href = "/work/roster.php?author=ALEX PETERSON";
              }
              if(checkText=='DEVON SOLWOLD'){
                window.location.href = "/work/roster.php?author=DEVON SOLWOLD";
              }
              if(checkText=='ZACK PELLETIER'){
                window.location.href = "/work/roster.php?author=ZACK PELLETIER";
              }
              if(checkText=='WILHENDS NORVIL'){
                window.location.href = "/work/roster.php?author=WILHENDS NORVIL";
              }
              if(checkText=='MIKE DE LA LUZ'){
                window.location.href = "/work/roster.php?author=MIKE DE LA LUZ";
              }
              if(checkText=='DOUSON'){
                window.location.href = "/work/roster.php?author=DOUSON";
              }
              if(checkText=='JUMPER'){
                window.location.href = "/work/roster.php?author=JUMPER";
              }
        });
        
        $(document).on('click', 'div.swiper-slide-active div.innerSidesSlide div.iframe div.modalFrame', function() {
            var currentAuthor=$('.swiper-wrapper .swiper-slide-active .innerSidesSlide').attr('data-author');
              var preview1=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview1');
              var preview2=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview2');
              var preview3=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview3');
              var preview4=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview4');
              var preview5=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview5');
              var preview6=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-preview6');
              var longVideo=$('.swiper-slide-active .innerSidesSlide .iframe').attr('data-long-video');
              $('#videoModalPopup div.popupVideo').html(`<iframe src="`+longVideo+`" frameborder="0" allow="autoplay" allowfullscreen></iframe>`);
              $('#videoModalPopup li.preview1 img').attr('src',preview1);
              $('#videoModalPopup li.preview2 img').attr('src',preview2);
              $('#videoModalPopup li.preview3 img').attr('src',preview3);
              $('#videoModalPopup li.preview4 img').attr('src',preview4);
              $('#videoModalPopup li.preview5 img').attr('src',preview5);
              $('#videoModalPopup li.preview6 img').attr('src',preview6);
              $('#videoModalPopup').modal('show'); 
        });
        
    });
    
    </script>
</body>
</html>
