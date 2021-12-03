<?php
namespace oimpl;

use sorm\interfaces\value_mapper;

class mytransformer implements \sorm\interfaces\value_mapper {

	public function from_storage(
		string $_type,
		$_value
	) {

		switch($_type) {

			case "y_n_bool":
				return $_value==="Y";

		}

		throw new \Exception("invalid transform type from storage '$_type'");
	}

	public function to_storage(
		string $_type,
		$_value
	) {

		switch($_type) {
			case "y_n_bool":
				return $_value ? "Y" : "N";
		}

		throw new \Exception("invalid transform type to storage '$_type'");
	}

}

class value_mapper_factory implements \sorm\interfaces\value_mapper_factory {

	public function build_value_mapper(string $_key): \sorm\interfaces\value_mapper {

		switch($_key) {

			case "mytransformer":
				if(null===$this->transformer) {

					$this->transformer=new mytransformer();
				}

				return $this->transformer;
			break;
		}

		throw new \Exception("invalid transform key '$_key'");
	}

	private ?mytransformer $transformer=null;
}
