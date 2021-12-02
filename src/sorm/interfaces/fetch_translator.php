<?php
namespace sorm\interfaces;

interface fetch_translator {

	public function do_and(\sorm\fetch\and_clause $_node) : void;
	public function do_begins_by(\sorm\fetch\begins_by $_node) : void;
	public function do_comparison(\sorm\fetch\comparison $_node) : void;
	public function do_contains(\sorm\fetch\contains $_node) : void;
	public function do_ends_by(\sorm\fetch\ends_by $_node) : void;
	public function do_in(\sorm\fetch\in $_node) : void;
	public function do_or(\sorm\fetch\or_clause $_node) : void;
	public function do_custom($_other) : void;
}
