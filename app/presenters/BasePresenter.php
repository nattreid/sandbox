<?php

declare(strict_types = 1);

namespace App\Presenters;

use App\Services\IConfigurator;
use IPub\FlashMessages\TFlashMessages;
use Kdyby\Translation\Phrase;
use Kdyby\Translation\Translator;
use NAttreid\Cms\Configurator\Configurator;
use NAttreid\Form\Factories\FormFactory;
use NAttreid\Latte\TemplateTrait;
use NAttreid\Security\User;
use NAttreid\Utils\Date;
use NAttreid\Utils\Number;
use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;
use WebChemistry\Images\TPresenter;

/**
 * Class BasePresenter
 *
 * @property-read User $user
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends Presenter
{

	use TPresenter,
		TemplateTrait,
		TFlashMessages,
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
	protected $translator;

	public function injectTranslator(Translator $translator)
	{
		$this->translator = $translator;
	}

	/**
	 * Translates the given string.
	 *
	 * @param string|Phrase $message The message id
	 * @param integer $count The number to use to find the indice of the message
	 * @param array $parameters An array of parameters for the message
	 * @param string $domain The domain for the message
	 * @param string $locale The locale
	 *
	 * @return string
	 */
	protected function translate($message, int $count = null, array $parameters = [], string $domain = null, string $locale = null): string
	{
		return $this->translator->translate($message, $count, $parameters, $domain, $locale);
	}

	/* ###################################################################### */
	/*                                FormFactory                             */

	/** @var FormFactory */
	protected $formFactory;

	public function injectFormFactory(FormFactory $formFactory)
	{
		$this->formFactory = $formFactory;
	}
}
