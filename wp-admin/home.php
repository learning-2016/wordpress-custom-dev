<?php
/**
 * Dashboard Administration Screen
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
 
include( ABSPATH . 'wp-admin/admin-header.php' );
?>
<br>
  <?php 



 
		// QUery
	  global $wpdb; 
	  // find list of states in DB
	  $qry = "SELECT * FROM wp_users";
	  $states = $wpdb->get_results( $qry); 
	  echo "<pre>"; 

	  echo " <br>object <br>";
	  print_r($states); 
 
	  echo "</pre>";

	  foreach ($states as $key => $value) {
	  	echo " $key => " . $value->ID . '<br>';
	  }

 

  ?>







<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
  </style>
</head>
<body>
 
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="http://localhost/tutorials/youtube/wordpress/wp-content/uploads/2016/02/me.jpg" alt="Chania" width="460" height="345">
      </div>

      <div class="item">
        <img src="http://localhost/tutorials/youtube/wordpress/wp-content/uploads/2016/02/^BE8643B758713B5FAA47169A32D8C07F09A56B5AE56A95129B^pimgpsh_fullsize_distr.jpg" alt="Chania" width="460" height="345">
      </div>
    
      <div class="item">
        <img src="http://localhost/tutorials/youtube/wordpress/wp-content/uploads/2016/02/product-1.jpg" alt="Flower" width="460" height="345">
      </div>

     
    </div>


    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
 


 <br><br><br><br>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John</td>
        <td>Doe</td>
        <td>john@example.com</td>
      </tr>
      <tr>
        <td>Mary</td>
        <td>Moe</td>
        <td>mary@example.com</td>
      </tr>
      <tr>
        <td>July</td>
        <td>Dooley</td>
        <td>july@example.com</td>
      </tr>
    </tbody>
  </table> 










 

</body>
</html>



































<?php
require( ABSPATH . 'wp-admin/admin-footer.php' );

?>



<style type="text/css">
	.home-active {
		border:1px solid red;
		background-color: black;
		color:white;
	}

</style>
