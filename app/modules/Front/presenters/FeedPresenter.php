<?php

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\Service;

/**
 * Feedy
 *
 * @author Attreid <attreid@gmail.com>
 */
class FeedPresenter extends BasePresenter
{

	/** @var Service */
	private $webManager;

	public function __construct(Service $webManager)
	{
		parent::__construct();
		$this->webManager = $webManager;
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
		$pages = $this->webManager->getPages();
		foreach ($pages as $page) {
			$links[] = $this->link('//:Front:Homepage:page', $page->url);
		}

		$this->template->links = $links;
	}

}
