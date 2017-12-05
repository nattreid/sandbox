<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\Cms\LocaleService;
use Nette\Application\BadRequestException;
use Nette\Application\Request;

class Error4xxPresenter extends BasePresenter
{

	/** @var LocaleService */
	private $localeService;

	public function __construct(LocaleService $localeService)
	{
		parent::__construct();
		$this->localeService = $localeService;
	}

	/**
	 * @throws BadRequestException
	 */
	public function startup(): void
	{
		if (($request = $this->getRequest()->getParameter('request'))) {
			$this->locale = $request->getParameter('locale');
		} else {
			$this->locale = $this->localeService->default;
		}

		parent::startup();
		if (!$this->getRequest()->isMethod(Request::FORWARD)) {
			$this->error();
		}
	}

	public function renderDefault(BadRequestException $exception): void
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}

}
