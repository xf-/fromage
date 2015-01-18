<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Content Container Field Object
 *
 * Does not render a field but instead, renders content element(s)
 * which can be edited through the page module.
 *
 * @package Flux
 */
class ContentObject extends AbstractFieldObject {

	/**
	 * @var string
	 */
	protected $name = 'content';

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->createField('Input', 'name');
	}

}
