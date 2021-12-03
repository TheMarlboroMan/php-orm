<?php
namespace sorm\interfaces;

interface fetch_collection {

	public function         get_count() : int;
	public function         get_unlimited_count() : int;
	public function         next() : ?\sorm\interfaces\entity;
	public function         all() : array;
}
