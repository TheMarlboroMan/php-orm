<?php
namespace sorm\internal;

/**
*defines an optional limit and offset for a fetch operation (that is, the
*amount of entities to be retrieved and from which result to start).
*/

class limit_offset {

	public const no_limit=-1;

	public function __construct(
		int $_limit,
		int $_offset
	) {

		$this->limit=$_limit;
		$this->offset=$_offset;
	}

/**
*returns the limit. -1 means "no limit, grab everything".
*/

	public function get_limit() : int {

		return $this->limit;
	}

/**
*returns the offset.
*/

	public function get_offset() : int {

		return $this->offset;
	}

	private int     $limit;
	private int     $offset;
}
