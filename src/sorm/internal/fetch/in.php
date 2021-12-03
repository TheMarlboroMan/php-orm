<?php
namespace sorm\internal\fetch;

class in implements \sorm\interfaces\fetch_node {

	public function     __construct(
		int $_flags,
		string $_property,
		array $_values
	) {

		$this->flags=$_flags;
		$this->property=$_property;
		$this->values=$_values;
	}

	public function     get_flags() : int {

		return $this->flags;
	}

	public function     get_property() : string {

		return $this->property;
	}

	public function     get_values() : array {

		return $this->values;
	}

	public function accept(
		\sorm\interfaces\fetch_translator $_translator
	) : void {

		$_translator->do_in($this);
	}

	private int             $flags;
	private string          $property;
	private array           $values;
}
