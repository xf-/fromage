<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Select Field Object
 *
 * Predefined Form component for adding Select field objects.
 *
 * @package Flux
 */
class SelectObject extends AbstractFieldObject {

	/**
	 * @var string
	 */
	protected $name = 'select';

	/**
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->createField('Input', 'size')
				->setDefault(1)
				->setValidate('trim,int')
				->setSize(3);
		$this->createField('Input', 'items');
		$section = $this->createContainer('Section', 'customItems');
		$item = $section->createContainer('Object', 'item');
		$item->createField('Input', 'label');
		$item->createField('Input', 'value');
		$this->createField('Checkbox', 'multiple')
				->setDefault('');
	}

}
