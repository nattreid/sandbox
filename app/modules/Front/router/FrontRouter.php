<?php

namespace App\FrontModule\Router;

use Nette\Application\Routers\Route,
    NAttreid\WebManager\PageService;

/**
 * Router Front
 * 
 * @author Attreid <attreid@gmail.com>
 */
class FrontRouter extends \NAttreid\Routing\Router {

    /** @var PageService */
    private $pageService;

    public function __construct($url, $secured, PageService $pageService) {
        parent::__construct($url, $secured);
        $this->pageService = $pageService;
    }

    public function createRoutes() {
        $routes = $this->getRouter('Front');


//        $routes[] = new Route($this->getUrl(). '[<url>]', 'Homepage:page', $this->getFlag());
//        
//        $routes[] = new Route($this->getUrl(), 'Homepage:default', $this->getFlag());
//        $routes[] = new Route($this->getUrl() . 'index.php','Homepage:page', Route::ONE_WAY);
//        $routes[] = new Route($this->getUrl() . '<presenter>[/<action>]', 'Homepage:page', $this->getFlag());
        $this->pageService->createRoute($routes, $this->getUrl(), $this->getFlag());
    }

}
