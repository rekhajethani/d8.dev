<?php

namespace Drupal\practice\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use GuzzleHttp\Client;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Component\Serialization\Json;

/**
 * @Block(
 * id="weather_block",
 * admin_label="Weather Block"
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface {
	protected $client;
	protected $configFactory;
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Client $client, ConfigFactory $configFactory) {
		parent::__construct ( $configuration, $plugin_id, $plugin_definition );
		$this->client = $client;
		$this->configFactory = $configFactory;
	}
	public function build() {
		$appid = $this->configFactory->get ( 'practice.weather_config' )->get ( 'appid' );
		$city_name = $this->configuration ['city_name'];
		$response = $this->client->request ( 'GET', 'http://api.openweathermap.org/data/2.5/weather', [
				'query' => [
						'q' => $city_name,
						'appid' => $appid
				]
		] );
		$json_response = $response->getBody ()->getContents ();
		$weather_data = Json::decode ( $json_response );

		return [
				'#theme' => 'weather_widget',
				'#weather_data' => $weather_data,
				'#attached' => [
						'library' => [
								'practice/weather_widget'
						]
				]

		];
	}
	public function blockForm($form, FormStateInterface $form_state) {
		$form ['city_name'] = [
				'#type' => 'textfield',
				'#title' => 'Enter your City name',
				'#default_value' => $this->configuration ['city_name']
		];
		return $form;
	}
	public function blockSubmit($form, FormStateInterface $form_state) {
		$this->configuration ['city_name'] = $form_state->getValue ( 'city_name' );
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static ( $configuration, $plugin_id, $plugin_definition, $container->get ( 'http_client' ), $container->get ( 'config.factory' ) );
	}
}