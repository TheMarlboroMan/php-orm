<?php
namespace app;

class user implements \sorm\interfaces\entity {

	public function get_id() :int {

		return $this->id;
	}

	public function get_username() :string {

		return $this->username;
	}

	public function get_password() :string {

		return $this->password;
	}

	public function get_login_count() :int {

		return $this->login_count;
	}

	public function get_created_at() :?\DateTime {

		return $this->created_at;
	}

	public function get_last_login_at() :?\DateTime {

		return $this->last_login_at;
	}

	public function is_disabled() : bool {

		return $this->disabled;
	}

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

	public function set_disabled(bool $_value) : \app\user {

		$this->disabled=$_value;
		return $this;
	}

	private int             $id;
	private string          $username;
	private string          $password;
	private int             $login_count;
	private ?\DateTime      $created_at;
	private ?\DateTime      $last_login_at;
	private bool            $disabled;
}
