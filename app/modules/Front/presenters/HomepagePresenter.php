<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\WebManager\Model\Pages\Page;
use NAttreid\WebManager\Services\PageService;
use Nette\Application\BadRequestException;

/**
 * Homepage presenter.
 *
 * @author Attreid <attreid@gmail.com>
 */
class HomepagePresenter extends BasePresenter
{

	/** @var PageService */
	private $pageService;

	/** @var Page */
	private $page;

	public function __construct(PageService $pageService)
	{
		parent::__construct();
		$this->pageService = $pageService;
	}

	/**
	 * @param null|string $url
	 * @throws BadRequestException
	 */
	public function actionPage(?string $url): void
	{
		$this->page = $this->pageService->getPage($url);
	}

	public function renderPage(): void
	{
		$this->template->page = $this->page;
	}

	public function renderOnePage(): void
	{
		$this->template->pages = $this->pageService->findMenuPages();
	}
}
