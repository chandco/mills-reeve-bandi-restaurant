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



?>

<div id="inner-content">
	<div class="posts-container">
		<header class="article-header">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</header>

<?php

	foreach($json as $post){ 
 		$titles =  $post->title;
 		$images =  $post->featured_image->content;
 		$link 	=  $post->link;

 	 	?>

 	 	<div class="lusso-posts" title="<?php echo $titles; ?>">
	 		<a href="<?php echo $link;?>">
	 				
	 			<div class="image-container">
	 				<?php echo strip_tags($images, '<img>'); ?>
	 			</div>


	 			<?php

	 			//get the title and store in a variable
				$thetitle = $titles; /* or you can use get_the_title() */
				//get the length of the post title
				$getlength = strlen($thetitle);
				//set a length to truncate the title to
				$thelength = 20;
				//if title is longer than 20 it will ad "..." 
				if ($getlength > $thelength) { 
					echo "<h5>". substr($thetitle, 0, $thelength) . "...</h5>";
				} else {
				//othwerwise we will show the title in it original format
					echo "<h5>". $titles . "</h5>";
				}
				?>

			</a>
	 	</div>

	<?php
 	}
?>
	</div>
</div>



<?php get_footer(); ?>





