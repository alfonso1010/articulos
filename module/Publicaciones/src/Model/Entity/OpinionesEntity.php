<?php

declare(strict_types=1);

namespace Publicaciones\Model\Entity;

class OpinionesEntity
{
	protected $id;
	protected $articulo_id;
	protected $user_id;
	protected $me_gusta;
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

	public function getArticuloId(){
		return $this->articulo_id;
	}

	public function setArticuloId($articulo_id){
		$this->articulo_id = $articulo_id;
	}

	public function getMeGusta(){
		return $this->me_gusta;
	}

	public function setMeGusta($me_gusta){
		$this->me_gusta = $me_gusta;
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