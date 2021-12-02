<?php
namespace sorm\interfaces;

/**
*defines a class that has to be treated like a model, so it can be produced
*and manipulated via an entity manager.
*/
interface entity {


/**
*indicates any actions that may take place when a model is default created by
*the entity manager. Receives the implementation dependant "on default builder"
*which might do application specific stuff.
*/

/*
	NO NEED, ACTUALLY, LET THE EM TAKE IT!
	public function on_default_build(
		\sorm\interfaces\on_default_builder $_db
	) : void;
*/
}
