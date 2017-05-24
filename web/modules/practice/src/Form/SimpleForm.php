<?php

namespace Drupal\practice\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\CreatedItem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\practice\dbWrapper;

class SimpleForm extends FormBase {
	protected $dbWrapper;
	public function __construct(dbWrapper $DbWrapper) {
		$this->dbWrapper = $DbWrapper;
	}
	public function getFormId() {
		return 'new_form';
	}
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form ['fname'] = [
				'#type' => 'textfield',
				'#title' => 'Enter your First name'
		];
		$form ['lname'] = [
				'#type' => 'textfield',
				'#title' => 'Enter your last name'
		];
		$form ['submit'] = [
				'#type' => 'submit',
				'#value' => 'Submit'
		];
		return $form;
	}
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$fname = $form_state->getValue ( 'fname' );
		$lname = $form_state->getValue ( 'lname' );
		$this->dbWrapper->write ( $fname, $lname );
	}
	public static function create(ContainerInterface $container) {
		return new static ( $container->get ( 'practice.dbwrapper' ) );
	}
}


