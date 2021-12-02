<?php
namespace app;

class post implements \sorm\interfaces\entity {

	private int             $id;
	private int             $user_id;
	private string          $text;
	private ?\DateTime      $last_login_at;
}
