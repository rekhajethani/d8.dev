<?php

namespace Drupal\practice\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\State;
use Symfony\Component\DependencyInjection\ContainerInterface;

class qualification extends FormBase {
	public function __construct(State $state) {
		$this->state = $state;
	}
	public function getFormId() {
		return 'qualification';
	}
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['qualification'] = [
				'#type' => 'select',
				'#title' => $this->t ( 'Enter your First name' ),
				'#options' => [
						'ug' => $this->t ( 'ug' ),
						'pg' => $this->t ( 'pg' ),
						'other' => $this->t ( 'other' )
				],
				"#default_value" => $this->state->get ( 'qualification' )
		];
		$form ['other_qualification'] = [
				'#type' => 'textfield',
				'#title' => $this->t ( 'Other qualification' ),
				'#size' => 64,
				'#states' => [
						'visible' => [
								':input[name="qualification"]' => [
										'value' => 'other'
								]

						]
				]
		];
		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => $this->t ( 'Submit' )
		];
		return $form;
	}
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->state->set ( 'qualification', $form_state->getValue ( 'qualification' ) );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'state' ) );
	}
}