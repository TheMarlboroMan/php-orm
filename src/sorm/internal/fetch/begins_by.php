<?php
namespace sorm\internal\fetch;

class begins_by implements \sorm\interfaces\fetch_node {

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

	public function accept(
		\sorm\interfaces\fetch_translator $_translator
	) : void {

		$_translator->do_begins_by($this);
	}

	private int             $flags;
	private string          $property;
	private                 $value;
}
