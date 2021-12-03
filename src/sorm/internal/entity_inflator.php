<?php
namespace sorm\internal;

class entity_inflator {

	public function __construct(
		\sorm\interfaces\entity_factory $_entity_factory,
		\sorm\interfaces\entity_property_mapper $_property_mapper,
		?\sorm\interfaces\on_default_builder $_on_default_builder,
		?\sorm\interfaces\value_mapper_factory $_value_mapper_factory
	) {

		$this->entity_factory=$_entity_factory;
		$this->property_mapper=$_property_mapper;
		$this->on_default_builder=$_on_default_builder;
		$this->value_mapper_factory=$_value_mapper_factory;
	}

	public function build_entity(
		\sorm\internal\entity_definition $_definition
	) :\sorm\interfaces\entity {

		$entity=$this->entity_factory->build_entity($_definition->get_classname());
		$this->set_entity_default_values($entity, $_definition);

		if(null!==$this->on_default_builder) {

			$this->on_default_builder->on_default_build($entity);
		}

		return $entity;
	}

	public function inflate(
		\sorm\interfaces\entity $_entity,
		\sorm\internal\entity_definition $_definition,
		array $_data
	) : \sorm\interfaces\entity {

		foreach($_definition as $property) {

			$setter=$this->property_mapper->setter_from_property($property);
			$fieldname=$property->get_field();

			if(array_key_exists($fieldname, $_data)) {

				$value=$_data[$fieldname];
				if(null!==$this->value_mapper_factory && null!==$property->get_transform_key()) {

					$transform=$this->value_mapper_factory->build_value_mapper($property->get_transform_key());
					$value=$transform->from_storage($property->get_transform_value(), $value);

					if(! (is_scalar($value) || null===$value)) {

						throw new \sorm\exception\value_map("expected scalar value from '".$property->get_transform_key().":".$property->get_transform_value()."'");
					}
				}

				switch($property->get_type()) {

					case \sorm\types::t_any:
						$_entity->$setter($value);
					break;
					case \sorm\types::t_bool:
						$_entity->$setter((bool)$value);
					break;
					case \sorm\types::t_datetime:
						$_entity->$setter(new \DateTime($value));
					break;
					case \sorm\types::t_double:
						$_entity->$setter((double)$value);
					break;
					case \sorm\types::t_int:
						$_entity->$setter((int)$value);
					break;
					case \sorm\types::t_string:
						$_entity->$setter((string)$value);
					break;
				}
			}
		}

		return $_entity;
	}

	private function set_entity_default_values(
		\sorm\interfaces\entity $_entity,
		\sorm\internal\entity_definition $_definition
	) : void {

		foreach($_definition as $property) {

			$setter=$this->property_mapper->setter_from_property($property);

			//Won't even check, sorry.
			$_entity->$setter($property->get_default());
		}
	}

	private \sorm\interfaces\entity_factory         $entity_factory;
	private \sorm\interfaces\entity_property_mapper $property_mapper;
	private ?\sorm\interfaces\on_default_builder    $on_default_builder;
	private ?\sorm\interfaces\value_mapper_factory  $value_mapper_factory;
}
