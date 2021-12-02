<?php
namespace sorm\interfaces;

interface storage_interface {

/**
*must create the entity defined in the payload and return its primary key, of any type.
*/
	public function create(\sorm\internal\payload $_payload) : \sorm\internal\value;

/**
*must update the entity defined in the payload
*/
	public function update(\sorm\internal\payload $_payload) : void;

/**
*must delete the entity defined in the payload (whose only value will be the
*primary key)
*/
	public function delete(\sorm\internal\payload $_payload) : void;
}
