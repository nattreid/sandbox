<?php

namespace App\Presenters;

use App\Services\IConfigurator;
use Kdyby\Translation\Translator;
use NAttreid\Crm\Configurator\Configurator;
use NAttreid\Latte\TemplateTrait;
use NAttreid\Utils\Date;
use NAttreid\Utils\Number;
use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;
use WebChemistry\Images\TPresenter;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Presenter
{

	use TPresenter,
		TemplateTrait,
		SecuredLinksPresenterTrait;

	protected function startup()
	{
		parent::startup();

		// lokalizace
		if (empty($this->locale)) {
			$this->locale = $this->translator->getDefaultLocale();
		}
		Number::setLocale($this->locale);
		Date::setLocale($this->locale);
		$this->template->locale = $this->locale;
	}

	/* ###################################################################### */
	/*                               Configurator                             */

	/** @var IConfigurator */
	protected $configurator;

	public function injectConfigurator(Configurator $configurator)
	{
		$this->configurator = $configurator;
	}

	/* ###################################################################### */
	/*                               Translator                               */

	/** @persistent */
	public $locale;

	/** @var Translator */
	private $translator;

	public function injectTranslator(Translator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * Translates the given string.
	 *
	 * @param string $message The message id
	 * @param integer $count The number to use to find the indice of the message
	 * @param array $parameters An array of parameters for the message
	 * @param string $domain The domain for the message
	 * @param string $locale The locale
	 *
	 * @return string
	 */
	protected function translate($message, $count = NULL, array $parameters = [], $domain = NULL, $locale = NULL)
	{
		return $this->translator->translate($message, $count, $parameters, $domain, $locale);
	}

}
