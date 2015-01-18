<?php
namespace FluidTYPO3\Fromage\ViewHelpers\Form;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

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
