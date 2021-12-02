<?php
namespace oimpl;

use sorm\internal\entity_definition_property;

class entity_property_mapper implements \sorm\interfaces\entity_property_mapper {

	public function getter_from_property(
		entity_definition_property $_prop
	): string {

		switch($_prop->get_type()) {

			case \sorm\internal\entity_definition_property::type_boolean:
				return "is_".$_prop->get_property();
			default:
				return "get_".$_prop->get_property();
		}
	}

	public function setter_from_property(
		entity_definition_property $_prop
	): string {

		return "set_".$_prop->get_property();
	}

}
