<?php

declare(strict_types=1);

namespace Publicaciones\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Filter;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\I18n;
use Laminas\InputFilter;
use Laminas\Paginator\Adapter\DbSelect;
use Laminas\Paginator\Paginator;
use Laminas\Validator;
use Publicaciones\Model\Entity\ArticulosEntity;


class ArticulosTable extends AbstractTableGateway
{
	protected $adapter;          # adapter to use to connect to the database
	protected $table = 'articulos';  # our table. one we want to store data in

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}

	public function saveArticulo(array $data)
	{
		$timeNow = date('Y-m-d H:i:s');
		$values = [
			'articulo' => $data['articulo'],
			'user_id' => $data['user_id'],
			'foto' => $data['foto'],
			'fecha_alta'  => $timeNow,
		];

		$sqlQuery = $this->sql->insert()->values($values); 
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);

		return $sqlStmt->execute();
	}

	public function fetchAllArticulos()
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
		    ->order('fecha_alta ASC');

		$sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler = $sqlStmt->execute();

		$classMethod = new ClassMethodsHydrator();
		$entity      = new ArticulosEntity();
		$resultSet   = new HydratingResultSet($classMethod, $entity);

		$resultSet->initialize($handler);

		return $resultSet;
	}

	public function fetchArticuloById($id)
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
		    ->where(['id' => $id]);
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler  = $sqlStmt->execute()->current();

		if(!$handler) {
			return null;
		}

		$classMethod = new ClassMethodsHydrator();
		$entity      = new ArticulosEntity();
		$classMethod->hydrate($handler, $entity);
		return $entity;
	}

	public function updateArticulo($data, $id)
	{
		$values = [
			'articulo' => $data['articulo'],
			'user_id' => $data['user_id'],
			'foto' => $data['foto'],
		];

		$sqlQuery = $this->sql->update()->set($values)->where(['id' => $id]);
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);

		return $sqlStmt->execute();
	}

	public function deleteArticulo($id)
	{        
		$sqlQuery = $this->sql->delete()->where(['id' => $id]);
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
		return $sqlStmt->execute();
	}



}