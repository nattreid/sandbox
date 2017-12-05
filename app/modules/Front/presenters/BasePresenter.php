<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\CookiePolicy\CookiePolicy;
use NAttreid\CookiePolicy\ICookiePolicyFactory;
use NAttreid\GoogleApi\GoogleApi;
use NAttreid\GoogleApi\IGoogleApiFactory;
use NAttreid\WebManager\Services\PageService;
use Nette\Utils\Strings;
use WebLoader\Nette\CssLoader;
use WebLoader\Nette\JavaScriptLoader;
use WebLoader\Nette\LoaderFactory;

/**
 * Zakladni presenter pro stranky
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends \App\Presenters\BasePresenter
{

	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->template->configurator = $this->configurator;

		$this->template->menuPages = $this->pageService->findMenuPages();
		$this->template->footerPages = $this->pageService->findFooterPages();
	}

	/* ###################################################################### */
	/*                               Webloader                                */

	/** @var LoaderFactory */
	private $webLoader;

	public function injectWebLoader(LoaderFactory $webLoader): void
	{
		$this->webLoader = $webLoader;
	}

	/** @return CssLoader */
	protected function createComponentCss(): CssLoader
	{
		return $this->webLoader->createCssLoader('front');
	}

	/** @return JavaScriptLoader
	 * @throws \WebLoader\InvalidArgumentException
	 */
	protected function createComponentJs(): JavaScriptLoader
	{
		return $this->webLoader->createJavaScriptLoader('front', 'front' . Strings::firstUpper($this->locale));
	}

	/* ###################################################################### */
	/*                              CookiePolicy                              */

	/** @var ICookiePolicyFactory */
	private $cookiePolicyFactory;

	public function injectCookiePolicyFactory(ICookiePolicyFactory $cookiePolicyFactory): void
	{
		$this->cookiePolicyFactory = $cookiePolicyFactory;
	}

	protected function createComponentCookiePolicy(): CookiePolicy
	{
		$control = $this->cookiePolicyFactory->create();

		$control->getTranslator()->setLang($this->locale);

		$link = $this->configurator->cookiePolicyLink;
		if (!empty($link)) {
			$control->setLink($link);
		}

		$control->setView($this->configurator->cookiePolicy);

		return $control;
	}

	/* ###################################################################### */
	/*                               WebManager                               */

	/** @var PageService */
	private $pageService;

	public function injectWebManagerService(PageService $pageService): void
	{
		$this->pageService = $pageService;
	}

	/* ###################################################################### */
	/*                              Google Api                                */

	/** @var IGoogleApiFactory */
	private $googleApiFactory;

	public function injectGoogleApiFactory(IGoogleApiFactory $googleApiFactory): void
	{
		$this->googleApiFactory = $googleApiFactory;
	}

	protected function createComponentGoogleApi(): GoogleApi
	{
		return $this->googleApiFactory->create();
	}
}
