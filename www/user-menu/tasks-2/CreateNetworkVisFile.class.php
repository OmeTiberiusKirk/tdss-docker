<?php
	
	require_once('visualization.class.php');
	
	define("WAVE_ANIMATION", "Wave Animation");
	define("VELOCITY", "Velocity");
	define("DEPTH", "Depth");
	define("HEIGHT", "Height");
	define("ETA", "The Elapsed Time Arrival");

	class BuildVisualizationNetwork {
	
		/* Configuration of region location */
		private $Latitude = array();
		private $Longitude = array();
		
		/* axes on network file */
		private $AutoAxesLatitude = array();
		private $AutoAxesLongitude = array();
		
		/* observation point information */
		private $PointsInfo = array();
		private $PointsValues = array();
		private $PointName;
		private $PointPosition;
		private $PointDX;
		private $PointTable = array();
		
		/* input files */
		private $DX_RegionFilePath;
		private $DX_WaterLevelFilePath;
		private $OUT_WaterLevelFilePath;
		private $DX_RegionFilename;
		private $DX_WaterLevelFilename;
		
		/* network of module filename */
		private $NetworkFilename;
		private $NetworkFileContents;
		
		/* visualization object */
		private $VisObj;
		
		/* network of module configuration */
		private $NetworkType;
		private $NetworkDisplayType;
		private $RegionNo;
		
		/* lat & long for autoaxes */
		private $Lat_1;
		private $Lat_Lipda_1;
		private $Lat_Philipda_1;
		private $Lat_2;
		private $Lat_Lipda_2;
		private $Lat_Philipda_2;
		private $Long_1;
		private $Long_Lipda_1;
		private $Long_Philipda_1;
		private $Long_2;
		private $Long_Lipda_2;
		private $Long_Philipda_2;
		
		/* number of grid */
		private $GridX;
		private $GridY;
		
		/* resoluction */
		private $Scale_Lipda;
		private $Scale_Philipda;
		
		/* label of auto-axes */
		private $LabelAxesX;
		private $LabelAxesY;
		private $PositionAxesX;
		private $PositionAxesY;
		
		private $grp_id;
		
		public function __construct($network_file_type, $filename, $region_no, $display_type, $DX_region_filename, $DX_waterlevel_filename, $grp_id) {
			$this->NetworkType = $network_file_type;
			$this->NetworkDisplayType = $display_type;
			$this->RegionNo = $region_no;
			$this->NetworkFilename = $filename;
			$this->DX_RegionFilename = $DX_region_filename;
			$this->DX_WaterLevelFilename = $DX_waterlevel_filename;
			$this->grp_id = $grp_id;
			$this->run();
		}
		
		private function run() {
			$this->VisObj = new Visualization($this->NetworkType, $this->NetworkDisplayType, $this->NetworkFilename, $this->RegionNo, $this->grp_id);
		}
		
		public function AssignDXInput($dx_region_filepath, $dx_water_level_filepath) {
			//if(file_exists($dx_region_filepath)) {
				$this->DX_RegionFilePath = $dx_region_filepath;
			/*}else {
				die("! death at ".__LINE__.":".__FILE__);
			}
			
			if(file_exists($dx_water_level_filepath)) {*/
				$this->DX_WaterLevelFilePath = $dx_water_level_filepath;
			/*}else {
				die("! death at ".__LINE__.":".__FILE__);
			}*/
		}
		
		public function AssignAutoAxesLatitude($Lat_1, $Lat_Lipda_1, $Lat_Philipda_1, $Lat_2, $Lat_Lipda_2, $Lip_Philipda_2) {
			$this->Lat_1 = $Lat_1;
			$this->Lat_2 = $Lat_2;
			$this->Lat_Lipda_1 = $Lat_Lipda_1;
			$this->Lat_Lipda_2 = $Lat_Lipda_2;
			$this->Lat_Philipda_1 = $Lat_Philipda_1;
			$this->Lat_Philipda_2 = $Lat_Philipda_2;
		}
		
		public function AssignAutoAxesLongitude($Long_1, $Long_Lipda_1, $Long_Philipda_1, $Long_2, $Long_Lipda_2, $Long_Philipda_2) {
			$this->Long_1 = $Long_1;
			$this->Long_2 = $Long_2;
			$this->Long_Lipda_1 = $Long_Lipda_1;
			$this->Long_Lipda_2 = $Long_Lipda_2;
			$this->Long_Philipda_1 = $Long_Philipda_1;
			$this->Long_Philipda_2 = $Long_Philipda_2;
		}
		
		public function AssignNoGrids($grids_x, $grids_y) {
			$this->GridX = $grids_x;
			$this->GridY = $grids_y;
		}
		
		public function AssignRegionResolution($lipda, $philipda) {
			$this->Scale_Lipda = $lipda;
			$this->Scale_Philipda = $philipda;
		}
		
		public function AssignWaterLevelData($wl_filepath) {
			if(file_exists($wl_filepath)) {
				$this->OUT_WaterLevelFilePath = $wl_filepath;
			}else {
				die("! death at ".__LINE__.":".__FILE__);
			}
		}
		
		public function AssignPointInfo($point) {
			if(is_array($point))
				$this->PointsInfo = $point;
		}
		
		public function CalculateALL() {
			
			/* calculate location */
			$this->Latitude = $this->VisObj->calculate_Lat_Long(
								$this->Lat_1, $this->Lat_Lipda_1, $this->Lat_Philipda_1, $this->Lat_2, $this->Lat_Lipda_2, $this->Lat_Philipda_2, 
								$this->Scale_Lipda, $this->Scale_Philipda, $this->GridX, $this->GridY, "lat");
			$this->Longitude = $this->VisObj->calculate_Lat_Long(
								$this->Long_1, $this->Long_Lipda_1, $this->Long_Philipda_1, $this->Long_2, $this->Long_Lipda_2, $this->Long_Philipda_2,
								$this->Scale_Lipda, $this->Scale_Philipda, $this->GridX, $this->GridY, "long");
								
			/* calculate auto axes */
			/*
			echo $this->Latitude[0]."\n";
			echo $this->Latitude[2]."\n";
			echo $this->GridY."\n\n";
			
			echo $this->Longitude[0]."\n";
			echo $this->Longitude[2]."\n";
			echo $this->GridX."\n\n";
			
			exit;
			*/
			
			$this->AutoAxesLatitude = $this->VisObj->Calculate_AutoAxes($this->Latitude[0], $this->Latitude[2], $this->GridY);
			$this->AutoAxesLongitude = $this->VisObj->Calculate_AutoAxes($this->Longitude[0], $this->Longitude[2], $this->GridX);
			
			/* cal the positioning of axes */
			for($i = 0; $i<count($this->AutoAxesLatitude['dx']); $i++) {
				$this->PositionAxesY = implode($this->AutoAxesLatitude['dx']," ");
				if($i == (count($this->AutoAxesLatitude['dx'])-1))
					$this->LabelAxesY .= '"'.$this->AutoAxesLatitude['list'][$i].'" ';
				else
					$this->LabelAxesY .= '"'.$this->AutoAxesLatitude['list'][$i].'", ';
			}
			
			for($i = 0; $i<count($this->AutoAxesLongitude['dx']); $i++) {
				$this->PositionAxesX = implode($this->AutoAxesLongitude['dx']," ");
				if($i == (count($this->AutoAxesLongitude['dx'])-1))
					$this->LabelAxesX .= '"'.$this->AutoAxesLongitude['list'][$i].'" ';
				else
					$this->LabelAxesX .= '"'.$this->AutoAxesLongitude['list'][$i].'", ';
			}
			/* formerly $Val_4_Point */
			$this->PointsValues = $this->VisObj->Calculate_Value_4_Point($this->PointsInfo);
			
			/* point in network file */
			/* n */
			$c = 0;
			/* n */
			for($i = 0; $i<count($this->PointsValues['name']); $i++) {
				$this->PointDX[$i] = $this->VisObj->Calculate_Point(
									$this->PointsValues['lat'][$i], $this->PointsValues['long'][$i], 
									$this->Latitude[0], $this->Latitude[1], $this->Latitude[2], 
									$this->Longitude[0], $this->Longitude[1], $this->Longitude[2], $this->RegionNo
								);
				/* n */
				if($this->PointDX[$i] != NULL) {
					$poi['name'][$c] = $this->PointsValues['name'][$i];
					$poi['position'][$c++] = "[".round($this->PointDX[$i]['lat'])." ".round($this->PointDX[$i]['long'])." 0]";
				}
				
				/* n */
				/*
				if($i == (count($this->PointsValues['name'])-1)) {
					$this->PointName .= '"'.$this->PointsValues['name'][$i].'" ';
					$this->PointPosition .= "[".$this->PointDX[$i]['lat']." ".$this->PointDX[$i]['long']." 0]";
				} else {
					$this->PointName .= '"'.$this->PointsValues['name'][$i].'", ';
					$this->PointPosition .= "[".$this->PointDX[$i]['lat']." ".$this->PointDX[$i]['long']." 0], ";
				}
				*/
			}
			for($a=0; $a<count($poi['name']); $a++) {
				$point_name[] = '"'.$poi['name'][$a].'"';
				$point_position[] = $poi['position'][$a];
			}
			
			$this->PointName = implode(", ", $point_name);
			$this->PointPosition = implode(", ", $point_position);
		}
		
		public function getPointsTable() {
			if(count($this->PointsValues) != 0) {
				$this->PointTable = $this->VisObj->Calculate_Point_Table(
										$this->PointDX, 
										$this->PointsValues['name'], 
										$this->GridX, 
										$this->GridY, 
										$this->OUT_WaterLevelFilePath
									);
			}else {
				die("! death on ".__LINE__.":".__FILE__);
			}
			
			return $this->PointTable;
		}
		
		public function getPointTable2() {
			$fp = fopen($this->OUT_WaterLevelFilePath, "r");
		}
		
		public function BuildNetwork($zoom, $resolution, $rotate_x, $rotate_y, $rotate_z, $contour_line, $contour_line2, $axes_scale, $network_type, $reg_no) {
			$this->NetworkFileContents = $this->VisObj->CreateNetworkFile(
						$this->DX_RegionFilePath, 
						$this->DX_WaterLevelFilePath, 
						$this->NetworkFilename, 
						$zoom, 			//zoom
						$resolution, 	//resolution
						$rotate_x, 		//rotate_x
						$rotate_y, 		//rotate_y
						$rotate_z,		//rotate_z
						$this->GridX,	//grid_x
						$this->GridY,	//grid_y
						null,
						$this->DX_RegionFilename,
						$this->DX_WaterLevelFilename,
						$this->PositionAxesY,
						$this->LabelAxesY,
						$this->PositionAxesX,
						$this->LabelAxesX,
						$this->PointName,
						$this->PointPosition,
						$contour_line,
						$contour_line2,
						$axes_scale,
						$network_type,
						$reg_no
					);

		}
		
		public function getNetworkFileContents() {
			return $this->NetworkFileContents;
		}
	}
?>