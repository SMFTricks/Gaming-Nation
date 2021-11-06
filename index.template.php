<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

/*	This theme is a work of SMF Tricks Team. For more information please visit
	https://www.smftricks.com/
	This theme was developed by Diego Andrés and its a Free Theme.
	Theme designed by Raphisio
	Visit SMF Tricks for more Free Themes and Premium Themes.
	Gaming Nation is a Free Theme
*/

// Initialize the template... mainly little settings.
function template_init()
{
	global $context, $settings, $options, $txt;

	/* Use images from default theme when using templates from the default theme?
		if this is 'always', images from the default theme will be used.
		if this is 'defaults', images from the default theme will only be used with default templates.
		if this is 'never' or isn't set at all, images from the default theme will not be used. */
	$settings['use_default_images'] = 'never';

	/* What document type definition is being used? (for font size and other issues.)
		'xhtml' for an XHTML 1.0 document type definition.
		'html' for an HTML 4.01 document type definition. */
	$settings['doctype'] = 'xhtml';

	/* The version this template/theme is for.
		This should probably be the version of SMF it was created for. */
	$settings['theme_version'] = '2.0';

	/* Set a setting that tells the theme that it can render the tabs. */
	$settings['use_tabs'] = true;

	/* Use plain buttons - as opposed to text buttons? */
	$settings['use_buttons'] = true;

	/* Show sticky and lock status separate from topic icons? */
	$settings['separate_sticky_lock'] = true;

	/* Does this theme use the strict doctype? */
	$settings['strict_doctype'] = false;

	/* Does this theme use post previews on the message index? */
	$settings['message_index_preview'] = false;

	/* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
	$settings['require_theme_strings'] = true;
}

// The main sub template above the content.
function template_html_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	// Show right to left and the character set for ease of translating.
	echo '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>';

	echo '
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

	//Begin Of AutoKeywords
	if (!empty($context['current_topic']))
	{
		$keystring = str_replace(' ', ',', trim($context['page_title_html_safe'])); 
		echo '
		<meta name="keywords" content="', $keystring, '" />';
	}
	elseif (!empty($context['current_board']))
	{
		$keystring = str_replace(' ', ',', trim($context['page_title_html_safe'])); 
		echo '
		<meta name="keywords" content="', $keystring, '" />';
	}
	else
		echo '
		<meta name="keywords" content="', $context['meta_keywords'], '" />';
	//End Of AutoKeywords

	// The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
	echo '
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,greek,greek-ext,vietnamese,latin-ext,cyrillic">
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/bootstrap.min.css?fin20" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/fontawesome.min.css?fin20" />';

	// Some browsers need an extra stylesheet due to bugs/compatibility issues.
	foreach (array('ie7', 'ie6', 'webkit') as $cssfix)
		if ($context['browser']['is_' . $cssfix])
			echo '
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

	// RTL languages require an additional stylesheet.
	if ($context['right_to_left'])
		echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

	// Here comes the JavaScript bits!
	echo '
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/bootstrap.min.js?fin20"></script>
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		var txtnew = "', $txt['new'], '";
		var quick_search_resting_text = "', $txt['search'], '...";
		var variante = "', $context['theme_variant'], '";
		var varianteurl = "', $context['theme_variant_url'], '";
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

	// Please don't index these Mr Robot.
	if (!empty($context['robot_no_index']))
		echo '
	<meta name="robots" content="noindex" />';

	// Present a canonical url for search engines to prevent duplicate content in their indices.
	if (!empty($context['canonical_url']))
		echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';

	// Show all the relative links, such as help, search, contents, and the like.
	echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

	// If RSS feeds are enabled, advertise the presence of one.
	if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']))
		echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

	// If we're viewing a topic, these should be the previous and next topics, respectively.
	if (!empty($context['current_topic']))
		echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';

	// If we're in a board, or a topic for that matter, the index will be the board's index.
	if (!empty($context['current_board']))
		echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

	// Output any remaining HTML headers. (from mods, maybe?)
	echo $context['html_headers'];

	echo '
</head>
<body>';
}

function template_body_above()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings, $topic, $board;

	echo '
		<div id="gobacktotop"></div>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topbar-search" aria-expanded="false">
						<span class="fa fa-search"></span>
					 </button>
					 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#userarea-responsive" aria-expanded="false">
						<span class="fa fa-user"></span>
					 </button>
					<a class="navbar-brand" href="', $scripturl, '"><img src="', !empty($settings['st_mini_logo']) ? $settings['st_mini_logo'] : $settings['images_url']. '/theme/mini_logo.png', '" alt="', $context['forum_name'], '" title="', $context['forum_name'], '" /></a>
				</div>
				<div class="collapse navbar-collapse" id="topbar-search">
					<form class="navbar-form navbar-right" role="search" id="search_form" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
						<div class="form-group">
							<input type="text" class="form-control search-placeholder" name="search" value="', $txt['search'], '..." onfocus="this.value = \'\';" onblur="if(this.value==\'\') this.value=\'', $txt['search'], '...\';" />&nbsp;
							<input type="hidden" name="advanced" value="0" />';
						if (!empty($context['current_topic']))
							echo '
							<input type="hidden" name="topic" value="', $context['current_topic'], '" />';
						elseif (!empty($context['current_board']))
							echo '
							<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '" />';
					echo '
						</div>
					</form>
					<ul class="nav navbar-nav navbar-right hidden-xs">';

			// Reports and stuff
			if ($context['user']['is_logged'])
			{

				// Is the forum in maintenance mode?
				if ($context['in_maintenance'] && $context['user']['is_admin'])
					echo '
						<li class="notice"><a href="', $scripturl, '?action=admin;area=serversettings;sa=general;', $context['session_var'], '=', $context['session_id'], '" title="', $txt['maintain_mode_on'], '"><span class="fa fa-gear"></span> <span class="visible-xs">', $txt['maintain_mode_on'], '</span></a></li>';

				// Are there any members waiting for approval?
				if (!empty($context['unapproved_members']))
					echo '
						<li class="notice"><a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve" title="', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '"><span class="fa fa-users"></span> <span class="visible-xs">', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '</span></a></li>';

				if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
					echo '
						<li class="notice"><a href="', $scripturl, '?action=moderate;area=reports" title="', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '"><span class="fa fa-flag"></span> <span class="visible-xs">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</span></a></li>';
			}

					echo '
						<li></li>
					</ul>
				</div>
				<div class="collapse navbar-collapse" id="userarea-responsive">
					<ul class="nav navbar-nav navbar-right visible-xs">';

			// Reports and stuff
			if ($context['user']['is_logged'])
			{

				// Is the forum in maintenance mode?
				if ($context['in_maintenance'] && $context['user']['is_admin'])
					echo '
						<li class="notice"><a href="', $scripturl, '?action=admin;area=serversettings;sa=general;', $context['session_var'], '=', $context['session_id'], '" title="', $txt['maintain_mode_on'], '"><span class="fa fa-gear"></span> <span class="visible-xs">', $txt['maintain_mode_on'], '</span></a></li>';

				// Are there any members waiting for approval?
				if (!empty($context['unapproved_members']))
					echo '
						<li class="notice"><a href="', $scripturl, '?action=admin;area=viewmembers;sa=browse;type=approve" title="', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '"><span class="fa fa-users"></span> <span class="visible-xs">', $context['unapproved_members'] == 1 ? $txt['approve_thereis'] : $txt['approve_thereare'], ' ', $context['unapproved_members'] == 1 ? $txt['approve_member'] : $context['unapproved_members'] . ' ' . $txt['approve_members'], ' ', $txt['approve_members_waiting'], '</span></a></li>';

				if (!empty($context['open_mod_reports']) && $context['show_open_reports'])
					echo '
						<li class="notice"><a href="', $scripturl, '?action=moderate;area=reports" title="', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '"><span class="fa fa-flag"></span> <span class="visible-xs">', sprintf($txt['mod_reports_waiting'], $context['open_mod_reports']), '</span></a></li>';
			}

					echo '
						<li class="dropdown user-divider">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">', (!empty($context['user']['is_logged']) ? '<img class="avatar_drop2 pull-right" src="'. (!empty($context['user']['avatar']) ? $context['user']['avatar']['href'] : $settings['images_url']. '/theme/noavatar.png'). '" alt="" />' : ''), $context['user']['name'], ' <span class="caret"></span></a>
							<ul class="dropdown-menu bg-userarea">';

						// User login
						if (!empty($context['user']['is_logged']))
							echo '
								<li><a href="', $scripturl, '?action=profile;area=forumprofile">', $txt['forumprofile'], '</a></li>
								<li><a href="', $scripturl, '?action=profile;area=account">', $txt['account'], '</a></li>
								<li><a href="', $scripturl, '?action=unread">', $txt['unread_topics_visit'], '</a></li>
								<li><a href="', $scripturl, '?action=unreadreplies">', $txt['unread_replies'], '</a></li>
								<li class="divider"></li>
								<li><a href="', $scripturl, '?action=logout;', $context['session_var'], '=', $context['session_id'], '">', $txt['logout'], '</a></li>';
						else
							echo '
								<li><a href="#" data-toggle="modal" data-target="#loginModal">', $txt['login'], '</a></li>
								<li><a href="', $scripturl, '?action=register">', $txt['register'], '</a></li>';

					echo '
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>';

	echo '
<div class="wrapper"', !empty($settings['forum_width']) ? ' style="width: ' . $settings['forum_width'] . '"' : '', '>
	<div id="header">
		<h1 class="forumtitle">
			<a href="', $scripturl, '">', empty($context['header_logo_url_html_safe']) ? '<img src="' . $settings['images_url'] . '/theme/logo.png" alt="' . $context['forum_name'] . '" />' : '<img src="' . $context['header_logo_url_html_safe'] . '" alt="' . $context['forum_name'] . '" />', '</a>
		</h1>
		<div class="user-area hidden-xs">';

	// If the user is logged in, display stuff like their name, new messages, etc.
	if ($context['user']['is_logged'])
	{
		echo '
			<h4 class="user-welcome">',$txt['hello_member_ndt'], ' ', $context['user']['name'], '</h4>
			<img class="avatar_drop" src="', !empty($context['user']['avatar']) ? $context['user']['avatar']['href'] : $settings['images_url'].'/theme/noavatar.png', '" alt="', $txt['profile'], '" />
				<div class="user-options">
					<ul class="reset">
						<li><a href="', $scripturl, '?action=profile">&#187; ', $txt['profile'], '</a></li>
						<li><a href="', $scripturl, '?action=profile;area=forumprofile">&#187; ', $txt['forumprofile'], '</a></li>
						<li><a href="', $scripturl, '?action=profile;area=account">&#187; ', $txt['account'], '</a></li>
						<li><a href="', $scripturl, '?action=unread">&#187; ', $txt['unread_topics_visit'], '</a></li>
						<li><a href="', $scripturl, '?action=unreadreplies">&#187; ', $txt['unread_replies'], '</a></li>
						<li><a href="', $scripturl, '?action=logout;', $context['session_var'], '=', $context['session_id'], '">&#187; ', $txt['logout'], '</a></li>
					</ul>
				</div>';
	}
	// Otherwise they're a guest - this time ask them to either register or login - lazy bums...
	elseif (!empty($context['show_login_bar']))
	{
		echo '
				<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/sha1.js"></script>
				<form id="guest_form" action="', $scripturl, '?action=login2" method="post" accept-charset="', $context['character_set'], '" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
					<div class="info">', sprintf($txt['welcome_guest'], $txt['guest_title']), '</div>
					<input type="text" name="user" size="10" class="input_text" />
					<input type="password" name="passwrd" size="10" class="input_password" />
					<select name="cookielength">
						<option value="60">', $txt['one_hour'], '</option>
						<option value="1440">', $txt['one_day'], '</option>
						<option value="10080">', $txt['one_week'], '</option>
						<option value="43200">', $txt['one_month'], '</option>
						<option value="-1" selected="selected">', $txt['forever'], '</option>
					</select>
					<input type="submit" value="', $txt['login'], '" class="button_submit" /><br />
					<div class="info">', $txt['quick_login_dec'], '</div>';

		if (!empty($modSettings['enableOpenID']))
			echo '
					<br /><input type="text" name="openid_identifier" id="openid_url" size="25" class="input_text openid_login" />';

		echo '
					<input type="hidden" name="hash_passwrd" value="" /><input type="hidden" name="', $context['session_var'], '" value="', $context['session_id'], '" />
				</form>';
	}

	echo '
			</div>
			<br class="clear hidden-xs">
	</div>';

	// Show the menu here, according to the menu sub template.
	template_menu();

	// Carousel
	if (!empty($settings['st_carousel_index'])) {
		if (empty($_REQUEST['action']) && (empty($board)) && (empty($topic)))
			$carousel = 1;
		else
			$carousel = 0;
	}
	else
		$carousel = 1;
	if (!empty($settings['st_enable_carousel']) && $carousel == 1 && (!empty($settings['st_carousel_img1']) || !empty($settings['st_carousel_img2']) || !empty($settings['st_carousel_img3'])))
	{
		echo '
		<div class="wrapper"', !empty($settings['forum_width']) ? ' style="width: ' . $settings['forum_width'] . '"' : '', '>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="', !empty($settings['st_carousel_speed']) ? $settings['st_carousel_speed'] : '3500', '">
			<ol class="carousel-indicators">';

			if (!empty($settings['st_carousel_img1']))
				echo '
				<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>';
			if (!empty($settings['st_carousel_img2']))
				echo '
				<li data-target="#carousel-example-generic" data-slide-to="1"',(empty($settings['st_carousel_img1']) ? ' class="active"' : ''), '></li>';
			if (!empty($settings['st_carousel_img3']))
				echo '
				<li data-target="#carousel-example-generic" data-slide-to="2"',((empty($settings['st_carousel_img2']) && empty($settings['st_carousel_img1'])) ? ' class="active"' : ''), '></li>';
		echo '
			</ol>
			<div class="carousel-inner" role="listbox">';

			
				if (!empty($settings['st_carousel_img1']))
				{
					echo '
					<div class="item active" style="background-image: url(', $settings['st_carousel_img1'], ')">';

					if (!empty($settings['st_carousel_title1']) || !empty($settings['st_carousel_text1']))
					{
						echo '
						<div class="carousel-caption">
							', !empty($settings['st_carousel_title1']) ? ('<h3>'. (!empty($settings['st_carousel_link1']) ? '<a href="'.$settings['st_carousel_link1'].'">'.$settings['st_carousel_title1'].'</a>' : $settings['st_carousel_title1']). '</h3>') : '';

						if(!empty($settings['st_carousel_text1']))
							echo '
							<p>', $settings['st_carousel_text1'],'</p>';

					echo '
						</div>';
					}
					echo '
					</div>';
				}

				if (!empty($settings['st_carousel_img2']))
				{
					echo '
					<div class="item',(empty($settings['st_carousel_img1']) ? ' active' : ''), '" style="background-image: url(', $settings['st_carousel_img2'], ')">';

					if (!empty($settings['st_carousel_title2']) || !empty($settings['st_carousel_text2']))
					{
						echo '
						<div class="carousel-caption">
							', !empty($settings['st_carousel_title2']) ? ('<h3>'. (!empty($settings['st_carousel_link2']) ? '<a href="'.$settings['st_carousel_link2'].'">'.$settings['st_carousel_title2'].'</a>' : $settings['st_carousel_title2']). '</h3>') : '';

						if(!empty($settings['st_carousel_text2']))
							echo '
							<p>', $settings['st_carousel_text2'],'</p>';

					echo '
						</div>';
					}
					echo '
					</div>';
				}

				if (!empty($settings['st_carousel_img3']))
				{
					echo '
					<div class="item',((empty($settings['st_carousel_img2']) && empty($settings['st_carousel_img1'])) ? ' active' : ''), '" style="background-image: url(', $settings['st_carousel_img3'], ')">';

					if (!empty($settings['st_carousel_title3']) || !empty($settings['st_carousel_text3'])) {
						echo '
						<div class="carousel-caption">
							', !empty($settings['st_carousel_title3']) ? ('<h3>'. (!empty($settings['st_carousel_link3']) ? '<a href="'.$settings['st_carousel_link3'].'">'.$settings['st_carousel_title3'].'</a>' : $settings['st_carousel_title3']). '</h3>') : '';

						if(!empty($settings['st_carousel_text3']))
							echo '
							<p>', $settings['st_carousel_text3'],'</p>';

					echo '
						</div>';
					}
					echo '
					</div>';
				}

		echo '
			</div>
			<div class="hidden-xs">
				<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"', !empty($settings['forum_width']) ? ' style="right: ' . $settings['forum_width'] . '"' : '', '>
					<span class="fa fa-angle-left" aria-hidden="true"></span>
					<span class="sr-only">', $txt['st_previous'], '</span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"', !empty($settings['forum_width']) ? ' style="left: ' . $settings['forum_width'] . '"' : '', '>
					<span class="fa fa-angle-right" aria-hidden="true"></span>
					<span class="sr-only">', $txt['st_next'], '</span>
				</a>
			</div>
		</div>
		</div>';
	}

	// Show the navigation tree.
	theme_linktree();

	// The main content should go here.
	echo '
	<div id="content_section">
		<div id="main_content_section">';

	// Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
		</div>
	</div>';

	// Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
	echo '
	<div id="footer_section">
		<div class="row">
			<div class="col-md-4">
				<ul class="reset text-left">
					<li class="copyright">', GN_copy(), '</li>
					<li class="copyright">', theme_copyright(), '</li>
				</ul>
			</div>
			<div class="col-md-4 text-center">
				<img src="', !empty($settings['st_footer_logo']) ? $settings['st_footer_logo'] : $settings['images_url']. '/theme/footer_logo.png', '" alt="', $context['forum_name'], '" title="', $context['forum_name'], '" />
			</div>
			<div class="col-md-4">
				<ul class="reset text-right">
					<li class="copyright"><a href="', $scripturl, '">', $context['forum_name'], ' &copy; ', date('Y'), '</a></li>
					<li class="copyright">', $txt['st_allrights'], '</li>
				</ul>
				<div id="quicknav">
					<ul class="reset">';

				if(!empty($settings['st_facebook_username']))
					echo '
						<li><a class="social_icon facebook" href="https://facebook.com/', $settings['st_facebook_username'] , '" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a></li>';

				if(!empty($settings['st_twitter_username']))
					echo '
						<li><a class="social_icon twitter" href="https://twitter.com/', $settings['st_twitter_username'] , '" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a></li>';

				if(!empty($settings['st_youtube_username']))
					echo '
						<li><a class="social_icon youtube" href="https://youtube.com/user/', $settings['st_youtube_username'] , '" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a></li>';

				if(!empty($settings['st_instagram_username']))
					echo '
						<li><a class="social_icon instagram" href="https://instagram.com/', $settings['st_instagram_username'] , '" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a></li>';

				if(!empty($settings['st_discord_link']))
					echo '
						<li><a class="social_icon gplus" href="', $settings['st_discord_link'] , '" target="_blank" rel="noopener"><i class="fab fa-discord"></i></a></li>';

						echo '
						<li><a class="social_icon rss" href="', empty($settings['st_rss_url']) ? '' . $scripturl . '?action=.xml;type=rss' : '' . $settings['st_rss_url'] . '', '" target="_blank" rel="noopener"><i class="fas fa-rss"></i></a></li>
					</ul>
				</div>
			</div>
		</div>';

	echo '
	</div>
	<div class="footer_bottom">
		<a id="back-to-top"><span class="fa fa-chevron-up"></span></a>';

	// Show the load time?
	if ($context['show_load_time'])
		echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

	echo '
	</div>
</div>';
}

function template_html_below()
{
	global $context, $settings, $options, $scripturl, $txt, $modSettings;

	echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false)
{
	global $context, $settings, $options, $shown_linktree, $scripturl;

	// If linktree is empty, just return - also allow an override.
	if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show))
		return;

	echo '
	<div class="navigate_section">
		<ul>
			<li class="home">
				<a href="', $scripturl, '"><span class="fa fa-home"></span></a>
			</li>';

	// Each tree item has a URL and name. Some may have extra_before and extra_after.
	foreach ($context['linktree'] as $link_num => $tree)
	{
		echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

		// Show something before the link?
		if (isset($tree['extra_before']))
			echo $tree['extra_before'];

		// Show the link, including a URL if it should have one.
		echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

		// Show something after the link...?
		if (isset($tree['extra_after']))
			echo $tree['extra_after'];

		echo '
			</li>';

		// Don't show a separator for the last one.
		if ($link_num != count($context['linktree']) - 1)
			echo '
			<li> / </li>';
	}
	echo '
		</ul>
	</div>';

	$shown_linktree = true;
}

// Theme copyright, please DO NOT REMOVE THIS!!
function GN_copy() {
	$GN = 'Theme by <a href="https://smftricks.com" target="_blank" rel="noopener">SMF Tricks</a>';

	return $GN;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu()
{
	global $context, $settings, $options, $scripturl, $txt;

	echo '
	<nav class="navbar navbar-default">
		<div class="navbar-header">
			<div class="visible-xs navbar-brand">Menu</div>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">';

	foreach ($context['menu_buttons'] as $act => $button)
	{
		echo '
				<li id="button_', $act, '" class="button_', $act, (!empty($button['sub_buttons']) ? ' dropdown' : ''), ($button['active_button'] ? ' active' : ''), '">
					<a ', (!empty($button['sub_buttons']) ? ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"' : ''), ' href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
						', $button['title'], (!empty($button['sub_buttons']) ? ' <span class="caret"></span>' : ''), '
					</a>';
		if (!empty($button['sub_buttons']))
		{
			echo '
					<ul class="dropdown-menu animated bounceIn">
						<li>
							<a href="', $button['href'], '"', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>', $button['title'], '</a>
						</li>';
					
			if ($act == 'admin')
					echo '
						<li>
							<a href="', $scripturl, '?action=admin;area=theme;sa=settings;th=', $settings['theme_id'], '">', $txt['current_theme'], '</a>
						</li>';

			foreach ($button['sub_buttons'] as $childbutton)
			{
				echo '
						<li', !empty($childbutton['sub_buttons']) ? ' class="dropdown-submenu"' : '', '>
							<a href="', $childbutton['href'], '"', isset($childbutton['target']) ? ' target="' . $childbutton['target'] . '"' : '', '>
								', $childbutton['title'], !empty($childbutton['sub_buttons']) ? '...' : '', '
							</a>';
				// 3rd level menus :)
				if (!empty($childbutton['sub_buttons']))
				{
					echo '
							<ul class="dropdown-menu animated bounceIn">';

					foreach ($childbutton['sub_buttons'] as $grandchildbutton)
						echo '
								<li>
									<a href="', $grandchildbutton['href'], '"', isset($grandchildbutton['target']) ? ' target="' . $grandchildbutton['target'] . '"' : '', '>
										', $grandchildbutton['title'], '
									</a>
								</li>';

					echo '
							</ul>';
				}

				echo '
						</li>';
			}
				echo '
					</ul>';
		}
		echo '
				</li>';
	}

	echo '
			</ul>
		</div>
	</nav>';
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array())
{
	global $settings, $context, $txt, $scripturl;

	if (!is_array($strip_options))
		$strip_options = array();

	// List the buttons in reverse order for RTL languages.
	if ($context['right_to_left'])
		$button_strip = array_reverse($button_strip, true);

	// Create the buttons...
	$buttons = array();
	foreach ($button_strip as $key => $value)
	{
		if (!isset($value['test']) || !empty($context[$value['test']]))
			$buttons[] = '
				<li' .(isset($value['active']) ? ' class="active"' : '') . '><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><i class="fa fa-'.$key.' fa-fw"></i> <span class="hidden-xs">' . $txt[$value['text']] . '</span></a></li>';
	}

	// No buttons? No button strip either.
	if (empty($buttons))
		return;

	// Make the last one, as easy as possible.
	$buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

	echo '
		<div class="', !empty($direction) ? ' pull-' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"': ''), '>
			<ul class="nav nav-pills">',
				implode('', $buttons), '
			</ul>
		</div>';
}

?>