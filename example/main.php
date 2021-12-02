<?php
spl_autoload_register(function(string $_class) {

	$filename=__DIR__."/src/external/".str_replace("\\", "/", $_class).".php";
	if(file_exists($filename)) {

		require_once($filename);
		return;
	}

	$filename=__DIR__."/../src/".str_replace("\\", "/", $_class).".php";
	if(file_exists($filename)) {

		require_once($filename);
		return;
	}

	$filename=__DIR__."/src/".str_replace("\\", "/", $_class).".php";
	if(file_exists($filename)) {

		require_once($filename);
		return;
	}

	throw new \Exception("could not load class $_class from ".__DIR__);
});

$logger=new \log\out_logger(
	new \log\default_formatter()
);

$entity_factory=new \oimpl\entity_factory();
$on_default_builder=null;
$entity_name_mapper=new \oimpl\entity_name_mapper();
$entity_property_mapper=new \oimpl\entity_property_mapper();

$em=new \sorm\entity_manager(
	__DIR__."/map.json",
	$logger,
	$entity_factory,
	$entity_property_mapper,
	$on_default_builder,
	$entity_name_mapper
);

$user=new \app\user();
var_dump($user);
$blank_user=$em->build(\app\user::class);
var_dump($blank_user);
