<?php

namespace Drupal\practice\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class WeatherConfigForm extends ConfigFormBase {
	public function getFormId() {
		return 'weather_config_form';
	}
	protected function getEditableConfigNames() {
		return [
				'practice.weather_config'
		];
	}
	public function buildForm(array $form, FormStateInterface $form_state) {
		$app_id = $this->config ( 'practice.weather_config' )->get ( 'appid' );

		$form ['app_id'] = [
				'#type' => 'textfield',
				'#title' => 'Weather App Id',
				'#default_value' => $app_id
		];
		return parent::buildform ( $form, $form_state );
	}
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config ( 'practice.weather_config' )->set ( 'appid', $form_state->getValue ( 'app_id' ) )->save ();
		parent::submitform ( $form, $form_state );
	}
}
