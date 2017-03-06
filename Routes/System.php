<?php
/**
 * @package Routes
 * @Caution Heavy use of closures Ahead
 **/
 
/**
 * @route www.vtuacademy.com/Status/
 **/

$Router->get('/Status/', function() use ($Service) {
	if($Service->Config()->debug_mode_is_on()){

		echo "Monkey Do.";
	}
	else
	{
		echo "All Systems Are Go!";
	}
});

$Router->get('/members/system.install', function() use ($Service) { 
		   /////INSTALLATION STARTS HERE//////////////////////////  
		  $Service->Prote()->DBI()->user()->common()->install();
});

