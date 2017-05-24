<?php

namespace Drupal\practice\Access;

use Drupal\Core\Session\AccountProxy;
use Drupal\node\Entity\Node;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Access\AccessResult;

class AuthorAccessCheck implements AccessInterface {
	protected $current_user;
	public function __construct(AccountProxy $current_user) {
		$this->current_user;
	}
	public function access(Node $node1, Node $node2) {
		if ($node->getOwnerId () == $this->current_user->Id ()) {
			return AccessResult::allowed ();
		}
		{
			return AccessResult::forbidden ();
		}
	}
}