<?php
namespace sorm\internal;

/**
*TODO:
*/
class entity_definition implements \Countable, \IteratorAggregate {

/**
*TODO:
*/
	public function                 has_primary_key() : bool {

		return null !== $this->primary_key_name;
	}

/**
*TODO:
*/
	public function                 get_primary_key_name() : ?string {

		return $this->primary_key_name;
	}

/**
*TODO:
*/
	public function                 get_storage_key() : string {

		return $this->storage_key;
	}

/**
*TODO:
*/
	public function                 add_property(
		\sorm\internal\entity_definition_property $_prop
	) :\sorm\internal\entity_definition {

		$this->properties[]=$_prop;
		return $this;
	}
/**
*TODO:
**/
	public function                 set_primary_key_name(
		string $_val
	) : \sorm\internal\entity_definition {

		$this->primary_key_name=$_val;
		return $this;
	}

/**
*TODO:
*/
	public function                 get_classname() : string {

		return $this->classname;
	}

/**
*TODO:
*/
	public function                 set_classname(
		string $_val
	) : \sorm\internal\entity_definition {

		$this->classname=$_val;
		return $this;
	}

/**
*TODO:
*/
	public function                 set_storage_key(
		string $_val
	) : \sorm\internal\entity_definition {

		$this->storage_key=$_val;
		return $this;
	}

//begin countable implementation

	public function                 count() : int {

		return count($this->properties);
	}
//end countable implementation
//begin iteratoraggregate implementation

	public function                 getIterator() : \ArrayIterator {

		return new \ArrayIterator($this->properties);
	}

//end iteratoraggregate implementation

	private ?string                 $primary_key_name;
	private string                  $classname; //!<Fully qualified classname, no excuses.
	private string                  $storage_key;
	private array                   $properties; //!< Array of entity_definition_property
}
