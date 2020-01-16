<?php

function tmp_profile_page_builder( $x ) {

	//var_dump( $x );

	$post_author		= esc_html( $x->post_author );
	$post_date		= esc_html( $x->post_date );
	$post_content		= esc_html( $x->post_content ); //This field contains the editor/description content
	$post_title		= esc_html( $x->post_title );
	//$post_excerpt		= esc_html( $x->post_excerpt );
	$post_date		= esc_html( $x->post_date );
	$post_status		= esc_html( $x->post_status );
	$ID			= esc_html( $x->ID );

	$pm			= get_post_meta( $ID );

	$job_role		= esc_html( $pm['tmp_job_role'][0] );
	$start_year		= esc_html( $pm['tmp_start_year'][0] );
	$favorite_quote		= esc_html( $pm['tmp_favorite_quote'][0] );
	$phone			= esc_html( $pm['tmp_phone'][0] );
	$email			= esc_html( $pm['tmp_email'][0] );


	if( $pm['tmp_branch'][0] ){
		$branch		= ", " . ucwords( str_replace( '_', ' ', esc_html( $pm['tmp_branch'][0] ) ) );	
	} else {
		$branch		= "";
	};


	// If there is a post thumbnail set it to the current one for the profile
	$post_thumbnail_url	= get_the_post_thumbnail_url( $ID );	

	echo "
		<div id='team-member-$ID' class='' style='text-align: center;'>
			<img src='$post_thumbnail_url' style='width: 33vw;' />
			<h3>$post_title</h3>
			<h5><em>$job_role$branch Office</em></h5>
			<p>$post_content</p>
			<!--ul>
				<li>$job_role</li>
				<li>$start_year</li>
				<li>$favorite_quote</li>
				<li>$email</li>
				<li>$phone</li>
			</ul-->

		</div>
	";

}



?>
