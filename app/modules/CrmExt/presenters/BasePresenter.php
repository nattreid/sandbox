<?php

namespace App\CrmModule\Presenters;

use Nette\Utils\Strings;

/**
 * Zakladni presenter
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends \NAttreid\Crm\Control\ModulePresenter {
    /* ###################################################################### */
    /*                               Webloader                                */

    /** @var \WebLoader\Nette\LoaderFactory */
    private $webLoader;

    public function injectWebLoader(\WebLoader\Nette\LoaderFactory $webLoader) {
        $this->webLoader = $webLoader;
    }

    /** @return \WebLoader\Nette\CssLoader */
    protected function createComponentCss() {
        return $this->webLoader->createCssLoader('crm');
    }

    /** @return \WebLoader\Nette\JavaScriptAsyncLoader */
    protected function createComponentJs() {
        return $this->webLoader->createJavaScriptLoader('crm', 'crm' . Strings::firstUpper($this->locale));
    }

}
