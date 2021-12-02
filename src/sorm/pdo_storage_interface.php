<?php
namespace sorm;

/**
*PDO storage implementation.
*/
class pdo_storage_interface implements \sorm\interfaces\storage_interface {

/**
*class constructor. Sets the PDO mode to throw exceptions, no excuses.
*/
	public function __construct(
		\PDO $_pdo
	) {

		$this->pdo=$_pdo;
		$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	public function get_fetch_translator() : \sorm\interfaces\fetch_translator {

		if(null===$this->fetch_translator) {

			$this->fetch_translator=new \sorm\internal\pdo_fetch_translator();
		}

		return $this->fetch_translator;
	}

	public function create(
		\sorm\internal\payload $_payload
	) : \sorm\internal\value {

		$stmt=$this->get_create_statement($_payload);
		foreach($_payload as $key => $value) {

			$stmt->bindValue(":".$key, $this->to_pdo_value($value), $this->to_pdo_type($value));
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
		$stmt->bindValue(":pk", $this->to_pdo_value($pk), $this->to_pdo_type($pk));
		foreach($_payload as $key => $value) {

			$stmt->bindValue(":".$key, $this->to_pdo_value($value), $this->to_pdo_type($value));
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

		$pk=$_payload->get_primary_key();
		$stmt->bindValue(":pk", $this->to_pdo_value($pk), $this->to_pdo_type($pk));

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


			$fields=[];
			$values=[];

			foreach($_payload as $key => $value) {

				$fields[]="`$key`";
				$values[]=":$key";
			}

			$query_string="INSERT INTO `".$definition->get_storage_key()."` (".implode(", ", $fields).") VALUES (".implode(", ", $values).");";
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

			$assignments=[];
			foreach($_payload as $key => $value) {

				$assignments[]="`$key`= :$key";
			}

			$query_string="UPDATE `".$definition->get_storage_key()."` SET ".implode(", ", $assignments)." WHERE `".$definition->get_primary_key_name()."` = :pk";
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

	private function            to_pdo_value(
		\sorm\internal\value $_value
	) {

		if(null===$_value->get_value()) {

			return null;
		}

		switch($_value->get_type()) {

			case \sorm\types::t_any:
			case \sorm\types::t_string:
			case \sorm\types::t_double: //this never ceases to amuse me.
			case \sorm\types::t_int:
				return $_value->get_value();
			case \sorm\types::t_datetime:
				return $_value->get_value()->format("Y-m-d H:i:s");
			case \sorm\types::t_bool:
				return $_value->get_value() ? 1 : 0;
		}
	}

	private \PDO                $pdo;
	private array               $create_statements_map=[];
	private array               $update_statements_map=[];
	private array               $delete_statements_map=[];
	private ?\sorm\interfaces\fetch_translator $fetch_translator=null;
}