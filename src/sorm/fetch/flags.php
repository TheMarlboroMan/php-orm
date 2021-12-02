<?php
namespace sorm\fetch;

abstract class flags {

	const none=0;
	const case_native=1;
	const case_sensitive=2;
	const case_insensitive=4;
	const negative=8;
	const equal=16;
	const larger_than=32;
	const lesser_than=64;
}
