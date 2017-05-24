<?php

namespace Drupal\practice\Controller;

use Drupal\node\Entity\Node;

class PracticeController {
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
}
