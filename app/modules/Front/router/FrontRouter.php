<?php

namespace App\FrontModule\Router;

use NAttreid\Routing\Router;
use NAttreid\WebManager\Services\PageService;
use Nette\Application\Routers\Route;

/**
 * Router Front
 *
 * @author Attreid <attreid@gmail.com>
 */
class FrontRouter extends Router
{

	/** @var PageService */
	private $pageService;

	public function __construct($url, PageService $pageService)
	{
		parent::__construct($url);
		$this->pageService = $pageService;
	}

	public function createRoutes()
	{
		$routes = $this->getRouter('Front');

		$routes[] = new Route($this->url . 'sitemap.xml', 'Feed:sitemap');

		$this->pageService->createRoute($routes, $this->url);
	}

}
