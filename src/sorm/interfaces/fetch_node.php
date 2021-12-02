<?php
namespace sorm\interfaces;

interface fetch_node {

	public function accept(\sorm\interfaces\fetch_translator $_translator) : void;
}
