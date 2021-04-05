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
					<div class="col-6 col-md-3 col-lg-2">
						<div class="site__header-branding">
							<?php the_custom_logo(); ?>
						</div>
					</div>

					<div class="col-6 col-md-9 col-lg-10">
						<div class="site__header-box">
							<nav class="site__header-menu">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'header',
									)
								);
								?>
							</nav>

							<button class="site__header-menu-button">
								<b></b>
								<b></b>
								<b></b>
							</button>
						</div>
					</div>
				</div>
			</div>
		</header>
