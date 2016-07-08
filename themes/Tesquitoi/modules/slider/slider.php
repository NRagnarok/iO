<?php
function slider($id = 1){
	?>
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	     <!-- Full Page Image Background Carousel Header -->
    <div id="sliderPrincipal" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#sliderPrincipal" data-slide-to="0" class="active"></li>
            <!--<li data-target="#sliderPrincipal" data-slide-to="1"></li>
            <li data-target="#sliderPrincipal" data-slide-to="2"></li>
            <li data-target="#sliderPrincipal" data-slide-to="3"></li>
            <li data-target="#sliderPrincipal" data-slide-to="4"></li>
            <li data-target="#sliderPrincipal" data-slide-to="5"></li>
            <li data-target="#sliderPrincipal" data-slide-to="6"></li>
            <li data-target="#sliderPrincipal" data-slide-to="7"></li>-->
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active"><div class="fill" style="background-image:url('ressources/slider/slide-1.jpg');"></div>
            	<div class="carousel-caption"><h2><div class="fb-page" data-href="https://www.facebook.com/tesquitoi" data-width="500" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><img src="themes/Tesquitoi/img/logo.png"></div></div></h2></div>
            </div>
            
            <!--<div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-2.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-3.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-4.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-5.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-6.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-7.jpg');"></div></div>
            
            <div class="item"><div class="fill" style="background-image:url('ressources/slider/slide-8.jpg');"></div></div>-->
            
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#sliderPrincipal" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#sliderPrincipal" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </div>
	
	<?php
}
?>