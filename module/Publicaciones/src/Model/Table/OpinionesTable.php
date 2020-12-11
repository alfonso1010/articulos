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
use Publicaciones\Model\Entity\OpinionesEntity;


class OpinionesTable extends AbstractTableGateway
{
	protected $adapter;          # adapter to use to connect to the database
	protected $table = 'opiniones_articulo';  # our table. one we want to store data in

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}

	public function saveOpinion(array $data)
	{
		$timeNow = date('Y-m-d H:i:s');
		$values = [
			'articulo_id' => $data['articulo_id'],
			'user_id' => $data['user_id'],
			'me_gusta' => $data['me_gusta'],//1 - me gusta, 2 - no me gusta
			'fecha_alta'  => $timeNow,
		];

		$sqlQuery = $this->sql->insert()->values($values); 
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);

		return $sqlStmt->execute();
	}

	public function fetchAllMeGustaByIdArticulo($id_articulo)
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
			->where(['articulo_id' => $id_articulo])	
			->where(['me_gusta' => "1"])	
		    ->order('fecha_alta ASC');

		$sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler = $sqlStmt->execute();

		$classMethod = new ClassMethodsHydrator();
		$entity      = new OpinionesEntity();
		$resultSet   = new HydratingResultSet($classMethod, $entity);

		$resultSet->initialize($handler);

		return $resultSet;
	}

	public function fetchAllNoMeGustaByIdArticulo($id_articulo)
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
			->where(['articulo_id' => $id_articulo])	
			->where(['me_gusta' => "2"])	
		    ->order('fecha_alta ASC');

		$sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler = $sqlStmt->execute();

		$classMethod = new ClassMethodsHydrator();
		$entity      = new OpinionesEntity();
		$resultSet   = new HydratingResultSet($classMethod, $entity);

		$resultSet->initialize($handler);

		return $resultSet;
	}

	public function fetchAllMeGustaByIdArticuloAndUser($id_articulo,$user_id)
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
			->where(['articulo_id' => $id_articulo])	
			->where(['opiniones_articulo.user_id' => $user_id]);

		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler  = $sqlStmt->execute()->current();

		if(!$handler) {
			return null;
		}

		$classMethod = new ClassMethodsHydrator();
		$entity      = new OpinionesEntity();
		$classMethod->hydrate($handler, $entity);
		return $entity;
	}
	

}