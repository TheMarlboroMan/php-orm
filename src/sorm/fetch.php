<?php
namespace sorm;

use \sorm\fetch\flags as flags;

class fetch {

	public const    asc=0;
	public const    desc=1;

	public function order_by(
		...$_orders
	) : \sorm\internal\order_by {

		return new \sorm\internal\order_by($_orders);
	}

	public function order(
		string $_fieldname,
		int $_order=1 //desc
	) : \sorm\internal\order {

		return new \sorm\internal\order($_fieldname, $_order);
	}

	public const limit_none=-1;
	public function limit_offset(
		int $_limit=-1,
		int $_offset=0
	) : \sorm\internal\limit_offset {

		return new \sorm\internal\limit_offset($_limit, $_offset);
	}

	public function and(
		...$_nodes
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\and_clause(flags::none, $_nodes);
	}

	public function and_not(
		...$_nodes
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\and_clause(flags::negative, $_nodes);
	}

	public function or(
		...$_nodes
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\or_clause(flags::none, $_nodes);
	}

	public function or_not(
		...$_nodes
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\or_clause(flags::negative, $_nodes);
	}

	public function equals(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::case_native | flags::equal, $_property, $_value);
	}

	public function not_equals(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::case_native | flags::equal, $_property, $_value);
	}

	public function equals_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::case_insensitive | flags::equal, $_property, $_value);
	}

	public function not_equals_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::case_insensitive | flags::equal | flags::negative, $_property, $_value);
	}

	public function is_true(
		string $_property
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\is_true(flags::none, $_property);
	}

	public function is_false(
		string $_property
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\is_true(flags::negative, $_property);
	}

	public function begins_by(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\begins_by(flags::case_native, $_property, $_value);
	}

	public function not_begins_by(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node{

		return new \sorm\fetch\begins_by(flags::case_native | flags::negative, $_property, $_value);
	}

	public function ends_by(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_native, $_property, $_value);
	}

	public function not_ends_by(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_native | flags::negative, $_property, $_value);
	}

	public function contains(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_native, $_property, $_value);
	}

	public function not_contains(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_native | flags::negative, $_property, $_value);
	}

	public function begins_by_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\begins_by(flags::case_insensitive, $_property, $_value);
	}

	public function not_begins_by_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\begins_by(flags::case_insensitive | flags::negative, $_property, $_value);
	}

	public function ends_by_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_insensitive, $_property, $_value);
	}

	public function not_ends_by_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_insensitive | flags::negative, $_property, $_value);
	}

	public function contains_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_insensitive, $_property, $_value);
	}

	public function not_contains_ci(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_insensitive | flags::negative, $_property, $_value);
	}

		public function begins_by_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\begins_by(flags::case_sensitive, $_property, $_value);
	}

	public function not_begins_by_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\begins_by(flags::case_sensitive | flags::negative, $_property, $_value);
	}

	public function ends_by_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_sensitive, $_property, $_value);
	}

	public function not_ends_by_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\ends_by(flags::case_sensitive | flags::negative, $_property, $_value);
	}

	public function contains_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_sensitive, $_property, $_value);
	}

	public function not_contains_cs(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\contains(flags::case_sensitive | flags::negative, $_property, $_value);
	}

	public function larger_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::larger_than, $_property, $_value);
	}

	public function not_larger_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::larger_than | flags::negative, $_property, $_value);
	}

	public function larger_or_equal_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::larger_than | flags::equal, $_property, $_value);
	}

	public function not_larger_or_equal_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::larger_than | flags::equal | flags::negative, $_property, $_value);
	}

	public function lesser_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::lesser_than, $_property, $_value);
	}

	public function not_lesser_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::lesser_than | flags::negative, $_property, $_value);
	}

	public function lesser_or_equal_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::lesser_than | flags::equal, $_property, $_value);
	}

	public function not_lesser_or_equal_than(
		string $_property,
		$_value
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\comparison(flags::lesser_than | flags::equal | flags::negative, $_property, $_value);
	}

	public function in(
		string $_property,
		...$_values
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\in(flags::none, $_property, $_values);
	}

	public function not_in(
		string $_property,
		...$_values
	) : \sorm\interfaces\fetch_node {

		return new \sorm\fetch\in(flags::negative, $_property, $_values);
	}
}
