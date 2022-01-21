<?php

/**
 * Template Name: Gutbcontent scientific article post template
 * Template Post Type: post, page
 **/
?>

<!-- Need apply custom CSS to custom menu. -->
<!-- I. Header -->
<?php

  require('header.php'); 
  global $gutbcontentPluginUrl;

?>


<!-- II. Body -->
<!-- 1. Meta data  -->
<h2 class="px-2"> <?php the_title(); ?> </h2>

<small class="px-2"> Posted date : <?php the_time('F j, Y - g:i a'); ?> <br></small>
<small class="px-2"> Category: <?php the_category(', '); ?> <br> </small>

<!--<div class="thumbnail-image"> <?php /*the_post_thumbnail('large'); */?> </div>-->
<br>
<!-- 2. The detail body content -->

<?php //get_sidebar();
  require_once('helper/ContentGeneratorCustomTOC.php');

  $customContentGenerator = new ContentGeneratorCustomTOC();


?>


<div class="row" id="main-content-science-custom-post-layout">


  <!-- 1. Get the sticky TOC with pretty format here. -->
  <div class="col-xs-3 col-sm-3 custom-table-of-content">    
    <span class="gutbcontent-menu-icon gutbcontent-close-small"></span>
    <?php echo $customContentGenerator->orderedTOC; ?>    
  </div>

  <div class="col-xs-9 col-sm-9 custom-content-template-science">


    <!-- 2. The content  -->
    <?php
      // get_template_part('template-custom/content','body');  // include content-body.php
      // the_content();
      echo $customContentGenerator->updatedHtmlData;
    ?>
  </div>
</div>

<!-- 5. Comments  -->
<hr>
<?php
if (comments_open()):
  comments_template();
else:
  echo '<p class="text-center">Sorry, comments are disabled</p>';
endif;
?>

<!-- III. Footer -->

<footer>


<?php
   /*  echo sprintf(
      '<script src="%s"></script>',
      $gutbcontentPluginUrl.'assets/page/js/template-scientific-post.js'
    ); */
    
  // Get the footer created by the themes
  get_footer();
?>

</footer>

<?php wp_footer(); ?>

</body>
</html>


