<?php
namespace sorm\internal;

use ArrayAccess;

/**
*TODO:
*/
class payload implements \Countable, \IteratorAggregate {

	public function             __construct(
		\sorm\internal\entity_definition $_definition
	) {

		$this->entity_definition=$_definition;
	}

	public function             get_entity_definition() : \sorm\internal\entity_definition {

		return $this->entity_definition;
	}

	public function             add(
		string $_key,
		\sorm\internal\value $_value
	) {

		if(array_key_exists($_key, $this->data_map)) {

			throw new \sorm\exception\internal("duplicate key '$_key' in payload");
		}

		$this->data_map[$_key]=$_value;
	}

	//begin countable implementation

	public function                 count() : int {

		return count($this->data_map);
	}
//end countable implementation
//begin iteratoraggregate implementation

	public function                 getIterator() : \ArrayIterator {

		return new \ArrayIterator($this->data_map);
	}

//end iteratoraggregate implementation

	private \sorm\internal\entity_definition    $entity_definition;
	private array                               $data_map=[];
}
