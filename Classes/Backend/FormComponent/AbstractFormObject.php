<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Form\Container\Object;
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
