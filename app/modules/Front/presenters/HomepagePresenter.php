<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\Services\PageService;

/**
 * Homepage presenter.
 *
 * @author Attreid <attreid@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var PageService */
	private $pageService;

	public function __construct(PageService $pageService)
	{
		parent::__construct();
		$this->pageService = $pageService;
	}

	public function actionPage($url)
	{
		$page = $this->pageService->getPage($url);
		$this->template->page = $page;
	}

}
