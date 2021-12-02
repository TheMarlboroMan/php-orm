<?php
namespace sorm;

/**
*PDO storage
*/
class pdo_storage_interface implements \sorm\interfaces\storage_interface {

	public function __construct(
		\PDO $_pdo
	) {

		$this->pdo=$_pdo;
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	public function create(
		\sorm\internal\payload $_payload
	) : \sorm\internal\value {

/**
*must create the entity defined in the payload and return its primary key,
*of any type. Must throw if the entity cannot be persisted (for example, was
*already persisted before).
*/

		$stmt=$this->get_create_statement($_payload);
		foreach($_payload as $key => $value) {

			$stmt->bindParam(":".$key, $value->get_value(), $this->to_pdo_type($value));
		}

		if(!$stmt->execute()) {

			throw new \sorm\exception\exception("could not create entity");
		}

		if(!$stmt->rowCount()) {

			throw new \sorm\exception\exception("entity could not be inserted");
		}

		return new \sorm\internal\value(
			$this->pdo->lastInsertId(),
			\sorm\types::t_any //yep, as any. Actually PDO seems to return a string, according to the docs.
		);
	}

	public function update(
		\sorm\internal\payload $_payload
	) : void {

		$stmt=$this->get_update_statement($_payload);

		$definition=$_payload->get_entity_definition();
		$pk=$_payload[$definition->get_primary_key_name()];
		$stmt->bindParam(":pk", $pk->get_value(), $this->to_pdo_type($pk));
		foreach($_payload as $key => $value) {

			$stmt->bindParam(":".$key, $value->get_value(), $this->to_pdo_type($value));
		}

		if(!$stmt->execute()) {

			throw new \sorm\exception\exception("could not update entity");
		}

		if(!$stmt->rowCount()) {

			throw new \sorm\exception\exception("entity could not be found for update");
		}
	}

	public function delete(
		\sorm\internal\payload $_payload
	) : void {

		//The entity manager will catch anything that throws...
		$stmt=$this->get_delete_statement($_payload);

		$definition=$_payload->get_entity_definition();
		$pk=$_payload[$definition->get_primary_key_name()];
		$stmt->bindParam(":pk", $pk->get_value(), $this->to_pdo_type($pk));

		if(!$stmt->execute()) {

			throw new \sorm\exception\exception("could not delete entity");
		}

		if(!$stmt->rowCount()) {

			throw new \sorm\exception\exception("entity could not be found for deletion");
		}
	}

	private function            get_create_statement(
		\sorm\internal\payload $_payload
	) : \PDOStatement {

		$definition=$_payload->get_entity_definition();
		$classname=$definition->get_classname();
		if(!array_key_exists($classname, $this->create_statements_map)) {

			//TODO
			$fields="";
			$values="";

			$query_string="INSERT INTO `".$definition->get_storage_key()."` ($fields) VALUES ($values);";
			$this->create_statements_map[$classname]=$this->pdo->prepare($query_string);
		}

		return $this->create_statements_map[$classname];
	}

	private function            get_update_statement(
		\sorm\internal\payload $_payload
	) : \PDOStatement {

		$definition=$_payload->get_entity_definition();
		$classname=$definition->get_classname();
		if(!array_key_exists($classname, $this->update_statements_map)) {

			//TODO:
			$assignments="";

			$query_string="UPDATE `".$definition->get_storage_key()."` SET $assignments WHERE `".$definition->get_primary_key_name()."` = :pk";
			$this->update_statements_map[$classname]=$this->pdo->prepare($query_string);
		}

		return $this->update_statements_map[$classname];
	}

	private function            get_delete_statement(
		\sorm\internal\payload $_payload
	) : \PDOStatement {

		$definition=$_payload->get_entity_definition();
		$classname=$definition->get_classname();
		if(!array_key_exists($classname, $this->delete_statements_map)) {

			$query_string="DELETE FROM `".$definition->get_storage_key()."` WHERE `".$definition->get_primary_key_name()."` = :pk";
			$this->delete_statements_map[$classname]=$this->pdo->prepare($query_string);
		}

		return $this->delete_statements_map[$classname];
	}

	private function            to_pdo_type(
		\sorm\internal\value $_value
	) {

		if(null===$_value->get_value()) {

			return \PDO::PARAM_NULL;
		}

		switch($_value->get_type()) {

			case \sorm\types::t_any:
			case \sorm\types::t_string:
			case \sorm\types::t_double: //this never ceases to amuse me.
			case \sorm\types::t_datetime:
				return \PDO::PARAM_STR;
			case \sorm\types::t_bool:
			case \sorm\types::t_int:
				return \PDO::PARAM_INT;
		}
	}

	private \PDO                $pdo;
	private array               $create_statements_map=[];
	private array               $update_statements_map=[];
	private array               $delete_statements_map=[];
}
