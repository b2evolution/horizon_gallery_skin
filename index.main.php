<?php
/**
 * This is the main/default page template for the "Horizon" skin.
 *
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific displays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage bootstrap_gallery_skin
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}
global $Skin;
// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );
// Check if current page has a big picture as background
$is_pictured_page = in_array( $disp, array( 'front', 'login', 'register', 'lostpassword', 'activateinfo', 'access_denied' ) );
// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array(
		'arcdir_text'     => T_('Index'),
		'catdir_text'     => T_('Galleries'),
		'category_text'   => T_('Gallery').': ',
		'categories_text' => T_('Galleries').': ',
	) );
// Include Google Fonts code inside ""
echo "<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>";
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>

<div id="bg_picture">
	<header class="row">
		<?php
			// ------------------------- "Page Top" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			widget_container( 'page_top', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start'     => '<div class="evo_container $wico_class$ col-lg-12">',
					'container_end'       => '</div>',
					'block_start'         => '<div class="evo_widget $wi_class$">',
					'block_end'           => '</div>',
					'block_display_title' => false,
					'list_start'          => '<ul>',
					'list_end'            => '</ul>',
					'item_start'          => '<li>',
					'item_end'            => '</li>',
				) );
			// ----------------------------- END OF "Page Top" CONTAINER -----------------------------
		?>

	<?php
		// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
		// Display container and contents:
		widget_container( 'header', array(
				// The following params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				'container_start'   => '<div class="evo_container $wico_class$ col-lg-12">',
				'container_end'     => '</div>',
				'block_start'       => '<div class="evo_widget $wi_class$">',
				'block_end'         => '</div>',
				'block_title_start' => '<h1>',
				'block_title_end'   => '</h1>',
			) );
		// ----------------------------- END OF "Header" CONTAINER -----------------------------
	?>
	</header>
</div>

<div class="evo_container evo_container__menu">
<!-- BLOG NAVIGATION MENU -->
		<nav class="col-md-12">
			<div class="drop">
				<input type="checkbox" id="toggle" />
				<label for="toggle" class="toggle" onclick></label>
		<?php
			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			// Note: this container is designed to be a single <ul> list
			widget_container( 'menu', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start'     => '<ul class="menu evo_container $wico_class$">',
					'container_end'       => '</ul>',
					'block_start'         => '',
					'block_end'           => '',
					'block_display_title' => false,
					'list_start'          => '',
					'list_end'            => '',
					'item_start'          => '<li class="evo_widget $wi_class$">',
					'item_end'            => '</li>',
					'item_selected_start' => '<li class="active evo_widget $wi_class$">',
					'item_selected_end'   => '</li>',
					'item_title_before'   => '',
					'item_title_after'    => '',
				) );
			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
		?>
			</div>
		</nav>
</div>


<div class="container">
	<?php
		if( $disp == 'single' )
		{ // ------------------- NAVIGATION BAR FOR ALBUM(POST) -------------------
			if( $single_Item = & mainlist_get_item() )
			{ // Get Item here, because it can be not defined yet, e.g. in Preview mode
	?>
	<div class="nav_album">		

		<span class="nav_album_title">
	<?php
		$single_Item->edit_link( array( // Link to backoffice for editing
				'before'    => '',
				'after'     => '',
				'text'      => get_icon( 'edit' ),
				'title'     => T_('Edit title/description...'),
			) );
		$single_Item->title( array(
				'link_type' => 'permalink',
				'before'    => '',
				'after'     => '',
			) );
		if( $Skin->enabled_status_banner( $Item->status ) )
		{ // Status banner
			$single_Item->status( array(
					'before' => '',
					'after'  => '',
					'format' => 'styled',
					'class'  => 'badge',
				) );
		}
	?>
		</span><!-- ../nav_album_title -->
	
	<div class="nav_album_navi">
		<div class="all_albums_div">
			<a href="<?php $Blog->disp( 'url', 'raw' ) ?>" title="<?php echo format_to_output( T_('All Albums'), 'htmlattr' ); ?>" class="all_albums hvr-icon-back">All Albums</a>
		</div>
<?php
	// ------------------- PREV/NEXT POST LINKS (SINGLE POST MODE) -------------------
	item_prevnext_links( array(
			'template' => '$prev$$next$',
			'block_start' => '<div class="nav_album_arrows">',
			'next_class' => 'fa-arrow-circle-right',
			'next_start'  => '',
			'next_text' => get_icon( '' ),
			'next_no_item' => '',
			'next_end'    => '',
			'prev_class' => 'fa-arrow-circle-left',
			'prev_start'  => '',
			'prev_text' => get_icon( '' ),
			'prev_no_item' => '',
			'prev_end'    => '',
			'block_end'   => '</div>',
		) );
	// ------------------------- END OF PREV/NEXT POST LINKS -------------------------
?>
	</div><!-- ../nav_album_navi -->
	<div class="clear"></div>
	</div><!-- ../nav_album -->

	<?php
		}
	} // ------------------- END OF NAVIGATION BAR FOR ALBUM(POST) ------------------- ?>

<div class="row">	

	<div class="<?php echo in_array( $disp, array( 'catdir', 'posts', 'single', 'page', 'mediaidx' ) ) ? '' : '' ?>">

		<main><!-- This is were a link like "Jump to main content" would land -->

		<!-- ================================= START OF MAIN AREA ================================== -->

		<?php
		// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
		messages( array(
				'block_start' => '<div class="action_messages">',
				'block_end'   => '</div>',
			) );
		// --------------------------------- END OF MESSAGES ---------------------------------
		?>
		<div class="col-lg-12">
		
		<?php
		// ------------------------- TITLE FOR THE CURRENT REQUEST -------------------------
		request_title( array(
				'title_before'      => '<h2>',
				'title_after'       => '</h2>',
				'title_none'        => '',
				'glue'              => ' - ',
				'title_single_disp' => false,
				'format'            => 'htmlbody',
				'arcdir_text'       => T_('Index'),
				'catdir_text'       => '',
				'category_text'     => T_('Gallery').': ',
				'categories_text'   => T_('Galleries').': ',
				'user_text'         => '',
			) );
		// ------------------------------ END OF REQUEST TITLE -----------------------------
		?>

		<?php
		// Go Grab the featured post:
		if( $Item = & get_featured_Item() )
		{ // We have a featured/intro post to display:
			// ---------------------- ITEM BLOCK INCLUDED HERE ------------------------
			echo '<div class="panel panel-default"><div class="panel-body">';
			skin_include( '_item_block.inc.php', array(
					'feature_block' => true,
					'content_mode' => 'full', // We want regular "full" content, even in category browsing: i-e no excerpt or thumbnail
					'intro_mode'   => 'normal',	// Intro posts will be displayed in normal mode
					'item_class'   => 'featured_post',
				) );
			echo '</div></div>';
			// ----------------------------END ITEM BLOCK  ----------------------------
		}
		?>

		<?php
		if( $disp == 'single' || $disp == 'page' )
		{ // --------------------------------- START OF A POST -----------------------------------
			// Display message if no post:
			display_if_empty();
			if( isset( $single_Item ) )
			{ // Use Item that already is defined above
				$Item = & $single_Item;
			}
			else
			{ // Get next Item object
				$Item = & mainlist_get_item();
			}
			if( $Item )
			{
				// ---------------------- ITEM BLOCK INCLUDED HERE ------------------------
				skin_include( '_item_block.inc.php', array(
						'content_mode'  => 'full', // We want regular "full" content, even in category browsing: i-e no excerpt or thumbnail
					) );
				// ----------------------------END ITEM BLOCK  ----------------------------
			}
		} // ---------------------------------- END OF A POST ------------------------------------
		?>

		</div>

		<?php
			// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
			skin_include( '$disp$', array(
					'disp_single'          => '',		// We already handled this case above
					'disp_page'            => '',		// We already handled this case above
					'mediaidx_thumb_size'  => $Skin->get_setting( 'mediaidx_thumb_size' ),
					'author_link_text'     => 'preferredname',
					// Login
					'login_page_before'    => '<div class="login_block"><div class="evo_details">',
					'login_page_after'     => '</div></div>',
					// Register
					'register_page_before' => '<div class="login_block"><div class="evo_details">',
					'register_page_after'  => '</div></div>',
					'display_abort_link'   => ( $Blog->get_setting( 'allow_access' ) == 'public' ), // Display link to abort login only when it is really possible
				) );
			// Note: you can customize any of the sub templates included here by
			// copying the matching php file into your skin directory.
			// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
		?>
		
		<?php
		if( $disp != 'catdir' )
		{ // Don't display the pages on disp=catdir because we don't have a limit by page there
			// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
			mainlist_page_links( array(
					'block_start' => '<div class="nav_pages">',
					'block_end' => '</div>',
					'prev_text' => '&lt;&lt;',
					'next_text' => '&gt;&gt;',
				) );
			// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
		}
		?>

		</main>

	</div><!-- .col -->
</div><!-- .row -->
</div><!-- .container -->

<div class="footer-wrapper">
<footer class="row">
	<!-- =================================== START OF FOOTER =================================== -->
	<div class="container">
		<div class="col-md-12">

		<?php
			// ------------------------- "Footer" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			widget_container( 'footer', array(
					// The following params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					'container_start'   => '<div class="evo_container $wico_class$">',
					'container_end'     => '</div>',
					'block_start'       => '<div class="evo_widget $wi_class$">',
					'block_end'         => '</div>',
				) );
			// ----------------------------- END OF "Header" CONTAINER -----------------------------
		?>

		<p class="center">
			<?php
				// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
						'before' => '',
						'after'  => ' &bull; ',
					) );
			?>

			<?php
				// Display a link to contact the owner of this blog (if owner accepts messages):
				$Blog->contact_link( array(
						'before' => '',
						'after'  => ' &bull; ',
						'text'   => T_('Contact'),
						'title'  => T_('Send a message to the owner of this blog...'),
					) );
				// Display a link to help page:
				$Blog->help_link( array(
						'before'      => ' ',
						'after'       => ' ',
						'text'        => T_('Help'),
					) );
			?>

			<?php
				// Display additional credits:
				// If you can add your own credits without removing the defaults, you'll be very cool :))
				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
				credits( array(
						'list_start'  => '&bull;',
						'list_end'    => ' ',
						'separator'   => '&bull;',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );
			?>
		</p>

		<?php
			// Please help us promote b2evolution and leave this logo on your blog:
			powered_by( array(
					'block_start' => '<div class="powered_by">',
					'block_end'   => '</div>',
					// Check /rsc/img/ for other possible images -- Don't forget to change or remove width & height too
					'img_url'     => '$rsc$img/powered-by-b2evolution-120t.gif',
					'img_width'   => 120,
					'img_height'  => 32,
				) );
		?>
		</div><!-- .col -->
	</div><!-- .container -->
	
</footer><!-- .row -->
</div>

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// ------------------------------- END OF FOOTER --------------------------------
?>