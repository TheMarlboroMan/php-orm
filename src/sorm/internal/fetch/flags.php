<?php
namespace sorm\internal\fetch;

abstract class flags {

	const none=0;
	const case_numeric=1;
	const case_sensitive=2;
	const case_insensitive=4;
	const negative=8;
	const equal=16;
	const greater_than=32;
	const lesser_than=64;
}
