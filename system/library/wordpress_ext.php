<?php
require('../../blog/wp-load.php');

function the_excerpt_max_charlength($charlength, $excerpt) {
	$charlength++;
	
	$str_the_excerpt= "";
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$str_the_excerpt.= mb_substr( $subex, 0, $excut );
		} else {
			$str_the_excerpt.= $subex;
		}
		return $str_the_excerpt.= '[...]';
	} else {
		return $excerpt;
	}
}

$GET= $_GET;
// The Query
$args= array('posts_per_page'=>$GET['posts_per_page']);
$the_query= new WP_Query($args);
$res= $the_query->get_posts();

$posts= array();
foreach( $res as $key=>$post ){
	$post= get_post($post->ID);
	$post->permalink= get_permalink($post->ID);
	$post->author_name= get_author_name($post->post_author);
	$post->author_link= get_author_link("", $post->post_author);
	$post->post_date= date(urldecode($GET['format_date']), strtotime($post->post_date));
	$post->post_excerpt= the_excerpt_max_charlength($GET['length_description'], $post->post_content);
	$post->post_excerpt = str_replace('[...]', '...', apply_filters( 'the_content', $post->post_excerpt ));
	$post->post_content = apply_filters( 'the_content', $post->post_content );
	$posts[$key]= $post;
}
echo json_encode($posts);
exit;
?>