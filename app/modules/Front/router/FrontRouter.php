<?php

namespace App\FrontModule\Router;

use NAttreid\Routing\Router;
use NAttreid\WebManager\Service;
use Nette\Application\Routers\Route;

/**
 * Router Front
 *
 * @author Attreid <attreid@gmail.com>
 */
class FrontRouter extends Router
{

	/** @var Service */
	private $webManager;

	public function __construct($url, Service $webManager)
	{
		parent::__construct($url);
		$this->webManager = $webManager;
	}

	public function createRoutes()
	{
		$routes = $this->getRouter('Front');

		$routes[] = new Route($this->getUrl() . 'sitemap.xml', 'Feed:sitemap');

		$this->webManager->createRoute($routes, $this->getUrl());
	}

}
