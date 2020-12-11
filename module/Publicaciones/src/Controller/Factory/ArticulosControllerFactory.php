<?php

declare(strict_types=1);

namespace Publicaciones\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Publicaciones\Controller\ArticulosController;
use Publicaciones\Model\Table\ArticulosTable;
use Publicaciones\Model\Table\ComentariosTable;
use Publicaciones\Model\Table\OpinionesTable;

class ArticulosControllerFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		return new ArticulosController(
			$container->get(ArticulosTable::class),
			$container->get(ComentariosTable::class),
			$container->get(OpinionesTable::class),
		);
	}
}