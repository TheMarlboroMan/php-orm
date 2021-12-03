<?php
namespace sorm\interfaces;

interface value_mapper {

	public function from_storage(string $_type, $_value) : \sorm\internal\value;
	public function to_storage(string $_type, $_value) : \sorm\internal\value;
}
