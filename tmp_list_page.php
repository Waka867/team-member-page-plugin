<?php

function tmp_profile_page_builder( $x ) {

	//var_dump( $x );

	$post_author		= $x->post_author;
	$post_date		= $x->post_date;
	$post_content		= $x->post_content; //This field contains the editor/description content
	$post_title		= $x->post_title;
	//$post_excerpt		= $x->post_excerpt;
	$post_date		= $x->post_date;
	$post_status		= $x->post_status;
	$ID			= $x->ID;

	$pm			= get_post_meta( $ID );

	$job_role		= $pm['tmp_job_role'][0];
	$start_year		= $pm['tmp_start_year'][0];
	$favorite_quote		= $pm['tmp_favorite_quote'][0];
	$phone			= $pm['tmp_phone'][0];
	$email			= $pm['tmp_email'][0];


	if( $pm['tmp_branch'][0] ){
		$branch		= ", " . ucwords( str_replace( '_', ' ', $pm['tmp_branch'][0] ) );	
	} else {
		$branch		= "";
	};


	// If there is a post thumbnail set it to the current one for the profile
	$post_thumbnail_url	= get_the_post_thumbnail_url( $ID );	





	// REMINDER: Make sure to late escape right as variable is being called.
	echo "
		<div id='team-member-$ID' class='' style='text-align: center;'>
			<img src='" . esc_url( $post_thumbnail_url ) . "' style='width: 33vw;' />
			<h3>" . esc_html( $post_title ) . "</h3>
			<h5><em>" . esc_html( $job_role ) . esc_html( $branch ) . " Office</em></h5>
			<p>" . esc_html( $post_content ) . "</p>
			<!--ul>
				<li>" . esc_html( $job_role ) . "</li>
				<li>" . esc_html( $start_year ) . "</li>
				<li>" . esc_html( $favorite_quote ) . "</li>
				<li>" . esc_html( $email ) . "</li>
				<li>" . esc_html( $phone ) . "</li>
			</ul-->

		</div>
	";

}



?>
