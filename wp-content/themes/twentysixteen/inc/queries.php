<h4>SELECT Query </h4>
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






 
	  	// Update
		global $wpdb; 
        $table = "wp_users";
        $data_array = array('user_status' => 1);
        $where = array('ID' => 1);
        $wpdb->update( $table, $data_array, $where, array('%d') );


        //Delete

        global $wpdb;
		$wpdb->query($wpdb->prepare("DELETE  FROM  wp_users WHERE ID = %d",2));
		$wpdb->query($wpdb->prepare("DELETE  FROM  wp_users WHERE ID = %d",9)); 



		// Create new user 
		if(false) {

		$user_name = 'jesus ' . rand(0,100);
		$user_email = 'jesus@gmail.com' . rand(0,100);

		$user_id = username_exists( $user_name );
		if ( !$user_id and email_exists($user_email) == false ) {
			$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
			$user_id = wp_create_user( $user_name, $random_password, $user_email );
		} else {
			$random_password = __('User already exists.  Password inherited.');
		}

}


if(false) {
		// Insert new data to custom table

		$wpdb->insert('custom_brand', array(
		    'name' => 'alrignt' . rand(0, 100), 
		));

}


	?>