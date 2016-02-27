<?php 

	add_action( 'abaris_credits', 'abaris_display_credits' );
	function abaris_display_credits() { ?>
		<p>
		Powered by <a href="http://wordpress.org/"><?php printf( __( '%s', 'abaris' ), 'WordPress' ); ?></a>
		<span class="sep"> | </span>
		<?php printf( __( 'Theme: %1$s by %2$s.', 'abaris' ), 'Abaris', '<a href="http://www.webulousthemes.com" rel="author">Webulous Themes</a>' ); ?>
		</p>
<?php 
	}

 ?>