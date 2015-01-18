<?php
namespace FluidTYPO3\Fromage\Backend\FormComponent\Field;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * Relation Field Object
 *
 * Predefined Form component for adding Relation record selection field objects.
 *
 * @package Flux
 */
class RelationObject extends SelectObject {

	/**
	 * @var string
	 */
	protected $name = 'relation';

	/**
	 * @return void
	 */
	public function initializeObject() {
		parent::initializeObject();
		$this->remove('items');
		$this->remove('customItems');
		$tables = array_keys($GLOBALS['TCA']);
		sort($tables);
		$items = array_combine($tables, $tables);
		$this->createField('Select', 'table')->setItems($items);
	}

}
