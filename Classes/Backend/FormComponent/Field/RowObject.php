<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Field Row grouping Object
 *
 * Predefined Form component for adding Input field objects.
 *
 * @package Flux
 */
class RowObject extends AbstractFieldObject {

	/**
	 * @var string
	 */
	protected $name = 'input';

	/**
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->createContainer('Section', 'fields');
		$this->createRegisteredInputObjects();
	}

}
