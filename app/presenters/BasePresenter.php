<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Services\IConfigurator;
use IPub\FlashMessages\Components\Control;
use IPub\FlashMessages\Components\IControl;
use IPub\FlashMessages\Entities\IMessage;
use IPub\FlashMessages\Entities\Message;
use IPub\FlashMessages\FlashNotifier;
use IPub\FlashMessages\Storage\IStorage;
use Kdyby\Translation\Translator;
use NAttreid\Cms\Configurator\Configurator;
use NAttreid\Form\Factories\FormFactory;
use NAttreid\ImageStorage\TraitImagePresenter;
use NAttreid\Latte\TemplateTrait;
use NAttreid\Security\User;
use NAttreid\Utils\Date;
use NAttreid\Utils\Number;
use Nette\Application\UI\Presenter;
use Nextras\Application\UI\SecuredLinksPresenterTrait;

/**
 * Class BasePresenter
 *
 * @property-read User $user
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends Presenter
{

	use TraitImagePresenter,
		TemplateTrait,
		SecuredLinksPresenterTrait;

	protected function startup(): void
	{
		parent::startup();
		$this->initLocale();
	}

	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->redrawFlashMessages();
	}

	/* ###################################################################### */
	/*                               Configurator                             */

	/** @var IConfigurator */
	protected $configurator;

	public function injectConfigurator(Configurator $configurator): void
	{
		$this->configurator = $configurator;
	}

	/* ###################################################################### */
	/*                               Translator                               */

	/** @persistent */
	public $locale;

	/** @var Translator */
	protected $translator;

	public function injectTranslator(Translator $translator): void
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
	protected function translate(string $message, int $count = null, array $parameters = [], string $domain = null, string $locale = null): string
	{
		return $this->translator->translate($message, $count, $parameters, $domain, $locale);
	}

	private function initLocale(): void
	{
		if (empty($this->locale)) {
			$this->locale = $this->translator->getDefaultLocale();
		}

		Number::setLocale($this->locale);
		Date::setLocale($this->locale);
		$this->template->locale = $this->locale;
	}

	/* ###################################################################### */
	/*                             FlashMessages                              */

	/** @var IControl */
	private $flashMessagesFactory;

	/** @var FlashNotifier */
	protected $flashNotifier;

	/** @var IStorage */
	private $flashStorage;

	/**
	 * @param IControl $flashMessagesFactory
	 * @param FlashNotifier $flashNotifier
	 */
	public function injectFlashMessages(IControl $flashMessagesFactory, FlashNotifier $flashNotifier, IStorage $flashStorage): void
	{
		$this->flashMessagesFactory = $flashMessagesFactory;
		$this->flashNotifier = $flashNotifier;
		$this->flashStorage = $flashStorage;
	}

	/**
	 * Store flash message
	 *
	 * @param string $message
	 * @param string $level
	 * @param string|null $title
	 * @param bool $overlay
	 * @param int|null $count
	 * @param array|null $parameters
	 *
	 * @return IMessage
	 */
	public function flashMessage($message, $level = 'info', $title = null, $overlay = false, $count = null, $parameters = []): IMessage
	{
		return $this->flashNotifier->message($message, $level, $title, $overlay, $count, $parameters);
	}

	/**
	 * Flash messages component
	 *
	 * @return Control
	 */
	protected function createComponentFlashMessages(): Control
	{
		return $this->flashMessagesFactory->create();
	}

	private function redrawFlashMessages(): void
	{
		if ($this->isAjax()) {
			/* @var $messages Message[] */
			$messages = $this->flashStorage->get(IStorage::KEY_MESSAGES, []);
			foreach ($messages as $message) {
				if (!$message->isDisplayed()) {
					$this['flashMessages']->redrawControl();
					break;
				}
			}
		}
	}

	/* ###################################################################### */
	/*                                FormFactory                             */

	/** @var FormFactory */
	protected $formFactory;

	public function injectFormFactory(FormFactory $formFactory): void
	{
		$this->formFactory = $formFactory;
	}
}
