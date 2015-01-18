<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Sheet;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Form\Container\Object;
use FluidTYPO3\Flux\Form\Container\Section;
use FluidTYPO3\Flux\FormInterface;
use FluidTYPO3\Fromage\Backend\FormComponent\SheetObject;
use FluidTYPO3\Fromage\Core;

/**
 * Grouping Sheet Object
 *
 * Supports every field object type added to Fromage.
 *
 * @package Flux
 */
class GroupingObject extends SheetObject {

	/**
	 * @var string
	 */
	protected $name = 'grouping';

	/**
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		/** @var Section $section */
		$section = $this->get('fields');
		$this->createRegisteredInputObjects($section);

	}

}
