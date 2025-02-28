<?php
	/**
	 * Stop watch for clocking of execute the script
	 *
	 */
	class Timer {
		/**
		 * timing
		 *
		 * @return float
		 */
		static function Now() {
			list($usec, $sec) = explode(" ", microtime());
		     return ((float)$usec + (float)$sec);
		}
	}
?>
