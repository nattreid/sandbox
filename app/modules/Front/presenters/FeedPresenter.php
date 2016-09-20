<?php

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\PageService;

/**
 * Feedy
 *
 * @author Attreid <attreid@gmail.com>
 */
class FeedPresenter extends BasePresenter
{

	/** @var PageService */
	private $pageService;

	public function __construct(PageService $pageService)
	{
		parent::__construct();
		$this->pageService = $pageService;
	}

	/**
	 * Vytvoreni sitemap.xml
	 */
	public function renderSitemap()
	{
		$links = [
			$this->link('//:Front:Homepage:')
		];

		// staticke stranky
		$pages = $this->pageService->getPages();
		foreach ($pages as $page) {
			$links[] = $this->link('//:Front:Homepage:page', $page->url);
		}

		$this->template->links = $links;
	}

}
