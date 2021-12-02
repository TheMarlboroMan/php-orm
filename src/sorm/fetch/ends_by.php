<?php
namespace sorm\fetch;

class ends_by implements \sorm\interfaces\fetch_node {

	public function     __construct(
		int $_flags,
		string $_property,
		$_value
	) {

		$this->flags=$_flags;
		$this->property=$_property;
		$this->value=$_value;
	}

	public function     get_flags() : int {

		return $this->flags;
	}

	public function     get_property() : string {

		return $this->property;
	}

	public function     get_value() {

		return $this->value;
	}

	private int             $flags;
	private string          $property;
	private                 $value;
}
