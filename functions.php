<?php



add_action( 'after_setup_theme', 'my_ag_child_theme_setup' );
// new feature box

function my_ag_child_theme_setup() {
	remove_shortcode( 'feature-box' );
	add_shortcode( 'feature-box', 'child_theme_shortcode_feature_box' );	
}



function child_theme_shortcode_feature_box($atts, $content = false) {

	
	$output = "";

	 
	
	 // get some sort of image from img id

	

	if ( $content ) { $p_class = "feature has-content"; } else { $p_class = "feature  has-content"; }


	if ($atts["colour"]) {
		$p_class .= " " . $atts["colour"];
	}

	if ( $atts["link"] ) {
		$p_class .= " has-link";
	}
	if ( $atts["link"] ) {	$output .= '<a href="' . $atts["link"] . '" title="' . $atts["linktitle"] . '">'; } 
	$output .= '<div class="' . $p_class . '">';
	
	

	if ($atts["imgid"] != "" && $atts["imgid"] != 'undefined') {

		$img = wp_get_attachment_image_src($atts["imgid"], responsive_conditional_size('medium'));
		$output .= 	'<header>';
		$output .= 		'<img src="' . $img[0] . '" />';		
		$output .= 	'</header>';
	}

	

	

	

	
	
	
	
	$output .= '<div class="content">';
	$output .= 	'<h2>';

		if ($atts["icon"]) { $output .= '<i class="fa fa-' . $atts["icon"] . '"></i>'; }
		
		$output .= $atts["title"];
	$output .= '</h2>';


	 if ( $content ) { 
	 	
	 	//if ( $atts["link"] ) {	$output .= '<a href="' . $atts["link"] . '" title="' . $atts["linktitle"] . '">'; } 
		$output .= '<div class="copy">' . wpautop($content) . '</div>';
		//if ( $atts["link"]) {	$output .= '</a>'; } 
		
	 } 
	 $output .= '</div>';


	
	


	$output .= '</div>';
	if ( $atts["link"]) {	$output .= '</a>'; } 
	 

	
	return $output; 
}




remove_filter("the_content", "WrapStuff");
add_filter("the_content", "BBG_WrapStuff", 0);




function BBG_WrapStuff( $post ) {

	$array = array (
      "{gallery" => "[gallery",
      "{feature-box" => "[feature-box"
	);

	$post = strtr($post, $array);

	$post = strtr($post, $array);

	$pattern = "/{{section:(\#?.+)}}/";
	

	$chars = preg_split($pattern, $post, null, PREG_SPLIT_DELIM_CAPTURE);
	
	

	$original = $post;

	$newpost = "";
	if (count($chars) == 0) return $post;

	$even = true;


	foreach ($chars as $key => $match) {

		

		if ($even) {
			// content
			$newpost .= $match;

			if ($key > 0) {
				$newpost .= "</div>"; // close div
			}
		} else {

			// flag
			if (substr($match, 0, 1) == '#' || substr(strtolower($match), 0, 3) == 'rgb') {
				$newpost .= "<div class='section full-width-background' style='background:" . $match . ";'>"; 
			} else {
				$newpost .= "<div class='section full-width-background " . $match . "'>"; 
			}
			
			

		}
		
		
		
		$even = ($even) ? false : true; 
	}

	return $newpost;
	// 	/*
	// 	$match == {{section:colour}}
	// 	$matches[1][$key] == colour
	// 	*/

	// 	echo $x . "<textarea>" . print_r($match, true) . "</textarea>";

		
		
		
	// 	$chunk = strstr($post, $match, TRUE ); // everything before this instance of the section
	// 	echo "<textarea>" . $chunk . "</textarea>";
	// 	echo "<textarea>" . $post . "</textarea>";
	// 	echo "<textarea>" . strstr($post, $match) . "</textarea>";
	// 	$newpost .= $chunk;
		
	// 	if ($key > 0) {
	// 		$newpost .= "</div>";
	// 	}
		
	// 	// open the section
	// 	$newpost .= "<div class='section " . $matches[1][$key] . "'>"; 


		
	// 	echo "<hr>";

	// 	$post = str_replace( $match, "", strstr($post, $match) );
	
	// 	$x++;
		
	// }

	// $newpost .= $post . "</div>"; // we never close this in the loop above

	// return $newpost;



}


/**
 * Get a list of all the Lusso posts from the Lusso website
 *
 * @return object The HTTP response that comes as a result of a wp_remote_get().
 */
function lusso_posts() {

  // Do we have this information in our transients already?
  $transient = get_site_transient( 'lusso_posts' );
  
  // Yep!  Just return it and we're done.
  if( ! empty( $transient ) ) {
    
    // The function will return here every time after the first time it is run, until the transient expires.
    return $transient;

  // Nope!  We gotta make a call.
  } else {
  
    // We got this url from the documentation for the remote API.
    $url = 'http://www.lussocatering.co.uk/wp-json/posts?filter[posts_per_page]=3';

    $body =  wp_remote_retrieve_body(wp_remote_get($url));

    $json = json_decode($body);


    
    // We are structuring these args based on the API docs as well.
    //$args = array(
     // 'headers' => array(
        //'token' => 'example_token'
     // ),
    //);
    
    // Call the API.
    //$out = wp_remote_get( $url, $args );
    
    // Save the API response so we don't have to call again until tomorrow.

    set_site_transient( 'lusso_posts', $json, MINUTE_IN_SECONDS );
    
    // Return the list of subscribers.  The function will return here the first time it is run, and then once again, each time the transient expires.
    return $json;
    
  }
  
}

