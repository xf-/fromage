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

use FluidTYPO3\Flux\Form\Container\Object;
use FluidTYPO3\Flux\Form\Container\Section;
use FluidTYPO3\Fromage\Core;

/**
 * Abstract Form Object
 *
 * @package Fromage
 */
class AbstractFormObject extends Object {

	/**
	 * @return void
	 */
	protected function createRegisteredInputObjects() {
		$fields = Core::getFieldObjects();
		foreach ($fields as $fieldTypeOrClassName) {
			$this->createFromageObject($fieldTypeOrClassName, 'Field');
		}
		$buttons = Core::getButtonObjects();
		foreach ($buttons as $buttonTypeOrClassName) {
			$this->createFromageObject($buttonTypeOrClassName, 'Button');
		}
	}

	/**
	 * @param string $type
	 * @param string $scope
	 * @return void
	 */
	protected function createFromageObject($type, $scope = NULL) {
		$namespace = 'FluidTYPO3\Fromage\Backend\FormComponent\\' . (NULL !== $scope ? $scope . '\\' : '');
		if (FALSE === class_exists($type)) {
			$className = $namespace . ucfirst($type) . 'Object';
		} else {
			$className = $type;
		}
		if (FALSE === is_a($this, $className)) {
			$this->get('fields')->createContainer($className, $type);
		}
	}

}