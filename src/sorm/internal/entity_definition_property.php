<?php
namespace sorm\internal;

/**
*TODO:
*/
class entity_definition_property {



	public function __construct(
		string $_property,
		string $_field,
		int $_type,
		bool $_nullable,
		$_default
	) {

		$this->property=$_property;
		$this->field=$_field;
		$this->type=$_type;
		$this->nullable=$_nullable;
		$this->default=$_default;
	}

	public function get_property() : string {

		return $this->property;
	}

	public function get_field() : string {

		return $this->field;
	}

	public function get_type() : int {

		return $this->type;
	}

	public function is_nullable() : bool {

		return $this->nullable;
	}

	public function get_default() {

		return $this->default;
	}

	private string              $property;
	private string              $field;
	private int                 $type;
	private bool                $nullable;
	private                     $default;
}
