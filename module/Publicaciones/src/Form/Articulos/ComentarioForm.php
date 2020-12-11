<?php

declare(strict_types=1);

namespace Publicaciones\Form\Articulos;

use Laminas\Form\Form;
use Laminas\Form\Element;

class ComentarioForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('new_comentario');
		$this->setAttribute('method', 'post');

		# username input field
		$this->add([
			'type' => Element\Textarea::class,
			'name' => 'comentario',
			'options' => [
				'label' => 'Comentario'
			],
			'attributes' => [
				'required' => true, 
				'data-toggle' => 'tooltip',
				'class' => 'form-control',  
				'placeholder' => 'Ingrese comentario'
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
			'name' => 'create_comentario',
			'attributes' => [
				'value' => 'Publicar Comentario',
				'class' => 'btn btn-primary'
			]
		]);
	}
}
