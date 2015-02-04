<?php 
	session_start();
	require_once('rpgparadize.class.php');
	$rpg = new RPGParadize_API( 42689 );
	
	echo $rpg->vote;