<?php
$fullforms = [
				"vcd"=>"Vigilance Control Device",
				"spm"=>"Speedometer Analysis",
				"cb" =>"Crew Booking",
				"spm_checking"=>"Speedometer Analysis",
				"vcd_analysis"=>"Vigilance Control Device",
				"rr"=>"Running Room",
				"cb"=>"Crew Booking",
				"adj_division"=>"Adjacent Division",
				"amb_by_speed_gun"=>"Speed Gun Check",
				"jss"=>"Joint Signal Sighting",
				"mobile_phone_check"=>"Mobile Phone Check",
				"safety_seminar"=>"Safety Seminar",
				"sob"=>"Standing Order Booking",
				"tsc"=>"TroubleShooting Console",
				"sec/sfc"=>"SEC/SFC Counselling",
				"safety_drive"=>"Safety Drive",
				"bct"=>"Brake contuinity test",
				"bft"=>"Brake feel test",
				"bpt"=>"Brake power test	",
				"lc"=>"Loudly & Clearly	",
				"snsn"=>"Station name and Signal	",
				"hg"=>"Hand Gesture	",
				"caution_aspect"=>"Caution Aspects with speed restrictions	",
				"st1"=>"While Starting a Train	",
				"st2"=>"While Stopping a Train	",
				"red"=>"Stopping train at adequate distance of DANGER signal	",
				"alertness"=>"Alertness of crew	",
				"caution_order"=>"Observing Caution order & PSR speeds	",
				"attacking"=>"Picking up of attacking speed	",
				"up_technique"=>"Notching UP technique	",
				"brake_technique"=>"Braking Technique	",
				"spad"=>"SPAD prevention knowledge	",
				"cts"=>"Conventional loco Trouble Shooting knowledge	",
				"pts"=>"3 Phase loco Trouble Shooting knowledge	"

			];
function getFullForm($short_form){
		$sf = strtolower($short_form);
		global $fullforms;
		if(array_key_exists($sf,  $fullforms)){
			return  $fullforms[$sf];
		}
		return $short_form;
}



?>