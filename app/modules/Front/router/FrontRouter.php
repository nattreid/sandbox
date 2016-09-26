<?php

namespace App\FrontModule\Router;

use NAttreid\WebManager\PageService;
use Nette\Application\Routers\Route;

/**
 * Router Front
 *
 * @author Attreid <attreid@gmail.com>
 */
class FrontRouter extends \NAttreid\Routing\Router
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

		$routes[] = new Route($this->getUrl() . 'sitemap.xml', 'Feed:sitemap');

		$this->pageService->createRoute($routes, $this->getUrl());
	}

}
