<?php

$routes=array(

array('GET|POST', 'index', 'index_page','index'),
array('GET', 'home', 'index_page'),
array('GET', '[a:business_name]','business_page')

);

?>