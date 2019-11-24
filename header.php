<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<title><?php wp_title( '|', true, 'right' ); ?><?php echo bloginfo( 'name' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" />
	
	<!-- Media Queries -->
	<meta name ="viewport" content ="width=device-width, minimum-scale=1.0, initial-scale=1.0">
	
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/includes/ie/ie.css" />
	<![endif]-->

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<?php 
    $is_5th_anniversary = false; // is_page_template( "home.php" );
    if( $is_5th_anniversary ): ?>

	<!-- Video goes here, more at bottom of file -->

	<!--[if lt IE 9]>
	<script>document.createElement('video');</script>
	<![endif]-->
	<link href='http://fonts.googleapis.com/css?family=Roboto:100' rel='stylesheet' type='text/css'>
	<style>
	  html {
	    background: #0e0e09;
	  }
	
		video { 
			display: block; /* goes with IE<9 hack */
		}

		body {
		  margin: 0;
		  padding: 0;
		}
		
		.main-wrapper {
			background: #fff;
			padding: 0 20px;
		}
		
		video { 
		  position: fixed;
		  bottom: 0;
		  left: 0;
		  min-width: 100%;
		  min-height: 100%;
		  width: auto;
		  height: auto;
		  z-index: -100;
		  background: url('<?php echo get_stylesheet_directory_uri(); ?>/img/UCL_5th_typing.png') no-repeat;
		  background-size: cover;
		  transition: 1s opacity;
		  opacity: 0.75;
		}
		.stopfade { 
		   opacity: 0.35;
    }
    
		#polina-wrapper {
			position: fixed;
			top: 0;
			z-index: -99;
			width: 100%;
			height: calc(100% - 218px);
			padding-top: 1em;
		}
		#polina {
		  max-width: 499px;
		  margin: 0 auto;
		  font-family: 'Alegreya SC', serif;
		  clear: left;
		  /* vertical centering */
			margin: auto;
			position: absolute;
			top: 0; left: 0; bottom: 0; right: 0;
			height: 358px;
		}
		
		#polina p {
		  color: rgb(253,255,209);
		  text-transform: uppercase;
		  text-align: center;
		  font-size: 40px;
		  line-height: 1.2;
		}
		
		#slide1 {
			margin-top: 100px;
		}
		
		#slide2 {
			margin-top: 80px;
		}
		
		#slide2, #slide3, #slide4 {
			display: none;
		}
		
		#polina-wrapper button { 
		  display: block;
		  padding: 0.5em;
		  border: none;
		  margin-left: 1em;
		  font: 22px 'Alegreya SC', serif;
		  background: #40403E;
		  color: #fff;
		  cursor: pointer;
		  transition: .3s opacity;
		  float: left;
		  opacity: 0.5;
		}
		#polina-wrapper button:hover { 
		   opacity: 0.8;
		}
		#polina p#scroll-down {
      text-transform: none;
      font-family: 'Roboto', sans-serif;
      font-size: 18px;
      font-weight: 100;
      margin: 0;
      position: absolute;
      width: 100%;
      bottom: -60px;
    }

		@media screen and (max-width: 600px) { 
		  #polina { width:70%; }
		}
		@media screen and (max-device-width: 800px), all and (max-height: 585px) {
		  #bgvid, #polina-wrapper, #scroll-down { display: none; }
		  .main-wrapper { margin-top: 0 !important; }
		}
	</style>

	<video autoplay muted id="bgvid"
		poster="<?php echo get_stylesheet_directory_uri(); ?>/img/UCL_5th_typing.png">
		  <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
		<source src="<?php echo get_stylesheet_directory_uri(); ?>/img/UCL_5th_typing.webm" type="video/webm">
		<source src="<?php echo get_stylesheet_directory_uri(); ?>/img/UCL_5th_typing.mp4" type="video/mp4">
	</video>
	<div id="polina-wrapper">
		<!--<button>Pause</button>-->
		<div id="polina">
			<p id="slide1">Happy anniversary from all of us upstarts to all of you!</p>
			<p id="slide2">It's been five wonderful years.</p>
			<p id="slide3">We couldn't have done it without you.</p>
			<div id="slide4">
			    <img src="<?php echo site_url(); ?>/wp-content/uploads/2014/10/Upstart-5thAnn-Illust.png"
				    alt="Upstart Crow 5th Anninversary">
			</div>
			<p id="scroll-down">Scroll down to see our new site</p>
		</div>
	</div>
  
	<script>
	
	    var vid = document.getElementById("bgvid");
	    //var pauseButton = document.querySelector("#polina-wrapper button");

	    function vidFade() {
	      vid.classList.add("stopfade");
	    }

	    vid.addEventListener('ended', function() {
	      // only functional if "loop" is removed 
	      vid.pause();
	      // to capture IE10
	      vidFade();
	    }); 

        /*
	    pauseButton.addEventListener("click", function() {
	      vid.classList.toggle("stopfade");
	      if (vid.paused) {
		    vid.play();
		    pauseButton.innerHTML = "Pause";
	      } else {
		    vid.pause();
		    pauseButton.innerHTML = "Paused";
	      }
	    });
        */
	</script>

<?php endif; ?>


	<!--Main Wrapper -->
	<div class="main-wrapper">
		<div class="header-wrapper full-width">
			<div class="header-hidden-wrap">
				<div class="header-hidden-toggle-wrap">
					<div class="header-hidden clearfix">
						<div class="header-hidden-left">
							<?php if ( get_option( 'okay_theme_customizer_hidden_text' ) ) { ?>
								<?php echo get_option( 'okay_theme_customizer_hidden_text' ); ?>
							<?php } ?>
						</div>
						<div class="header-hidden-right">
							<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Header Toggle Icons') ) : else : ?>		
							<?php endif; ?>
						</div>
					</div><!-- header hidden -->
					<a href="#" class="hidden-toggle"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>
				</div><!-- header hidden toggle wrap -->
			</div><!-- header hidden wrap -->
			
			<div class="header clearfix">
				<div class="header-left">
					<!-- grab the logo -->
					<?php if ( get_option( 'okay_theme_customizer_logo' ) ) { ?>
						<h1 class="logo">
							<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo get_option('okay_theme_customizer_logo'); ?>" alt="<?php the_title(); ?>" /></a>
						</h1>
					<?php } else { ?>
					    <h1 class="logo-text">
					    	<a href="<?php echo home_url( '/' ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name') ?></a>
					    </h1>
					<?php } ?>
				</div>
				
				<!-- Menu -->
				<div class="header-right">
				    <h2>The best books start here.</h2>
					<?php wp_nav_menu( array( 'theme_location' => 'header', 'menu_id' => 'nav', 'menu_class' => 'nav' ) ); ?>
				</div>
			</div><!-- header -->
		</div><!-- header wrapper -->



<?php if( $is_5th_anniversary ): ?>
	<script>
		(function($) {
			$('.main-wrapper').css('margin-top',
				$(window).height() - $('.header-wrapper').height() + 'px');
			
			var d = 2500; // slide duration in ms
			var f = 500;  // fade transition duration in ms
			
			// Callback heaven
			$('#slide1').delay(5000).fadeOut(f, function() {
				$('#slide2').fadeIn(f, function() {
					$('#slide3').delay(1000).fadeIn(f, function() {
						$('#slide2, #slide3').delay(4000).fadeOut(f, function() {
							$('#slide4').fadeIn(f);
						});
					});
				});
			});
			
			// Fade message on scroll
			$(window).scroll(function() {
			  var top = document.body.scrollTop;
			  if(top < 900 && top != 0) {
			    var level = 55 * 1/top;
			    $('#scroll-down').css('opacity', level);
			  }
			});
			
		})(jQuery);
	</script>
<?php endif; ?>
