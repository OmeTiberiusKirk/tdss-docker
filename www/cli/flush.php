<?
	// This works !
	ob_implicit_flush();
	for($i=0;$i<10;$i++) {
	  echo "yeah :-))))\n";
	  @ob_flush();
	  sleep(1);
	}
?>