<?php
namespace sorm\interfaces;

interface storage_interface {

	public function get_fetch_translator() :\sorm\interfaces\fetch_translator;

/**
*must create the entity defined in the payload and return its primary key,
*of any type. Must throw if the entity cannot be persisted (for example, was
*already persisted before).
*/
	public function create(\sorm\internal\payload $_payload) : \sorm\internal\value;

/**
*must update the entity defined in the payload. Must throw if the entity cannot
*be updated (for example, because it does not exist).
*/
	public function update(\sorm\internal\payload $_payload) : void;

/**
*must delete the entity defined in the payload. Must throw if the entity
*cannot be deleted (for example, because it does not exist).
*/
	public function delete(\sorm\internal\payload $_payload) : void;
}
