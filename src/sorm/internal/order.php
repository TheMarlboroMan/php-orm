<?php
namespace sorm\internal;

class order {

	public function __construct(
		string $_fieldname,
		int $_order
	) {

		$this->fieldname=$_fieldname;
		$this->order=$_order;
	}

	public function         get_fieldname() :string {

		return $this->fieldname;
	}

	public function         get_order() :int {

		return $this->order;
	}

	private string          $fieldname;
	private int             $order;

}
