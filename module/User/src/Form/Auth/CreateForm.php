<?php

declare(strict_types=1);

namespace User\Form\Auth;

use Laminas\Form\Form;
use Laminas\Form\Element;

class CreateForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('new_account');
		$this->setAttribute('method', 'post');

		# username input field
		$this->add([
			'type' => Element\Text::class,
			'name' => 'username',
			'options' => [
				'label' => 'Usuario'
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 25,
				'pattern' => '^[a-zA-Z0-9]+$',  
				'data-toggle' => 'tooltip',
				'class' => 'form-control',  
				'title' => 'Solo ingrese letras y números',
				'placeholder' => 'Ingrese nombre de usuario'
			]
		]);

		# rol select field
		$this->add([
			'type' => Element\Select::class,
			'name' => 'rol',
			'options' => [
				'label' => 'Seleccione Tipo de usuario',
				'value_options' => [
					'1' => 'Publicador',
					'2' => 'Comentarista',
				],
			],
			'attributes' => [
				'required' => true,
				'class' => 'custom-select', # styling
			]
		]);

		# email address input field
		$this->add([
			'type' => Element\Email::class,
			'name' => 'email',
			'options' => [
				'label' => 'Email'
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 128,
				'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
				'autocomplete' => false,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',
				'title' => 'solo email válido',
				'placeholder' => 'Ingrese Email'
			]
		]);

		# confirm email address
		$this->add([
			'type' => Element\Email::class,
			'name' => 'confirm_email',
			'options' => [
				'label' => 'Verificar Email'
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 128,
				'pattern' => '^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$',
				'autocomplete' => false,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',
				'title' => 'El email debe coincidir con el proporcionado anteriormente',
				'placeholder' => 'Ingrese su email de nuevo'
			]
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
				'autocomplete' => false,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',   # styling
				'title' => 'Password debe tener entre 8 y 25 carácteres',
				'placeholder' => 'Ingrese Password'
			]
		]);

		# confirm password input field
		$this->add([
			'type' => Element\Password::class,
			'name' => 'confirm_password',
			'options' => [
				'label' => 'Verificar Password'
			],
			'attributes' => [
				'required' => true,
				'size' => 40,
				'maxlength' => 25,
				'autocomplete' => false,
				'data-toggle' => 'tooltip',
				'class' => 'form-control',   # styling
				'title' => 'La contraseña debe coincidir con la proporcionada anteriormente',
				'placeholder' => 'Ingrese password de nuevo'
			]
		]);

		# cross-site-request forgery (csrf) field
		$this->add([
			'type' => Element\Csrf::class,
			'name' => 'csrf',
			'options' => [
				'csrf_options' => [
					'timeout' => 600,  # 5 minutes
				]
			]
		]);

		# submit button
		$this->add([
			'type' => Element\Submit::class,
			'name' => 'create_account',
			'attributes' => [
				'value' => 'Registrarse',
				'class' => 'btn btn-primary'
			]
		]);
	}
}
