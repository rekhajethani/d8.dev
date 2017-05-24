<?php

namespace Drupal\practice\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Access\AccessResult;

class PracticeController implements ContainerInjectionInterface {
	public function __construct(AccountProxy $current_user) {
		$this->current_user = $current_user;
	}
	public function staticContent() {
		return [
				'#markup' => "Hello World"
		];
	}
	public function argContent($arg1) {
		return [
				'#markup' => "Hello World" . $arg1
		];
	}
	public function entityArgDemo(Node $node1, Node $node2) {
		return [
				'#markup' => "Node title1: " . $node1->getTitle () . " Node title2: " . $node2->getTitle ()
		];
	}
	public function accessAuthorCheck(Node $node1, Node $node2) {
		if ($node->getOwnerId () == $this->current_user->Id ()) {
			return AccessResult::allowed ();
		}
		{
			return AccessResult::forbidden ();
		}
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'current_user' ) );
	}
}









