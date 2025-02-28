<?php
		/**
	 * This class used for fault calculation
	 *
	 */
	class FaultCalculation {
		static function uscal($X1, $X2, $X3, $C, $CC, $DP) {
			$SN = sin($DP);
			$CS = cos($DP);
			$C1 = $C;
			$C2 = $CC*$CS;
			$C3 = $CC*$SN;
			$R = sqrt(pow($X1-$C1, 2) + pow($X2-$C2, 2) + pow($X3-$C3, 2));
			$Q = sqrt(pow($X1-$C1, 2) + pow($X2-$C2, 2) + pow($X3+$C3, 2));
			$R2 = $X2*$SN - $X3*$CS;
			$R3 = $X2*$CS + $X3*$SN;
			$Q2 = $X2*$SN + $X3*$CS;
			$Q3 = -$X2*$CS + $X3*$SN;
			$H = sqrt(pow($Q2, 2)+ pow($Q3+$CC, 2));
			$K = sqrt(pow($X1-$C1, 2) + pow($Q2, 2));
			$A1 = log($R+$R3-$CC);
			$A2 = log($Q+$Q3+$CC);
			$A3 = log($Q+$X3+$C3);
			$B1 = 1+3.0*pow((tan($DP)), 2);
			$B2 = 3.0*tan($DP)/$CS;
			$B3 = 2.0*$R2*$SN;
			$B4 = $Q2+$X2*$SN;
			$B5 = 2.0*pow($R2, 2)*$CS;
			$B6 = $R*($R+$R3-$CC);
			$B7 = 4.0*$Q2*$X3*pow($SN, 2);
			$B8 = 2.0*($Q2+$X2*$SN)*($X3+$Q3*$SN);
			$B9 = $Q*($Q+$Q3+$CC);
			$B10 = 4.0*$Q2*$X3*$SN;
			$B11 = ($X3+$C3)-$Q3*$SN;
			$B12 = 4.0*pow($Q2, 2)*$Q3*$X3*$CS*$SN;
			$B13 = 2.0*$Q+$Q3+$CC;
			$B14 = pow($Q, 3)*pow($Q+$Q3+$CC, 2);
			$F = $CS*($A1+$B1*$A2-$B2*$A3)+$B3/$R+2*$SN*$B4/$Q-$B5/$B6+($B7-$B8)/$B9+$B10*$B11/pow($Q, 3)-$B12*$B13/$B14;
			return $F;
		}
		
		static function udcal($X1, $X2, $X3, $C, $CC, $DP) {
			$SN = sin($DP);
			$CS = cos($DP);
			$C1 = $C;
			$C2 = $CC*$CS;
			$C3 = $CC*$SN;
			$R = sqrt(pow($X1-$C1, 2)+ pow($X2-$C2, 2)+ pow($X3-$C3, 2));
			$Q = sqrt(pow($X1-$C1, 2)+ pow($X2-$C2, 2)+ pow($X3+$C3, 2));
			$R2 = $X2*$SN-$X3*$CS;
			$R3 = $X2*$CS+$X3*$SN;
			$Q2 = $X2*$SN+$X3*$CS;
			$Q3 = -$X2*$CS+$X3*$SN;
			$H = sqrt(pow($Q2, 2) + pow($Q3+$CC, 2));
			$K = sqrt(pow($X1-$C1, 2) + pow($Q2, 2));
			$A1 = log($R+$X1-$C1);
			$A2 = log($Q+$X1-$C1);
			$B1 = $Q*($Q+$X1-$C1);
			$B2 = $R*($R+$X1-$C1);
			$B3 = $Q*($Q+$Q3+$CC);
			$D1 = $X1-$C1;
			$D2 = $X2-$C2;
			$D3 = $X3-$C3;
			$D4 = $X3+$C3;
			$D5 = $R3-$CC;
			$D6 = $Q3+$CC;
			$T1 = atan2($D1*$D2,($H+$D4)*($Q+$H));
			$T2 = atan2($D1*$D5,$R2*$R);
			$T3 = atan2($D1*$D6,$Q2*$Q);
			$G = $SN*($D2*(2*$D3/$B2+4*$D3/$B1-4*$C3*$X3*$D4*(2*$Q+$D1)/(pow($B1, 2)*$Q))-6*$T1+3*$T2-6*$T3)+$CS*($A1-$A2-2*(pow($D3, 2))/$B2-4*(pow($D4, 2)-$C3*$X3)/$B1-4*$C3*$X3*pow($D4, 2)*(2*$Q+$X1-$C1)/(pow($B1, 2)*$Q))+6*$X3*($CS*$SN*(2*$D6/$B1+$D1/$B3)-$Q2*(pow($SN, 2)-pow($CS, 2))/$B1) ;
			return $G;
		}
	}
	
	/**
	 * Time Stop class
	 *
	 */
	class Timer {
		/**
		 * timing
		 *
		 * @return float
		 */
		static function microtime_float() {
			list($usec, $sec) = explode(" ", microtime());
			return ((float)$usec + (float)$sec);
		}
	}

	/**
	 * The class is refered to MATLAB function 
	 *
	 */
	class MATLAB {
		static function LinearlySpacedVector($d1, $d2, $n) {
			/* MATLAB body
				if nargin == 2
				    n = 100;
				end
				
				y = [d1+(0:n-2)*(d2-d1)/(floor(n)-1) d2];
			*/
			$value = array();
			for($i=0; $i<=($n-2); $i++) {
				$value[($i+1)] = doubleval(($d1+$i*($d2-$d1)/(floor($n)-1)));
			}
			$value[($i+1)] = doubleval($d2);
			
			/**
			 * Result may be like this:
			 * [ 0....$value d2]
			 * |<-- 10 Elem -->|
			 * */
			return $value;
		}
	}
	
?>