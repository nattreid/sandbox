<?php

namespace App\FrontModule\Presenters;

use Nette\Utils\Strings;

/**
 * Zakladni presenter pro stranky
 * 
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends \App\Presenters\BasePresenter {

    protected function beforeRender() {
        parent::beforeRender();
        $this->template->baseKeywords = $this->configurator->keywords;
        $this->template->baseDescription = $this->configurator->description;
        $this->template->baseTitle = $this->configurator->title;
    }

    /* ###################################################################### */
    /*                               Webloader                                */

    /** @var \WebLoader\Nette\LoaderFactory */
    private $webLoader;

    public function injectWebLoader(\WebLoader\Nette\LoaderFactory $webLoader) {
        $this->webLoader = $webLoader;
    }

    /** @return \WebLoader\Nette\CssLoader */
    protected function createComponentCss() {
        return $this->webLoader->createCssLoader('front');
    }

    /** @return \WebLoader\Nette\JavaScriptAsyncLoader */
    protected function createComponentJs() {
        return $this->webLoader->createJavaScriptLoader('front', 'front' . Strings::firstUpper($this->locale));
    }

    /* ###################################################################### */
    /*                               Translator                               */

    /** @var \NAttreid\CookiePolicy\ICookiePolicyFactory */
    private $cookiePolicyFactory;

    public function injectCookiePolicyFactory(\NAttreid\CookiePolicy\ICookiePolicyFactory $cookiePolicyFactory) {
        $this->cookiePolicyFactory = $cookiePolicyFactory;
    }

    protected function createComponentCookiePolicy() {
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
