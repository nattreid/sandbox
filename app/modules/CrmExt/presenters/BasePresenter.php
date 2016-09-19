<?php

namespace App\CrmModule\Presenters;

use App\CrmModule\IConfigurator;
use NAttreid\Crm\Control\ModulePresenter;

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
