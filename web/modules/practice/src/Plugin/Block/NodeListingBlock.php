<?php

namespace Drupal\practice\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'NodeListingBlock' block.
 *
 * @Block(
 * id = "node_listing_block",
 * admin_label = @Translation("Node listing block"),
 * )
 */
class NodeListingBlock extends BlockBase implements ContainerFactoryPluginInterface {

	/**
	 * Drupal\Core\Database\Driver\mysql\Connection definition.
	 *
	 * @var \Drupal\Core\Database\Driver\mysql\Connection
	 */
	protected $database;
	/**
	 * Construct.
	 *
	 * @param array $configuration
	 *        	A configuration array containing information about the plugin instance.
	 * @param string $plugin_id
	 *        	The plugin_id for the plugin instance.
	 * @param string $plugin_definition
	 *        	The plugin implementation definition.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, AccountProxy $current_user) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->database = $database;
		$this->current_user = $current_user;
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'database' ), $container->get ( 'current_user' ) );
	}
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function build() {
		$response = $this->database->select ( 'node_field_data', 'nfd' )->fields ( 'nfd', [
				'title',
				'nid'
		] )->range ( 0, 3 )->orderby ( 'created', 'Desc' )->execute ();
		$markup = '';
		while ( $row = $response->fetchAssoc () ) {
			$markup .= '|' . $row ['title'];
			$nodetag [] = 'node' . $row ['nid'];
		}
		$build ['node_listing_block'] ['#markup'] = $markup . '------' . $this->current_user->getEmail ();
		$build ['node_listing_block'] ['#cache'] = [
				'tags' => $nodetag
		];
		$build ['node_listing_block'] ['#cache'] ['contexts'] = [
				'user'
		];

		return $build;
	}
}
