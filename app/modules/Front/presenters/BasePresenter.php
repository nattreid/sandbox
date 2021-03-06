<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use NAttreid\CookiePolicy\CookiePolicy;
use NAttreid\CookiePolicy\ICookiePolicyFactory;
use NAttreid\GoogleApi\GoogleApi;
use NAttreid\GoogleApi\IGoogleApiFactory;
use NAttreid\WebManager\Services\PageService;
use Nette\Utils\Strings;
use Nextras\Dbal\UniqueConstraintViolationException;
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

	/**
	 * @throws UniqueConstraintViolationException
	 */
	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->template->configurator = $this->configurator;

		$this->template->cookiePolicy = $this['cookiePolicy'];

		$this->template->menuPages = $this->pageService->findMenuPages();
		$this->template->footerPages = $this->pageService->findFooterPages();
		$this->template->footer = $this->pageService->getContent('footer');
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

		$control->translator->setLang($this->locale);

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
