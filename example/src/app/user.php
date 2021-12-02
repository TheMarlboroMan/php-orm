<?php
namespace app;

class user implements \sorm\interfaces\entity {


	public function set_id(int $_value) : \app\user {

		$this->id=$_value;
		return $this;
	}

	public function set_username(string $_value) : \app\user {

		$this->username=$_value;
		return $this;
	}

	public function set_password(string $_value) : \app\user {

		$this->password=$_value;
		return $this;
	}

	public function set_login_count(int $_value) : \app\user {

		$this->login_count=$_value;
		return $this;
	}

	public function set_created_at(?\DateTime $_value) : \app\user {

		$this->created_at=$_value;
		return $this;
	}

	public function set_last_login_at(?\DateTime $_value) : \app\user {

		$this->last_login_at=$_value;
		return $this;
	}

	private int             $id;
	private string          $username;
	private string          $password;
	private int             $login_count;
	private ?\DateTime      $created_at;
	private ?\DateTime      $last_login_at;
}
