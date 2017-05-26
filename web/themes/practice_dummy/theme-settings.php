<?php
use Drupal\Core\Form\FormStateInterface;
function practice_dummy_form_FORM_ID_alter(&$form, FormStateInterface $formState) {
	$form ['sub_slogan'] = [
			'#type' => 'textfield',
			'#title' => 'Sub slogan'

	];
}