<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Input Field Object
 *
 * Predefined Form component for adding Input field objects.
 *
 * @package Flux
 */
class TextObject extends AbstractFieldObject {

	/**
	 * @var string
	 */
	protected $name = 'text';

	/**
	 * CONSTRUCTOR
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->createSliderFieldAndWizard('rows');
		$this->createSliderFieldAndWizard('cols');
	}

	/**
	 * @param string $name
	 */
	protected function createSliderFieldAndWizard($name) {
		$this->createField('Input', $name)
				->setValidate('trim,int')
				->setMinimum(1)
				->setMaximum(100)
				->setSize(2);
	}

}
