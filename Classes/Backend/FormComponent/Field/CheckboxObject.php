<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Checkbox Field Object
 *
 * Predefined Form component for adding Checkbox field objects.
 *
 * @package Flux
 */
class CheckboxObject extends AbstractFieldObject {

	/**
	 * @var string
	 */
	protected $name = 'checkbox';

	/**
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->createField('Checkbox', 'checked');
	}

}
