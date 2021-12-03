<?php
namespace sorm\interfaces;

interface value_mapper {

/**
*must always return a scalar.
*/
	public function from_storage(string $_type, $_value);

/**
*must always return a scalar.
*/
	public function to_storage(string $_type, $_value);
}
