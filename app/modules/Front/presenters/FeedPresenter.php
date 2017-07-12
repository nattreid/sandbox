<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\Services\PageService;

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
	public function renderSitemap(): void
	{
		$links = [
			$this->link('//:Front:Homepage:')
		];

		// staticke stranky
		$pages = $this->pageService->findPages();
		foreach ($pages as $page) {
			$links[] = $page->link;
		}

		$this->template->links = $links;
	}

}
