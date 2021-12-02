<?php
namespace sorm\internal;

class value {

	public function         __construct(
		$_value,
		int $_type //<! one of the sorm\types constants.
	) {

		$this->type=$_type;
		$this->value=$_value;
	}

	public function         get_type() : int {

		return $this->type;
	}

	public function         get_value() {

		return $this->value;
	}

	private int             $type;
	private                 $value;
}
