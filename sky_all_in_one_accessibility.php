<?php

// This is a PLUGIN TEMPLATE.

// Copy this file to a new name like abc_myplugin.php.  Edit the code, then
// run this file at the command line to produce a plugin for distribution:
// $ php abc_myplugin.php > abc_myplugin-0.1.txt

// Plugin name is optional.  If unset, it will be extracted from the current
// file name. Plugin names should start with a three letter prefix which is
// unique and reserved for each plugin author ('abc' is just an example).
// Uncomment and edit this line to override:
# $plugin['name'] = 'abc_plugin';

// Allow raw HTML help, as opposed to Textile.
// 0 = Plugin help is in Textile format, no raw HTML allowed (default).
// 1 = Plugin help is in raw HTML.  Not recommended.
$plugin['name'] = 'sky_all_in_one_accessibility';

$plugin['version'] = '4.6.0';
$plugin['author'] = 'Skynet Technologies USA LLC';
$plugin['author_uri'] = 'https://www.skynettechnologies.com/';
$plugin['description'] = 'Quick Web Accessibility Implementation with All in One Accessibility™';

// Plugin load order:
// The default value of 5 would fit most plugins, while for instance comment
// spam evaluators or URL redirectors would probably want to run earlier
// (1...4) to prepare the environment for everything else that follows.
// Values 6...9 should be considered for plugins which would work late.
// This order is user-overrideable.
$plugin['order'] = 5;

// Plugin 'type' defines where the plugin is loaded
// 0 = public       : only on the public side of the website (default)
// 1 = public+admin : on both the public and non-AJAX admin side
// 2 = library      : only when include_plugin() or require_plugin() is called
// 3 = admin        : only on the non-AJAX admin side
// 4 = admin+ajax   : only on admin side
// 5 = public+admin+ajax   : on both the public and admin side
$plugin['type'] = 3;

// Plugin 'flags' signal the presence of optional capabilities to the core plugin loader.
// Use an appropriately OR-ed combination of these flags.
// The four high-order bits 0xf000 are available for this plugin's private use.
if (!defined('PLUGIN_HAS_PREFS')) define('PLUGIN_HAS_PREFS', 0x0001); // This plugin wants to receive "plugin_prefs.{$plugin['name']}" events
if (!defined('PLUGIN_LIFECYCLE_NOTIFY')) define('PLUGIN_LIFECYCLE_NOTIFY', 0x0002); // This plugin wants to receive "plugin_lifecycle.{$plugin['name']}" events
$plugin['flags'] = '2';
// $plugin['flags'] = PLUGIN_HAS_PREFS | PLUGIN_LIFECYCLE_NOTIFY;

// Plugin 'textpack' is optional. It provides i18n strings to be used in conjunction with gTxt().
$plugin['textpack'] = <<< EOT
#@language en, en-gb, en-us
#@admin-side

all_in_one_accessibility => All in One Accessibility™

#@all_in_one_accessibility
EOT;
// End of textpack
if (!defined('txpinterface'))
	@include_once('zem_tpl.php');

# --- BEGIN PLUGIN CODE ---

if (txpinterface === 'admin') {
	new all_in_one_accessibility();
}

/**
 * Admin-side class.
 */
class all_in_one_accessibility {
	/**
	 * The plugin's event.
	 *
	 * @var string
	 */
	protected $event = __CLASS__;

	/**
	 * The plugin's privileges.
	 *
	 * @var string
	 */
	protected $privs = '1';

	protected $prefs = array();
	/**
	 * Constructor
	 */
	public function __construct() {

		add_privs('all_in_one_accessibility', $this->privs);

		register_callback(array($this, 'welcome'), 'plugin_lifecycle.' . $this->event);

		register_callback(function () {
			register_tab('extensions', 'all_in_one_accessibility', gTxt('all_in_one_accessibility'));
		}, 'admin_side', 'head_end');

		register_callback(array($this, 'aioa'), "all_in_one_accessibility");
	}

	/**
	 * Runs on plugin installation.
	 *
	 * @param      string  $evt    Textpattern event (panel)
	 * @param      string  $stp    Textpattern step (action)
	 */
	public function welcome($evt, $stp) {
		switch ($stp) {
			case 'installed':
				$this->install();
				break;
			case 'deleted':
				$this->uninstall();
				break;
		}

		return;
	}

	/**
	 * Install prefs.
	 *
	 * @param array $set Array of key => values to forcibly set. Defaults will be used otherwise
	 */
	public function install($set = array()) {
	}

	/**
	 * Delete prefs and language strings.
	 */
	public function uninstall() {
	}
	public function aioa($event, $step) {
		$javascript_code = '<script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?aioa_reg_req=true&colorcode=&token=&position=bottom_right"></script>';

		$index_file = '../index.php';
		if (strpos(file_get_contents($index_file), $javascript_code) === false) {

			$index_content = file_get_contents($index_file);
			file_put_contents($index_file, $javascript_code . $index_content);
		}
?>


		<style>
			.get-strated-btn,
			.get-strated-btn:hover {
				background-color: #2855d3;
				color: white;
				padding: 5px 5px;
				text-decoration: none;
			}

			.aioa-cancel-button {
				text-decoration: none;
				display: inline-block;
				vertical-align: middle;
				border: 2px solid #420083;
				border-radius: 4px 4px 4px 4px;
				background-color: #420083;
				box-shadow: 0px 0px 2px 0px #333333;
				color: #ffffff !important;
				text-align: center;
				box-sizing: border-box;
				padding: 12px;
				font-size: 1.5rem;
			}

			.aioa-cancel-button:hover {
				border-color: #420083;
				background-color: white;
				box-shadow: 0px 0px 2px 0px #333333;
				color: black !important;
				text-decoration: none;
				padding: 12px;
				font-size: 1.5rem;
			}

			.aioa-cancel-button:hover .mb-text {
				color: #420083;
			}

			.widget {

				float: left;
			}

			.subscription {
				float: right;
			}

			h5 {
				font-weight: 450;
				color: #000;
			}
		</style>
		<div id="domain_button" style="display: none">
			<h5 style="color: #aa1111">It appears that you have already registered! Please click on the "Manage Subscription" button to renew your subscription.<br> Once your plan is renewed, please refresh the page.</h5>
			<div style="text-align: left; width:80%; padding-bottom: 10px;"><a target="_blank" id="manage_subscription" class="aioa-cancel-button" href="">Manage Subscription</a></div>
		</div>
		<div id="setting-div" style="width:80%; margin-top: 50px; padding-bottom: 10px;justify-content:space-between; display: none">
			<div style="padding-bottom: 8%;">
				<div class="widget">
					<h3 style="font-size: 1.5rem;">Widget Preferences:</h3>
				</div>
				<div class="subscription"><a target="_blank" class="aioa-cancel-button" id="aioa_subscriptionsd" href="">Manage Subscription</a></div>
			</div>
			<iframe id="setting-iframe" src="" height="1100px;" width="100%" style="border: none;display: none"></iframe>
		</div>
		<iframe id="aioa-iframe" src="" height="1100px;" width="70%" style="border: none;display: none"></iframe>


		<script>
			var current_domain = window.location.hostname;
			const myHeaders = new Headers();
			myHeaders.append("Cookie", "XSRF-TOKEN=eyJpdiI6IlNkQWxSVTJ0V1RyRlBUVTVnV21JNlE9PSIsInZhbHVlIjoib0o1clU2MGpMVkpIMkNiLzBNeWJkSXhrUjFpMm1HTWp4R2lld1pYa2pWMGk3emFzck5XR1ZqUFRtdmt2QTVzdzAvK1dsNGl2ckJVYWkvUHE0S2svUExLWTlNS05nNmVYZVV1MUpnVEg1UHdscSttOFJpaGJkc3YwR0VuUmRlT00iLCJtYWMiOiIzYTNiZmI3ZmY3YjkyMDQ5M2UwN2NhNmQzNmE5NTNhYTM2YThkZjdiNWU0NjcwMzJkZjU4MTIzN2ZiN2NlMTFlIiwidGFnIjoiIn0%3D; all_in_one_accessibility_session=eyJpdiI6IjU1eWJpSm1nSFk5WlRubFhuNVRRa0E9PSIsInZhbHVlIjoiZDY1eStYLzhpK3BXLzduRFA3RGUvYVdCa0ZGSnJ1dVVCOHAzNkU0TmZJb2NJWDVHa0sxQ3RXdjdkZEVlTjc4bFF5d1VPY3RVWVRuSG5VekFrOC9PbWJ5NTVtWE5SOGJpVWNURXZIeHJNTE1uT0ZPZ1JDbXpYS3NHNU0zYkRsNFkiLCJtYWMiOiIzMzFhOTIwMGQwN2JiODBlMDkzYzlhOTRhNDg0NWRhYzMzYmMyOGI1N2JhMDAyYTRlZGMxOTYyNDZiYWI4NjlmIiwidGFnIjoiIn0%3D");

			const formdata = new FormData();
			formdata.append("domain", current_domain);
			const requestOptions = {
				method: "POST",
				headers: myHeaders,
				body: formdata,
				redirect: "follow"
			};
			fetch("https://ada.skynettechnologies.us/check-website", requestOptions)
				.then((response) => response.json())
				.then(function(response) {
					var get_settinglink = response.settinglink;
					var manage_domain = response.manage_domain;
					console.log(response.status, "check status");
					if (response.status == 3) {
						var show_button = document.getElementById("manage_subscription");
						console.log(show_button);
						document.getElementById("aioa-iframe").style.display = 'none';
						document.getElementById("domain_button").style.display = 'block';
						document.getElementById("setting-div").style.display = 'none';
						show_button.href = get_settinglink;
					} else if (response.status > 0 && response.status < 3) {
						var show_button_manage = document.getElementById("aioa_subscriptionsd");
						var iframe = document.getElementById("setting-iframe");
						document.getElementById("aioa-iframe").style.display = 'none';
						document.getElementById("domain_button").style.display = 'none';
						document.getElementById("setting-div").style.display = 'block';
						document.getElementById("setting-iframe").style.display = 'block';
						iframe.src = get_settinglink;
						show_button_manage.href = manage_domain;
					} else {
						var iframe_id = document.getElementById("aioa-iframe");
						document.getElementById("aioa-iframe").style.display = 'block';
						document.getElementById("domain_button").style.display = 'none';
						document.getElementById("setting-div").style.display = 'none';
						iframe_id.src = "https://ada.skynettechnologies.us/trial-subscription?isframe=true&website=" + current_domain + "&developer_mode=true";
					}
				})
				.catch((error) => console.error(error));
		</script>



	<?php

		pagetop(gTxt('all_in_one_accessibility'));
	}
}

# --- END PLUGIN CODE ---
if (0) {
	?>

# --- BEGIN PLUGIN HELP ---

h1. All in One Accessibility™

All in One Accessibility™ AI Widget Supports 140 Languages, Screen Reader, Voice Navigation, Dictionary, Virtual Keyboard, Accessibility Profiles, Sign language Libras (Brazilian Portuguese) Custom Widget Color, Icon size, Position, GA4 Tracking and custom accessibility statement link are some of the top features.

Our AI automatically remediates images Alternative text and uses the accessibility interface which handles UI and design related adjustments. All in One Accessibility™ app enhances your Textpattern CMS accessibility to people with hearing or vision impairments, motor impaired, color blind, dyslexia, cognitive & learning impairments, seizure and epileptic, and ADHD problems.

It improves Textpattern CMS ADA compliance and browser experience for ADA, WCAG 2.1 & 2.2, Section 508, California Unruh Act, Australian DDA, European EAA EN 301 549, UK Equality Act (EA), Israeli Standard 5568, Ontario AODA, Canada ACA, German BITV, France RGAA, Brazilian Inclusion Law (LBI 13.146/2015), Spain UNE 139803:2012, JIS X 8341 (Japan), Italian Stanca Act and Switzerland DDA Standards.

Follows the best industry security, SEO practices and standards ISO 9001:2015 & ISO 27001:2013 and complies with GDPR, COPPA regulations. Member of W3C and International Association of Accessibility Professionals (IAAP). It is a flexible & lightweight widget that can be changed according to law and reduces the risk of time-consuming accessibility lawsuits.

!https://www.skynettechnologies.com/sites/default/files/Screenshot-1.jpg!

!https://www.skynettechnologies.com/sites/default/files/Screenshot-2.jpg!

!https://www.skynettechnologies.com/sites/default/files/Screenshot-3.jpg!

!https://www.skynettechnologies.com/sites/default/files/Screenshot-4.jpg!

!https://www.skynettechnologies.com/sites/default/files/Screenshot-5.jpg!

Video "All in One Accessibility™":https://www.youtube.com/watch?v=8y3xtOaFvU0

Acknowledgements "Textpattern All in One Accessibility™ Extension installation steps blog":https://www.skynettechnologies.com/blog/textpattern-web-accessibility-widget-installation

Documentation "All in One Accessibility™ User Guide":https://www.dropbox.com/s/de41n4xm9zjwxix/All-in-One-Accessibility-PRO-App-Usage-and-Functionality.pdf?dl=0

For any kind of queries/support please Email us at "Skynet Technologies Support":mailto:hello@skynettechnologies.com

h2. List of features

* White Label service
* Custom Branding
* Live Site translates
* Customize Accessibility Menu/widget
* Accessibility Monitoring
* PDF / Word Document Remediation

*Screen Reader*

* Read Page
* Reading Mask
* Read Mode
* Reading Guide

*Skip Links*

* Skip to Navigation
* Skip to Footer
* Skip to Content
* Open Accessibility Toolbar

*Content Adjustments*

* Content Scaling
* Dyslexia Fonts
* Readable Fonts (Legible Fonts)
* Highlight Title
* Highlight Links
* Text Magnifier
* Adjust Font Sizing
* Adjust Line Height
* Adjust Letter Spacing
* Align Center
* Align Left
* Align Right

*Color And Contrast Adjustments*

* Dark Contrast
* Monochrome (Desaturate)
* Light Contrast
* High Saturation
* High Contrast
* Smart Contrast
* Low Saturation
* Invert Colors
* Adjust Background Colors
* Adjust Text Colors
* Adjust Title Colors

*Orientation Adjustments*

* Mute Sounds
* Hide Images (Text only)
* Stop Animation
* Highlight Hover
* Highlight Focus
* Big Black Cursor
* Big White Cursor
* Filter Content

*Misc*

* Libras
* Accessibility Statement
* Hide Interface
* Dynamic Widget Color
* Dynamic Widget Position
* Multi Language
* AI Image Alternate Text
* Accessibility icon and assistive technology
* Dictionary
* Virtual Keyboard
* Change Widget Icon Type
* Custom Widget Icon Size

*Accessibility Profiles*

* Blind
* Motor Impaired
* Visually Impaired
* Color Blind
* Dyslexia
* Cognitive & Learning
* Seizure & Epileptic
* ADHD

*Supports 65 languages*

* English (USA)
* English (UK)
* English (Australian)
* English (Canadian)
* Español
* Español (Mexicano)
* Deutsch
* عربى
* Português
* Portugués (Brasileño)
* 日本語
* Français
* Italiano
* Polski
* Pусский
* 中文
* 中文 (Traditional)
* עִברִית
* Magyar
* Slovenčina
* Suomenkieli
* Türkçe
* Ελληνικά
* Latinus
* Български
* Català
* Čeština
* Dansk
* Nederlands
* हिंदी
* Bahasa Indonesia
* 한국어
* Lietuvių
* Bahasa Melayu
* Norsk
* Română
* Slovenščina
* Svenska
* ภาษาไทย
* Українська
* Việt Nam
* বাঙালি
* සිංහල
* አማርኛ
* Hmoob
* မြန်မာ
* Eesti keel
* latviešu
* српски
* Hrvatski
* ქართული
* ʻŌlelo Hawaiʻi
* Cymraeg
* Cebuano
* Samoa
* Kreyòl ayisyen
* Føroyskt
* Crnogorski
* Azerbaijani
* Euskara
* Tagalog
* Galego
* Norsk Bokmål
* فارسی
* ਪੰਜਾਬੀ

*Misc*

* Libras
* Accessibility Statement
* Hide Interface
* Dynamic Widget Color
* Dynamic Widget Position
* Multi Language
* AI Image Alternate Text
* Accessibility icon and assistive technology
* Dictionary
* Virtual Keyboard
* Change Widget Icon Type
* Custom Widget Icon Size

*Accessibility Profiles*

* Blind
* Motor Impaired
* Visually Impaired
* Color Blind
* Dyslexia
* Cognitive Learning
* Seizure Epileptic
* ADHD

h2. Installation and usage

Download and copy the plugin code to the plugin installer textarea. Install and verify to begin the automatic setup. After activating the plugin, you will see the plugin adds menu items to your Textpattern admin interface.

h4. Requirements

* Textpattern 4.7.3+

h2.  Configuration

In Textpattern's admin panel, navigate to Extensions, then select "All in One Accessibility™" (Extension -> All in One Accessibility™) for configure accessibility plugin.

# --- END PLUGIN HELP ---

<?php
}
?>
