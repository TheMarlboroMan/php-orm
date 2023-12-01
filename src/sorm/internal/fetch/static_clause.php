<?php
declare(strict_types=1);
namespace sorm\internal\fetch;

/**
*expresses a static true clause, equivalent to any clause that proves itself
true (or false, if the flags are negative).
*/
class static_clause implements \sorm\interfaces\fetch_node {

	use \sorm\traits\strict;

	public function     __construct(
		int $_flags=0
	) {

		$this->flags=$_flags;
	}

/**
*returns the clause flags.
*/
	public function     get_flags() : int {

		return $this->flags;
	}
/**
*implementation of fetch_node.
*/
	public function accept(
		\sorm\interfaces\fetch_translator $_translator
	) : void {

		$_translator->do_static_clause($this);
	}

	private int             $flags;
}
