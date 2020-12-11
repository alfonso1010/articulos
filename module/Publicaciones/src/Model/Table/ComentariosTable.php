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
use Publicaciones\Model\Entity\ComentariosEntity;


class ComentariosTable extends AbstractTableGateway
{
	protected $adapter;          # adapter to use to connect to the database
	protected $table = 'comentarios_articulo';  # our table. one we want to store data in

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->initialize();
	}

	public function saveComentario(array $data)
	{
		$timeNow = date('Y-m-d H:i:s');
		$values = [
			'articulo_id' => $data['articulo_id'],
			'user_id' => $data['user_id'],
			'comentario' => $data['comentario'],
			'fecha_alta'  => $timeNow,
		];

		$sqlQuery = $this->sql->insert()->values($values); 
		$sqlStmt  = $this->sql->prepareStatementForSqlObject($sqlQuery);

		return $sqlStmt->execute();
	}

	public function fetchAllComentariosByIdArticulo($id_articulo)
	{
		$sqlQuery = $this->sql->select()->join('users', 'users.user_id='.$this->table.'.user_id',
		     ['email'])
			->where(['articulo_id' => $id_articulo])	
		    ->order('fecha_alta ASC');

		$sqlStmt = $this->sql->prepareStatementForSqlObject($sqlQuery);
		$handler = $sqlStmt->execute();

		$classMethod = new ClassMethodsHydrator();
		$entity      = new ComentariosEntity();
		$resultSet   = new HydratingResultSet($classMethod, $entity);

		$resultSet->initialize($handler);

		return $resultSet;
	}

	

}