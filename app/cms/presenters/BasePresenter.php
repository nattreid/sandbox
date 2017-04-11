<?php

declare(strict_types=1);

namespace App\Cms\Presenters;

use App\Services\IConfigurator;
use NAttreid\Cms\Control\ModulePresenter;

/**
 * Zakladni presenter
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class BasePresenter extends ModulePresenter
{
	/** @var IConfigurator */
	protected $configurator;
}
