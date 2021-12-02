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

$username="root";
$pass="1234";
$dsn="mysql:dbname=test;host=localhost;charset=utf8";

$PDO=new \PDO($dsn, $username, $pass);

$entity_factory=new \oimpl\entity_factory();
$on_default_builder=null;
$entity_name_mapper=new \oimpl\entity_name_mapper();
$storage_interface=new \sorm\pdo_storage_interface($PDO);
$entity_property_mapper=new \oimpl\entity_property_mapper();

$em=new \sorm\entity_manager(
	__DIR__."/map.json",
	$logger,
	$storage_interface,
	$entity_factory,
	$entity_property_mapper,
	$on_default_builder,
	$entity_name_mapper
);

/**@var \app\user*/
//TODO: on_create, on_update, on_delete...
//TODO: test on_default builder
//TODO: value mapper from and to application realm

$blank_user=$em->build(\app\user::class);
$blank_user->set_username("myusername")
	->set_password(hash("SHA512", "some_pass"))
	->set_login_count(0);

var_dump($blank_user);
$em->create($blank_user);
var_dump($blank_user);
