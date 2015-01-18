<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Button;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Fromage\Backend\FormComponent\AbstractFormObject;

/**
 * Base class, Field-type Form Objects
 *
 * Common base shared by for example Input, Select,
 * Text etc. field objects used in backend forms to
 * create a structure which translates to a Flux "Field"
 * component from the Flux Form namespace.
 *
 * @package Flux
 */
class AbstractButtonObject extends AbstractFormObject {

	/**
	 * CONSTRUCTOR
	 */
	public function initializeObject() {
		$this->createField('Checkbox', 'enable')
				->setDefault(1);
		$this->createField('Input', 'label');
	}

}
