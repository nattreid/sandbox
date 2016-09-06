<?php

namespace App\FrontModule\Presenters;

use NAttreid\CookiePolicy\ICookiePolicyFactory;
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
	/*                               Translator                               */

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

}
