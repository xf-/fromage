<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Button;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@namelesscoder.net>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
		$this->setLocalLanguageFileRelativePath($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fromage']['setup']['languageFileRelativePath']);
		$this->createField('Checkbox', 'enable')
				->setDefault(1);
		$this->createField('Input', 'label');
	}

}
