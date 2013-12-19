<?php
namespace FluidTYPO3\Fromage\ViewHelpers\Form;
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

use TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper;

/**
 * Field name generator
 *
 * Renders a field name for a given Field Component definition
 *
 * @package Fromage
 */
class FieldNameViewHelper extends AbstractFormFieldViewHelper {

	/**
	 * @param array $field
	 * @return string
	 */
	public function render(array $field) {
		$nameParts = explode('.', $field['name']);
		$newName = 'data[' . implode('][', $nameParts) . ']';
		$this->registerFieldNameForFormTokenGeneration($newName);
		return $newName;
	}

}
