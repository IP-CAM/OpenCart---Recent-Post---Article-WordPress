<!-- Start Wordpress Blog Module - Show Recent Post from WordPress Site -->
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
	<?php 
	if( empty($posts) ){
	?>
	<div class="box-wordpress-blog">
	<h2><?php echo $empty_data; ?></h2>
	</div>
	<?php 
	}else{
		if( $setting['type'] == "horizontal" ){
	?>
	    <ul class="box-wordpress-blog box-product">
		<?php foreach( $posts as $post ){ ?>
			<li>
			<div class="article-section">
			<h2 class="article-title name">
			<a href="<?php echo $post->permalink; ?>" 
			rel="bookmark" title="<?php echo $post->post_title; ?>">
			<?php echo $post->post_title; ?></a>
			</h2>
			<div class="article-author-section">
			<span class="author-name"><?php echo $post->author_name; ?></span>
			<span class="article-date"><?php echo $post->post_date; ?></span>
			</div>
			<?php echo $post->post_excerpt; ?>
			<div class="read-more">
			<a href="<?php echo $post->permalink; ?>" class="button"><?php echo $read_more_txt; ?></a>
			</div>
			</div>
			</li>
		<?php } ?>
	    </ul>
	<?php
		}
		else{
		?>
	    <ul class="box-wordpress-blog box-product">
		<?php foreach( $posts as $post ){ ?>
			<li>
			<div class="article-section">
			<h2 class="article-title name">
			<a href="<?php echo $post->permalink; ?>" 
			rel="bookmark" title="<?php echo $post->post_title; ?>">
			<?php echo $post->post_title; ?></a>
			</h2>
			<div class="article-author-section">
			<?php echo $by_txt; ?><span class="author-name"><?php echo $post->author_name; ?></span>
			</div>
			</div>
			</li>
		<?php } ?>
	    </ul>
		<?php
		}
	?>
	<div style="clear:both;"></div>	
	<?php 	
	}
	?>
  </div>
</div>
<!-- End Wordpress Blog Module - Show Recent Post from WordPress Site -->