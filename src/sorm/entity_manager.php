<?php
namespace sorm;

/**
*TODO:
*/

class entity_manager {

	public function __construct(
		string $_map_file_path,
		\log\logger_interface $_logger,
		\sorm\interfaces\entity_factory $_entity_factory,
		\sorm\interfaces\entity_property_mapper $_entity_property_mapper,
		?\sorm\interfaces\on_default_builder $_on_default_builder,
		?\sorm\interfaces\entity_name_mapper $_entity_name_mapper
	) {

		$this->logger=$_logger;
		$this->entity_factory=$_entity_factory;
		$this->entity_property_mapper=$_entity_property_mapper;
		$this->on_default_builder=$_on_default_builder;
		$this->entity_name_mapper=$_entity_name_mapper;

		$this->load_map($_map_file_path);
	}

/**
*creates a default constructed entity with all values set as default by the
*map file.
*/
	public function build(
		string $_class
	) : \sorm\interfaces\entity {

		if(!array_key_exists($_class, $this->definition_map)) {

			//TODO: throw something horrible.
			die("NO NO NO NO NO NO");
		}

		//TODO: is this stored by classname or by something else?
		$definition=$this->definition_map[$_class];
		$entity=$this->entity_factory->build_entity($definition->get_classname());

		$this->set_entity_default_values(
			$entity,
			$_class
		);

		if(null!==$this->on_default_builder) {

			$this->on_default_builder->on_default_build($entity);
		}

		return $entity;
	}

	private function set_entity_default_values(
		\sorm\interfaces\entity $_entity,
		string $_class
	) {

		foreach($this->definition_map[$_class] as $property) {

			$setter=$this->entity_property_mapper->setter_from_property($property);

			if(!method_exists($_entity, $setter)) {

				throw new \sorm\exception\malformed_setup("entity ".get_class($_entity)." does not implement setter ".$setter);
			}

			$_entity->$setter($property->get_default());
		}
	}

	private function load_map(
		string $_filename
	) {

		$loader=new \sorm\internal\map_loader($this->logger, $this->entity_name_mapper);
		$loader->load($_filename, $this->definition_map);
	}

	private \log\logger_interface                   $logger;
	private \sorm\interfaces\entity_factory         $entity_factory;
	private \sorm\interfaces\entity_property_mapper $entity_property_mapper;
	private ?\sorm\interfaces\on_default_builder    $on_default_builder;
	private ?\sorm\interfaces\entity_name_mapper    $entity_name_mapper;
	private array                                   $definition_map=[]; //!<Map of fully qualified classname to entity_definition.
}
