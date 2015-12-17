<?php

/*
 Template Name: Lusso Posts
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
 ?>


 <?php get_header(); ?>


<?php $json = lusso_posts(); ?>

<?php #echo "<pre>";
	  #echo var_dump($json); 
	  #echo "<pre>";?>

<?php #die(); ?>


<?php  



for ($i=0; $i<3; $i++) {
	echo $i;
}



	foreach($json as $post){ 
 		$titles =  $post->title;
 		$images =  $post->featured_image->content;
 		$link 	=  $post->link;

 	 	?>

	 	<a href="<?php echo $link;?>">
	 		<div class="lusso-posts">
	 				
	 			<div class="image-container">
	 				<?php echo strip_tags($images, '<img>'); ?>
	 			</div>

	 			<h4><?php echo $titles; ?></h4>

	 		</div>
	 	</a>
		 <?php
 		}

?>




<?php get_footer(); ?>





