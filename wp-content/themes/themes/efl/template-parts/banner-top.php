<?php 

if(!is_active_sidebar( 'banner-top' ))
	return;

dynamic_sidebar( 'banner-top' );