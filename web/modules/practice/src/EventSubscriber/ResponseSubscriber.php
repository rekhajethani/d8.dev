<?php

namespace Drupal\practice\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseSubscriber implements EventSubscriberInterface {
	public static function getSubscribedEvents() {
		return [
				KernelEvents::RESPONSE => [
						'injectHeaders'
				]
		];
	}
	public function injectHeaders(FilterResponseEvent $event) {
		$response = $event->getResponse ();
		$response->headers->add ( [
				'hello' => 'world'
		] );
	}
}