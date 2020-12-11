<?php

declare(strict_types=1);

namespace User\Form\Auth;

use Laminas\Form\Element;
use Laminas\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('sign_in');
		$this->setAttribute('method', 'post');

		# email address input field
		$this->add([
			'type' => Element\Email::class,
			'name' => 'email',
			'options' => [
				'label' => 'Email',
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 128,
				'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
				'autocomplete' => false,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',
				'title' => 'Proporcione su dirección de correo electrónico',
				'placeholder' => 'Ingrese Email',
			],
		]);

		# password input field
		$this->add([
			'type' => Element\Password::class,
			'name' => 'password',
			'options' => [
				'label' => 'Password'
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 25,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',
				'title' => 'Proporcione su password',
				'placeholder' => 'Ingrese password',
			]
		]);

		
		# csrf hidden field
		$this->add([
			'type' => Element\Csrf::class,
			'name' => 'csrf',
			'options' => [
				'csrf_options' => [
					'timeout' => 600,   # 10 minutes
				]
			],
		]);

		# submit button
		$this->add([
			'type' => Element\Submit::class,
			'name' => 'account_login',
			'attributes' => [
				'value' => 'Iniciar Sesión',
				'class' => 'btn btn-primary'
			]
		]);
	}
}