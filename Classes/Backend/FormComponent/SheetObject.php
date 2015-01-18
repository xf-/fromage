<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

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
