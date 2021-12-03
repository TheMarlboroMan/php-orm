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
		$_default,
		?string $_transform_key,
		?string $_transform_method
	) {

		$this->property=$_property;
		$this->field=$_field;
		$this->type=$_type;
		$this->nullable=$_nullable;
		$this->default=$_default;
		$this->transform_key=$_transform_key;
		$this->transform_method=$_transform_method;
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

	public function get_transform_key() :?string {

		return $this->transform_key;
	}

	public function get_transform_method() :?string {

		return $this->transform_method;
	}

	private string              $property;
	private string              $field;
	private int                 $type;
	private bool                $nullable;
	private                     $default;
	private                     $transform_key;
	private                     $transform_method;
}
