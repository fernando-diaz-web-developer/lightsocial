<?php 
/**
 * LightSocial
 *
 * @package     lightsocial
 * @author      Jesus Azocar
 * @copyright   2018 Jesus Azocar
 * @license     GPL
 *
 * @wordpress-plugin
 * Plugin Name: LightSocial
 * Plugin URI:  none
 * Description: A plugin for putting Facebook, Twitter and Google+ Share Buttons.
 * Version:     1.0
 * Author:      Jesus Azocar
 * Author URI:  azocar.com
 * Text Domain: lightsocial
 * License:    GPL
 */

class LightSocial{
	public function preppend_buttons($content){
		global $wp; 
		$patterns = [
					'Facebook' => ' <div class="fb-share-button" data-href="{{URL}}" data-layout="button_count"></div>',
					'Twitter' => '<a class="twitter-share-button" href="https://twitter.com/intent/tweet?url={{SANITIZED_URL}}">Tweet</a>',
					'Google+' => '<script src="https://apis.google.com/js/platform.js" async defer>{lang: \'es-419\'}</script>
				<div class="g-plus" data-action="share" data-height="24" data-href="{{URL}}"></div>'
					]; 
		$links = '<div class="sociallight" style="display:flex; align-content:center;justify-items:center;">'; 
		$url = home_url( $wp->request );

		foreach ($patterns as $key => $value) {
			$links .= str_replace("{{URL}}", $url, $value);
		}
		$links .='</div>';

		return $links.$content; 
	}

	public function custom_js(){
		?>
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  <style type="text/css">
  	.sociallight > :not(script) {
  		align-items: start;
  		display: flex !important;
  		height: 60px !important;
  		justify-content: center; 
  		margin: 0 5px !important;
  	}

  </style>
		<?php
	}

	public function __construct(){
		add_filter('the_content',[$this,'preppend_buttons']);
		add_action('wp_footer',[$this,'custom_js']);
	}
}

new LightSocial();