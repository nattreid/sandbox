<?php

namespace App\FrontModule\Presenters;

use App\Model\Orm;

/**
 * Feedy
 *
 * @author Attreid <attreid@gmail.com>
 */
class FeedPresenter extends BasePresenter
{

	/** @var Orm */
	private $orm;

	public function __construct(Orm $orm)
	{
		parent::__construct();
		$this->orm = $orm;
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
		$pages = $this->orm->pages->findPages();
		foreach ($pages as $page) {
			$links[] = $this->link('//:Front:Homepage:page', $page->url);
		}

		$this->template->links = $links;
	}

}
