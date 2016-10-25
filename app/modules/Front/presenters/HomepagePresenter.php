<?php

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\Service;

/**
 * Homepage presenter.
 *
 * @author Attreid <attreid@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var Service */
	private $webManager;

	public function __construct(Service $webManager)
	{
		parent::__construct();
		$this->webManager = $webManager;
	}

	public function actionPage($url)
	{
		$page = $this->webManager->getPage($url);
		$this->template->page = $page;
	}

}
