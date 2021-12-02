<?php
namespace sorm\interfaces;

/**
*TODO:
*/
interface entity_property_mapper {

/**
*TODO:
*/
	public function getter_from_property(\sorm\internal\entity_definition_property $_prop) : string;

/**
*TODO:
*/
	public function setter_from_property(\sorm\internal\entity_definition_property $_prop) : string;
}
