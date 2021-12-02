<?php
namespace sorm\fetch;

class and_clause implements \sorm\interfaces\fetch_node {

	public function     __construct(
		int $_flags,
		array $_clauses
	) {

		$this->flags=$_flags;
		$this->clauses=$_clauses;
	}

	public function     get_flags() : int {

		return $this->flags;
	}

	public function     get_clauses() : array {

		return $this->clauses;
	}

	private int          $flags;
	private array        $clauses=[];
}
