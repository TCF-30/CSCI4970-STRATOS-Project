<?php
    require_once('../../globals.php');
    require APP . 'model\hardware\Hardware_model.php';
    require APP . 'controller\hardware\Hardware_controller.php';
    require APP . 'view\hardware\Hardware_view.php';

	$globals = new Globals();
    $hmodel = new Hardware_Model();
    $hview = new Hardware_View();
    $hcontr = new Hardware_Controller($hmodel, $hview, $globals, "hardware_index.php");

    $globals->handleURL($hcontr);
?>
