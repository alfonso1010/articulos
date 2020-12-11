<?php

declare(strict_types=1);

namespace Publicaciones;

use Laminas\Db\Adapter\Adapter;
use Publicaciones\Model\Table\ArticulosTable;

class Module
{
	public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

     public function getServiceConfig(): array 
    {
    	return [
    		'factories' => [
    			ArticulosTable::class => function($sm) {
    				$dbAdapter = $sm->get(Adapter::class);
    				return new ArticulosTable($dbAdapter);
    			},
    		]
    	];
    }

  
}