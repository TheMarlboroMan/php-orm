<?php
namespace sorm;

/**
*TODO:
*/

class entity_manager {

	public function __construct(
		string $_map_file_path,
		\log\logger_interface $_logger,
		bool $_with_extra_checks,
		\sorm\interfaces\storage_interface $_storage_interface,
		\sorm\interfaces\entity_factory $_entity_factory,
		\sorm\interfaces\entity_property_mapper $_entity_property_mapper,
		?\sorm\interfaces\on_default_builder $_on_default_builder,
		?\sorm\interfaces\entity_name_mapper $_entity_name_mapper
	) {

		$this->logger=$_logger;
		$this->storage_interface=$_storage_interface;
		$this->entity_factory=$_entity_factory;
		$this->with_extra_checks=$_with_extra_checks;
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

			throw new \sorm\exception\malformed_setup("entity for '$_class' is not defined");
		}

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

/**
*attempts to persist an entity to storage
*/
	public function create(
		\sorm\interfaces\entity $_entity
	) : \sorm\entity_manager {

		$classname=get_class($_entity);
		if(!array_key_exists($classname, $this->definition_map)) {

			throw new \sorm\exception\malformed_setup("entity for '$classname' is not defined");
		}

		//TODO: check if persisted, how? I guess we have a persistor checker?
			/**
		*sure, and what does it do? what does the entity interface promise, if anything?
		*we can pass the entity, the definition and the em itself, if need be.
		*/

		$definition=$this->definition_map[$classname];

		//prepare the payload.
		$payload=new \sorm\internal\payload($definition);
		foreach($definition as $property) {

			$getter=$this->entity_property_mapper->getter_from_property($property);

			if($this->with_extra_checks && !method_exists($_entity, $getter)) {

				throw new \sorm\exception\malformed_setup("entity ".get_class($_entity)." does not implement getter ".$getter);
			}

			//this actually allows you to specify a primary key
			$payload->add(
				$property->get_property(),
				new \sorm\internal\value($_entity->$getter(), $property->get_type())
			);
		}

		try {

			//Send the payload, will return a primary key value...
			$pk_value=$this->storage_interface->create($payload);

			//Set the primary key value.
			$setter=$this->entity_property_mapper->setter_from_property($definition->get_primary_key_name());
			if($this->with_extra_checks && !method_exists($_entity, $setter)) {

				throw new \sorm\exception\malformed_setup("entity ".get_class($_entity)." does not implement setter ".$setter);
			}
			$_entity->$setter($pk_value->get_value());

			return $this;
		}
		catch(\Exception $e) {

			throw new \sorm\exception\create_error("could not create entity: ".$e->getMessage());
		}
		catch(\Error $e) {

			throw new \sorm\exception\create_error("could not create entity: ".$e->getMessage());
		}
	}

	public function update(
		\sorm\interfaces\entity $_entity
	) : \sorm\entity_manager {

		$classname=get_class($_entity);
		if(!array_key_exists($classname, $this->definition_map)) {

			throw new \sorm\exception\malformed_setup("entity for '$classname' is not defined");
		}

		//TODO: check if persisted, how? I guess we have a persistor checker?
		/**
		*sure, and what does it do? what does the entity interface promise, if anything?
		*we can pass the entity, the definition and the em itself, if need be.
		*/

		$definition=$this->definition_map[$classname];
		$pk_name=$definition->get_primary_key_name();

		//prepare the payload.
		$payload=new \sorm\internal\payload($definition);
		foreach($definition as $property) {

			//disallow updating of the primary key for the puerile reason that
			//it would make the payload confusing with "old id" and "new id".
			if($pk_name===$property->get_name()) {

				continue;
			}

			$getter=$this->entity_property_mapper->getter_from_property($property);
			if($this->with_extra_checks && !method_exists($_entity, $getter)) {

				throw new \sorm\exception\malformed_setup("entity ".get_class($_entity)." does not implement getter ".$getter);
			}

			$payload->add(
				$property->get_property(),
				new \sorm\internal\value($_entity->$getter(), $property->get_type())
			);
		}

		try {

			$this->storage_interface->update($payload);
			return $this;
		}
		catch(\Exception $e) {

			throw new \sorm\exception\update_error("could not update entity: ".$e->getMessage());
		}
		catch(\Error $e) {

			throw new \sorm\exception\update_error("could not update entity: ".$e->getMessage());
		}
	}

	public function delete(
		\sorm\interfaces\entity $_entity
	) : \sorm\entity_manager {

		$classname=get_class($_entity);
		if(!array_key_exists($classname, $this->definition_map)) {

			throw new \sorm\exception\malformed_setup("entity for '$classname' is not defined");
		}

		//TODO: check if persisted, how? I guess we have a persistor checker?
		/**
		*sure, and what does it do? what does the entity interface promise, if anything?
		*we can pass the entity, the definition and the em itself, if need be.
		*/

		$definition=$this->definition_map[$classname];
		$pk_name=$definition->get_primary_key_name();

		//prepare the payload.
		$payload=new \sorm\internal\payload($definition);
		foreach($definition as $property) {

			//disallow updating of the primary key for the puerile reason that
			//it would make the payload confusing with "old id" and "new id".
			if($pk_name!==$property->get_name()) {

				continue;
			}

			$getter=$this->entity_property_mapper->getter_from_property($property);
			if($this->with_extra_checks && !method_exists($_entity, $getter)) {

				throw new \sorm\exception\malformed_setup("entity ".get_class($_entity)." does not implement getter ".$getter);
			}

			$payload->add(
				$property->get_property(),
				new \sorm\internal\value($_entity->$getter(), $property->get_type())
			);
		}

		try {

			$this->storage_interface->delete($payload);
			return $this;
		}
		catch(\Exception $e) {

			throw new \sorm\exception\delete_error("could not update entity: ".$e->getMessage());
		}
		catch(\Error $e) {

			throw new \sorm\exception\delete_error("could not update entity: ".$e->getMessage());
		}
	}

	private function set_entity_default_values(
		\sorm\interfaces\entity $_entity,
		string $_class
	) {

		foreach($this->definition_map[$_class] as $property) {

			$setter=$this->entity_property_mapper->setter_from_property($property);

			if($this->with_extra_checks && !method_exists($_entity, $setter)) {

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
	private \sorm\interfaces\storage_interface      $storage_interface;
	private \sorm\interfaces\entity_factory         $entity_factory;
	private bool                                    $with_extra_checks;
	private \sorm\interfaces\entity_property_mapper $entity_property_mapper;
	private ?\sorm\interfaces\on_default_builder    $on_default_builder;
	private ?\sorm\interfaces\entity_name_mapper    $entity_name_mapper;
	private array                                   $definition_map=[]; //!<Map of fully qualified classname to entity_definition.
}
