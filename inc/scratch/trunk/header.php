y<?php
	/**
	 * The header for our theme
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package archive
	 */
	
	?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri();?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri();?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri();?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri();?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri();?>/img/favicon/safari-pinned-tab.svg" color="#0d6efd">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Loads the internal WP jQuery -->
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_head(); ?>
	
<body <?php body_class(); ?>>

    <div id="to-top"></div>

    <div id="page" class="site">

        <header id="masthead" class="site-header">

            <nav id="nav-main" class="navbar navbar-expand-lg fixed-top border-bottom border-dark bg-white">

                <div class="backdrop-overlay"></div>

                <div class="container">


                    <!-- Top Nav Widget -->
                    <div class="top-nav order-lg-3 flex-grow-1 flex-lg-grow-0 d-flex justify-content-start">
                        <?php if ( is_active_sidebar( 'top-nav' )) : ?>
                        <div>
                            <?php dynamic_sidebar( 'top-nav' ); ?>
                        </div>
                        <?php endif; ?>
                    </div>

					
		
				<div class="d-block d-sm-none">
					<a href="<?php echo home_url() ?>"> <i class="fas fa-home"></i></a>
					</div>
				

                    <!-- Top Nav Search Mobile
                    <div class="d-block d-md-none ms-2">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-dropdown right" type="button" id="dropdown-search" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-search"></i>
                            </button>
                            <div class="dropdown-search dropdown-menu position-fixed border-0 bg-light rounded-0 start-0 end-0" aria-labelledby="dropdown-search">
                                <div class="container">
                                    <div class="mb-2">
                                       <form class="searchform input-group" method="get" action="<?php ?>">
                                         <input type="text" name="s" class="form-control" placeholder="Search">
										</form>
                                    </div>
                                </div>
                           </div>
                         </div>
					</div> -->

                    <button class="navbar-toggler right border-warning py-2 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvas-menu-right" aria-expanded="false" aria-controls="offcanvas-menu-right">
                        <i class="text-secondary fas fa-bars"></i>
                    </button>


                    <div class="offcanvas expand-lg offcanvas-end flex-fill" data-bs-body="backdrop" tabindex="-1" id="offcanvasRight">
                        <a href="javascript:void(0)" class="offcanvas-header expand-lg bg-light underline-0" data-bs-toggle="offcanvas">
                            <i class="fas fa-chevron-left"></i> <?php esc_html_e('Close menu' , 'archive'); ?>
                        </a>
                        <div class="offcanvas-body expand-lg">

                            <!-- Wp Bootstrap Nav Walker -->
                            <?php
						
							wp_nav_menu( array(
                                    'theme_location'    => is_user_logged_in() ? 'logged-in' : 'logged-out',
                                    'depth'             => 2,
                                    'container'         => 'div',
                                    'container_class'   => 'bs-nav',
                                    'container_id'      => 'archive-navbar',
                                    'menu_class'        => 'nav navbar-nav justify-content-end',
                                    'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker'            => new bootstrap_5_wp_nav_menu_walker(),
                                ) );
						
                            ?>

                        </div>
                    </div><!-- offcanvas -->

                    <!-- Top Nav Search Large -->
                    <div class="top-nav-search-lg d-none d-lg-block order-lg-3 ms-2">
                        <?php if ( is_active_sidebar( 'top-nav-search' )) : ?>
                        <div>
                            <?php dynamic_sidebar( 'top-nav-search' ); ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div><!-- container -->

            </nav>

        </header><!-- #masthead -->

    
