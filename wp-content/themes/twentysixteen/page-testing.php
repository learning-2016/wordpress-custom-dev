<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
 
if ( is_user_logged_in() ) {
    echo 'Welcome, registered user!';
} else {
    echo 'Welcome, visitor!<br><br>';
    wp_redirect( home_url( 'login') ); exit; 
}
get_header(); ?>

<?php include 'inc/pages/page-header.php'; ?>

<?php include 'inc/config.php'; ?>
 

?>
 

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main"> 

	 <?php include 'inc/queries.php'; ?>

 

  	 <input type="text" > 


  	 <input type="text" > 


  	 <input type="text" > 

  	 <?php  






  	 	echo "<br>get emaail = " . $_GET['email'];
  	 	echo "<br>get pwd = " . $_GET['pwd']; 

  	 	 	echo "<br>post emaail = " . $_POST['email'];
  	 	echo "<br>post pwd = " . $_POST['pwd']; 
  	 ?>


  	 <h4> get </h4>
   <form role="form" method="POST">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="checkbox">
      <label><input type="checkbox"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>

  <h4> post </h4>


  

  	 <?php require 'inc/pages/page-include.php'; ?>

	</main><!-- .site-main -->

	<?php  get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
