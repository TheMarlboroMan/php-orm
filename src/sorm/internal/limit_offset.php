<?php
namespace sorm\internal;

class limit_offset {

	public const no_limit=-1;

	public function __construct(
		int $_limit,
		int $_offset
	) {

		$this->limit=$_limit;
		$this->offset=$_offset;
	}

	public function get_limit() : int {

		return $this->limit;
	}

	public function get_offset() : int {

		return $this->offset;
	}

	private int     $limit;
	private int     $offset;
}
