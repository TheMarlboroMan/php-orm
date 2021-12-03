<?php
namespace sorm\internal;

class order_by implements \IteratorAggregate{

	public function __construct(
		array $_order_nodes
	) {

		$this->order_nodes=$_order_nodes;
	}

	public function has_order() : bool {

		return count($this->order_nodes);
	}

//begin iteratoraggregate implementation

	public function                 getIterator() : \ArrayIterator {

		return new \ArrayIterator($this->order_nodes);
	}

//end iteratoraggregate implementation


	private array $order_nodes=[];
}
