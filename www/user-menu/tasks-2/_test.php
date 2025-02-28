<?php

	$levels = array(
		'Guests' => "1000" ,
		'Users' => "1100",
		'Mods' => "1110" ,
		'Admins' => "1111" ,
	);
	
	
	/*
	*Function to assign Permissions based on Group membership
	*/
	
	function permission( $p )
	{
		// Split the levels string into an array
		$perm = str_split( $p );
		
		// Permissions array
		$up = array(
			'can_view_links_1' => 1,
			'can_view_links_2' => 2,
			'can_view_links_3' => 3,
			'can_view_links_4' => 4,
		);
		$combine = array_combine( array_keys( $up ), $perm );
		
		return $combine;
	}
	
	/*
	* Procedure Test Printing
	*/
	
	foreach ( $levels as $i => $value) {
	
		/* print Group name here */
		echo '<h3>' . $i . '</h3>' ;
		
		/* call function to assign permissions */
		$p = permission( $levels[$i] );
		
		/* check Guest permissions */
		if( $p['can_view_links_1'] == 1 ){
			echo 'can view Guest links&nbsp;&nbsp;' . $p['can_view_links_1'] . '<br />';
		} else {
			echo 'no links here&nbsp;&nbsp;' . $p['can_view_links_1'] . '<br />';
		}
		
		/* check Member permissions */
		if( $p['can_view_links_2'] == 1 ){
			echo 'can view Member links&nbsp;&nbsp;' . $p['can_view_links_2'] . '<br />';
		} else {
			echo 'no links here&nbsp;&nbsp;' . $p['can_view_links_2'] . '<br />';
		}
		/* check Moderator permissions */
		if( $p['can_view_links_3'] == 1 ){
			echo 'can view Moderator links&nbsp;&nbsp;' . $p['can_view_links_3'] . '<br />';
		} else {
			echo 'no links here&nbsp;&nbsp;' . $p['can_view_links_3'] . '<br />';
		}
		
		/* check Administrator permissions */
		if( $p['can_view_links_4'] == 1 ){
			echo 'can view Admin links&nbsp;&nbsp;' . $p['can_view_links_4'] . '<br />';
		} else {
			echo 'no links here&nbsp;&nbsp;' . $p['can_view_links_4'] . '<br />';
		}
	}

?>