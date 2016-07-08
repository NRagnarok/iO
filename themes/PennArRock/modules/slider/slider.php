<?php
function slider($id = 1){
	?>
 <section id="accueil">	
		<div id="main-slider" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#main-slider" data-slide-to="0" class="active"></li>
				<li data-target="#main-slider" data-slide-to="1"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<img class="img-responsive" src="themes/PennArRock/images/slider/slide1.jpg" alt="slider">						
					<div class="carousel-caption">
						<h2>Soyez présent à notre prochain événement !</h2>
						<h4>Demi tarif 4,50€ / Plein tarif 6€</h4>
						<a href="billetterie">Obtenez vos tickets ! <i class="fa fa-angle-right"></i></a>
					</div>
				</div>
				<div class="item">
					<img class="img-responsive" src="themes/PennArRock/images/slider/slide2.jpg" alt="slider">	
					<div class="carousel-caption">
						<h2>Tremplin 2016 </h2>
						<h4>Pour permettre le développement de la scène local</h4>
						<a href="tremplin-2016">Découvrez le tremplin ! <i class="fa fa-angle-right"></i></a>
					</div>
				</div>		
			</div>
		</div>    	
    </section>
	<!--/#home-->

	<section id="prochain-evenement">
		<div class="container">
			<div class="row">
				<div class="watch">
					<img class="img-responsive" src="themes/PennArRock/images/watch.png" alt="">
				</div>				
				<div class="col-md-4 col-md-offset-2 col-sm-5">
					<h2>le prochain événement</h2>
				</div>				
				<div class="col-sm-7 col-md-6">					
					<ul id="countdown">
						<li>					
							<span class="days time-font">00</span>
							<p>jours </p>
						</li>
						<li>
							<span class="hours time-font">00</span>
							<p class="">heures </p>
						</li>
						<li>
							<span class="minutes time-font">00</span>
							<p class="">minutes</p>
						</li>
						<li>
							<span class="seconds time-font">00</span>
							<p class="">secondes</p>
						</li>				
					</ul>
				</div>
			</div>
			<div class="cart">
				<a href="billetterie"><i class="fa fa-shopping-cart"></i> <span>Billetterie</span></a>
			</div>
		</div>
	</section><!--/#explore-->

	<section id="artiste-du-mois">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-9">
					<div id="event-carousel" class="carousel slide" data-interval="false">
						<h2 class="heading">L'artiste du mois</h2>
						<a class="even-control-left" href="#event-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="even-control-right" href="#event-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner">
							<div class="item active">
								<div class="row">
									<div class="col-sm-4">
										<div class="single-event">
											<a href="carrox"><img class="img-responsive" src="themes/PennArRock/images/artistes/carrox.png" alt="event-image">
											<h4>Carrox</h4></a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="single-event">
											<a href="sweet-monsters"><img class="img-responsive" src="themes/PennArRock/images/artistes/sm.png" alt="event-image">
											<h4>Sweet Monsters</h4></a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="single-event">
											<a href="thalamos"><img class="img-responsive" src="themes/PennArRock/images/artistes/thalamos.png" alt="event-image">
											<h4>Thalamos</h4></a>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="row">
									<div class="col-sm-4">
										<div class="single-event">
											<a href="st-ht"><img class="img-responsive" src="themes/PennArRock/images/artistes/stoht.png" alt="event-image">
											<h4>Stöht</h4></a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="single-event">
											<a href="the-new-fail"><img class="img-responsive" src="themes/PennArRock/images/artistes/tnf.png" alt="event-image">
											<h4>The New Fail</h4></a>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="single-event">
											<a href="liikofa"><img class="img-responsive" src="themes/PennArRock/images/artistes/liikofa.png" alt="event-image">
											<h4>Liikofa</h4></a>
										</div>
									</div>
								</div>
							</div>
							<div class="item">
								<div class="row">
									<div class="col-sm-4">
										<div class="single-event">
											<a href="le-ka"><img class="img-responsive" src="themes/PennArRock/images/artistes/leika.png" alt="event-image">
											<h4>Leïka</h4></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</section><!--/#event-->

	<section id="a-propos">
		<div class="guitar2">				
			<img class="img-responsive" src="themes/PennArRock/images/guitare.png" alt="guitar">
		</div>
		<div class="about-content">					
					<h2>A Propos</h2>
					<p>    <b>L’association Penn Ar Rock a pour but de promouvoir la scène émergente locale. Créée en 2014, l’association peut compter sur une vingtaine de bénévoles tous motivés.</b></p>

<p>Avec la Soirée Pop/Rock et le Tremplin Penn Ar Rock (Septembre 2015), l’association travaille pour les groupes finistériens dans leur envie de réussir.</p><p>Nous effectuons des conseils sur demande pour les groupes: création d’affiche, CD, clips, … N’hésitez pas à nous contacter si vous êtes intéressé.</p><p>A très vite sur les scènes Finistérienne!</p>
					<a href="billetterie" class="btn btn-primary">Billetterie <i class="fa fa-angle-right"></i></a>
				</div>
		
	</section><!--/#about-->
	
	<section id="partenaires">
		<div id="sponsor-carousel" class="carousel slide" data-interval="false">
			<div class="container">
				<div class="row">
					<div class="col-sm-10">
						<h2>Les Partenaires</h2>			
						<a class="sponsor-control-left" href="#sponsor-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
						<a class="sponsor-control-right" href="#sponsor-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
						<div class="carousel-inner">
							<div class="item active">
								<ul>
									<li><a href="http://www.brest.fr/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/brest.png" alt=""></a></li>
									<li><a href="https://www.cmb.fr/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/cmb.png" alt=""></a></li>
									<li><a href="http://www.kerlune.fr/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/kerlune.png" alt=""></a></li>
								</ul>
							</div>
							<div class="item">
								<ul>
									<li><a href="http://www.lunison.fr/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/lunison.png" alt=""></a></li>
									<li><a href="http://pollyprod.bigcartel.com/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/polly.png" alt=""></a></li>
                                    <li><a href="http://www.lasergame-brest.fr/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/laser.png" alt=""></a></li>
								</ul>
							</div>
                            <div class="item">
								<ul>
									<li><a href="http://www.cultura.com/" target="_blank"><img class="img-responsive" src="themes/PennArRock/images/partenaires/cultura.png" alt=""></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</section><!--/#sponsor-->

	<section id="contact">
		<div class="contact-section">
			<div class="container">
				<div class="row">
					<div class="col-sm-3">
						<div class="contact-text">
							<h3>Nous contacter</h3>
							<address>
								E-mail: contact@penn-ar-rock.fr<br>
							</address>
						</div>
						<div class="contact-address">
							<h3>Adresse</h3>
							<address>
								Association Penn Ar Rock<br>
								28 rue de Kerzudal<br>
								29200  BREST
							</address>
						</div>
					</div>
					<div class="col-sm-9">
						<div id="contact-section">
							<h3>Nous envoyer un message</h3>
					    	<div class="status alert alert-success" style="display: none"></div>
					    	<?php contact("minimal"); ?>       
					    </div>
					</div>
				</div>
			</div>
		</div>		
	</section>
    <!--/#contact-->
    	<script>
		function menuToggle()
	{
		var windowWidth = $(window).width();

		if(windowWidth > 924 ){
			$(window).on('scroll', function(){
				if( $(window).scrollTop()>405 ){
					$('.main-nav').addClass('fixed-menu animated slideInDown');
				} else {
					$('.main-nav').removeClass('fixed-menu animated slideInDown');
				}
			});
		}else{
			
			$('.main-nav').addClass('fixed-menu animated slideInDown');
				
		}
	}

	menuToggle();
	
	$( window ).resize(function() {
		menuToggle();
	});
	
	menuMax = 1;
  </script>
	<?php
}
?>