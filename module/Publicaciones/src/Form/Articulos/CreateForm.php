<?php

declare(strict_types=1);

namespace Publicaciones\Form\Articulos;

use Laminas\Form\Form;
use Laminas\Form\Element;

class CreateForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('new_articulo');
		$this->setAttribute('method', 'post');

		# username input field
		$this->add([
			'type' => Element\Textarea::class,
			'name' => 'articulo',
			'options' => [
				'label' => 'Contenido del artículo'
			],
			'attributes' => [
				'required' => true, 
				'data-toggle' => 'tooltip',
				'class' => 'form-control',  
				'placeholder' => 'Ingrese contenido'
			]
		]);

		$file = new Element\File('image-file');
        $file->setLabel('Foto del artículo')
             ->setAttribute('id', 'image-file');
        $this->add($file);

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
			'name' => 'create_articulo',
			'attributes' => [
				'value' => 'Publicar Artículo',
				'class' => 'btn btn-primary'
			]
		]);
	}
}
