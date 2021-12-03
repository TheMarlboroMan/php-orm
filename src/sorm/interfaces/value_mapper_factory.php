<?php
namespace sorm\interfaces;

interface value_mapper_factory {

	public function build_value_mapper(string $_key) : \sorm\interfaces\value_mapper;
}
