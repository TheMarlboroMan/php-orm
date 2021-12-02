<?php
namespace oimpl;

class entity_factory implements \sorm\interfaces\entity_factory {

	public function build_entity(
		string $_classname
	): \sorm\interfaces\entity {

		return new $_classname;
	}

};
