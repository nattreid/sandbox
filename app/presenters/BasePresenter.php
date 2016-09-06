<?php

namespace App\Presenters;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

	use \WebChemistry\Images\TPresenter,
		\NAttreid\Latte\TemplateTrait,
		\Nextras\Application\UI\SecuredLinksPresenterTrait;

	protected function startup()
	{
		parent::startup();

		// lokalizace
		if (empty($this->locale)) {
			$this->locale = $this->translator->getDefaultLocale();
		}
		\NAttreid\Utils\Number::setLocale($this->locale);
		\NAttreid\Utils\Date::setLocale($this->locale);
		$this->template->locale = $this->locale;
	}

	/* ###################################################################### */
	/*                               Configurator                             */

	/** @var \NAttreid\Crm\Configurator */
	protected $configurator;

	public function injectConfigurator(\NAttreid\Crm\Configurator $configurator)
	{
		$this->configurator = $configurator;
	}

	/* ###################################################################### */
	/*                               Translator                               */

	/** @persistent */
	public $locale;

	/** @var \Kdyby\Translation\Translator */
	private $translator;

	public function injectTranslator(\Kdyby\Translation\Translator $translator)
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
