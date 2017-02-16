<?php

namespace App\FrontModule\Presenters;

use NAttreid\CookiePolicy\ICookiePolicyFactory;
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

	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->baseKeywords = $this->configurator->keywords;
		$this->template->baseDescription = $this->configurator->description;
		$this->template->baseTitle = $this->configurator->title;

		$this->template->menuPages = $this->pageService->findMenuPages();
		$this->template->footerPages = $this->pageService->findFooterPages();
	}

	/* ###################################################################### */
	/*                               Webloader                                */

	/** @var LoaderFactory */
	private $webLoader;

	public function injectWebLoader(LoaderFactory $webLoader)
	{
		$this->webLoader = $webLoader;
	}

	/** @return CssLoader */
	protected function createComponentCss()
	{
		return $this->webLoader->createCssLoader('front');
	}

	/** @return JavaScriptLoader */
	protected function createComponentJs()
	{
		return $this->webLoader->createJavaScriptLoader('front', 'front' . Strings::firstUpper($this->locale));
	}

	/* ###################################################################### */
	/*                              CookiePolicy                              */

	/** @var ICookiePolicyFactory */
	private $cookiePolicyFactory;

	public function injectCookiePolicyFactory(ICookiePolicyFactory $cookiePolicyFactory)
	{
		$this->cookiePolicyFactory = $cookiePolicyFactory;
	}

	protected function createComponentCookiePolicy()
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

	public function injectWebManagerService(PageService $pageService)
	{
		$this->pageService = $pageService;
	}

	/* ###################################################################### */
	/*                              Google Api                                */

	/** @var IGoogleApiFactory */
	private $googleApiFactory;

	public function injectGoogleApiFactory(IGoogleApiFactory $googleApiFactory)
	{
		$this->googleApiFactory = $googleApiFactory;
	}

	protected function createComponentGoogleApi()
	{
		return $this->googleApiFactory->create();
	}
}
