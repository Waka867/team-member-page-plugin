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

	//var_dump( $pm );
	
	/*
	echo $pm['tmp_job_role'][0];
	echo $pm['tmp_branch'][0];
	echo $pm['tmp_start_year'][0];
	echo $pm['tmp_favorite_quote'][0];
	echo $pm['tmp_phone'][0];
	echo $pm['tmp_email'][0];
	*/


	if( $pm['tmp_branch'][0] ){
		$branch		= ", " . ucwords( str_replace( '_', ' ', $pm['tmp_branch'][0] ) );	
	} else {
		$branch		= "";
	};


	// If there is a post thumbnail set it to the current one for the profile
	$post_thumbnail_url	= get_the_post_thumbnail_url( $ID );	

	echo "

	
		<div id='team-member-$ID' class='' style='text-align: center;'>
			<img src='$post_thumbnail_url' style='width: 33vw;' />
			<h3>$post_title</h3>
			<h5><em>{$pm['tmp_job_role'][0]}$branch Office</em></h5>
			<p>$post_content</p>

		</div>


	";

}









?>
