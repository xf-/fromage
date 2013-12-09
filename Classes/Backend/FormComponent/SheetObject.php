<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent;
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

/**
 * Sheet Object
 *
 * Predefined object for backend form which constructs Flux
 * form definitions to be used elsewhere. Is merely an
 * Object to place in a Section. Used as base class by special
 * SheetObjects (see fx FluidTYPO3\Fromage\Backend\FormComponent\Sheet\GroupingObject).
 *
 * @package Flux
 */
class SheetObject extends AbstractFormObject {

	/**
	 * @return void
	 */
	public function initializeObject() {
		$this->setLocalLanguageFileRelativePath($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fromage']['setup']['languageFileRelativePath']);
		$this->createField('Input', 'name')
				->setDefault($this->name);
		$this->createField('Input', 'label');
		$this->createContainer('Section', 'fields');
	}

	/**
	 * @param string $name
	 * @return GroupingObject
	 */
	public function setName($name) {
		if (NULL !== $name) {
			$this->name = $name;
		}
	}

}
