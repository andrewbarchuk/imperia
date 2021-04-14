<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ieverly
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<header id="masthead" class="site__header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-2 col-lg-3 col-md-4 col-8 static">
						<div class="site__header-box">
							<div class="site__header-branding">
								<?php the_custom_logo(); ?>
							</div>

							<?php if ( is_active_sidebar( 'language' ) ) : ?>
								<!-- switcher -->
								<?php dynamic_sidebar( 'language' ); ?>
							<?php endif; ?>
						</div>
					</div>

					<div class="col-xl-10 col-lg-9 col-md-8 col-4 static">
						<div id="site-navigation" class="site__header-navigation">
							<button class="site__header-menu-button" aria-controls="primary-menu" aria-expanded="false">
								<b></b>
								<b></b>
								<b></b>
							</button>

							<div class="site__header-nav-box">
								<div class="container">
									<nav class="site__header-menu">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'header',
											)
										);
										?>
									</nav>

									<nav class="site__social-menu">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'social',
											)
										);
										?>
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
