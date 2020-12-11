<?php

declare(strict_types=1);

namespace Publicaciones\Model\Entity;

class ArticulosEntity
{
	protected $id;
	protected $user_id;
	protected $articulo;
	protected $foto;
	protected $fecha_alta;

	protected $email;

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUserId(){
		return $this->user_id;
	}

	public function setUserId($user_id){
		$this->user_id = $user_id;
	}

	public function getArticulo(){
		return $this->articulo;
	}

	public function setArticulo($articulo){
		$this->articulo = $articulo;
	}

	public function getFoto(){
		return $this->foto;
	}

	public function setFoto($foto){
		$this->foto = $foto;
	}

	public function getFechaAlta(){
		return $this->fecha_alta;
	}

	public function setFechaAlta($fecha_alta){
		$this->fecha_alta = $fecha_alta;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

}