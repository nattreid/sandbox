<?php

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\PageService;

/**
 * Homepage presenter.
 * 
 * @author Attreid <attreid@gmail.com>
 */
class HomepagePresenter extends BasePresenter {

    /** @var PageService */
    private $pageService;

    public function __construct(PageService $pageService) {
        $this->pageService = $pageService;
    }

    public function actionPage($url) {
        $page = $this->pageService->getPage($url);
        $this->template->page = $page;
    }

}
