<?php
namespace sorm\internal\fetch;

class is_true implements \sorm\interfaces\fetch_node {

	public function     __construct(
		int $_flags,
		string $_property
	) {

		$this->flags=$_flags;
		$this->property=$_property;
	}

	public function     get_flags() : int {

		return $this->flags;
	}

	public function     get_property() : string {

		return $this->property;
	}

	public function accept(
		\sorm\interfaces\fetch_translator $_translator
	) : void {

		$_translator->do_is_true($this);
	}

	private int             $flags;
	private string          $property;
}