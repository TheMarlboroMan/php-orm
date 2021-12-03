<?php
namespace sorm\interfaces;

interface fetch_translator {

	public function do_and(\sorm\internal\fetch\and_clause $_node) : void;
	public function do_begins_by(\sorm\internal\fetch\begins_by $_node) : void;
	public function do_comparison(\sorm\internal\fetch\comparison $_node) : void;
	public function do_contains(\sorm\internal\fetch\contains $_node) : void;
	public function do_ends_by(\sorm\internal\fetch\ends_by $_node) : void;
	public function do_in(\sorm\internal\fetch\in $_node) : void;
	public function do_or(\sorm\internal\fetch\or_clause $_node) : void;
	public function do_is_true(\sorm\internal\fetch\is_true $_node) : void;
/*
	public function do_custom(\sorm\interfaces\fetch_node $_other) : void;
TODO: What interface is this?

	public function add_custom_handler($_handler) : \sorm\interfaces\fetch_translator;
*/
}
