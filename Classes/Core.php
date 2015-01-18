<?php
namespace FluidTYPO3\Fromage;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

/**
 * FROMAGE CORE
 *
 * Quick-access API methods to easily integrate with Fromage.
 *
 * Brief how-to:
 *
 * You can register new field object types to use in every Fromage form,
 * simply by calling \FluidTYPO3\Fromage\Core::registerFieldObject($myClass);
 * The class $myClass must then implement the FormFieldInterface or
 * ContainerInterface.
 *
 * You can replace built-in field types by passing a second argument:
 * \FluidTYPO3\Fromage\Core::registerFieldObject($myClass, $insteadOfType);
 *
 * Where $insteadOfType can be a lowercase name of any of the classes
 * in namespace FluidTYPO3\Fromage\Backend\FormComponent\Field. Your
 * class name will then be used instead of that native type.
 *
 * You can register complete sheet objects (see classes in namespace
 * FluidTYPO3\Fromage\Backend\FormComponent\Sheet) - in addition or
 * replacing built-in sheets like the "structure" sheet completely.
 *
 * Custom sheet- and field types must then be rendered using special
 * templates which you also provide (example: add a DatePicker field
 * type and you must - for example using TS view overlays, EXT:view
 * style - provide a special DatePicker partial template as well as
 * the actual field object class. You can then load any required
 * assets for example by using Assets from EXT:vhs).
 *
 * The same can be done with Outlets and Pipes with the same result,
 * except Outlets and Pipes do not require any template files; just
 * the classes.
 *
 * @author Claus Due
 * @package Fromage
 * @subpackage Core
 */
class Core {

	/**
	 * @var array
	 */
	protected static $fields = array();

	/**
	 * @var array
	 */
	protected static $buttons = array();

	/**
	 * @var array
	 */
	protected static $sheets = array();

	/**
	 * @param string $typeOrClassName
	 * @param string $insteadOfNativeType
	 * @return void
	 */
	public static function registerFieldObject($typeOrClassName, $insteadOfNativeType = NULL) {
		$key = NULL === $insteadOfNativeType ? $typeOrClassName : $insteadOfNativeType;
		self::$fields[$key] = $typeOrClassName;
	}

	/**
	 * @param string $typeOrClassName
	 * @param string $insteadOfNativeType
	 * @return void
	 */
	public static function registerButtonObject($typeOrClassName, $insteadOfNativeType = NULL) {
		$key = NULL === $insteadOfNativeType ? $typeOrClassName : $insteadOfNativeType;
		self::$buttons[$key] = $typeOrClassName;
	}

	/**
	 * @param string $typeOrClassName
	 * @param string $insteadOfNativeType
	 * @return void
	 */
	public static function registerSheetObject($typeOrClassName, $insteadOfNativeType = NULL) {
		$key = NULL === $insteadOfNativeType ? $typeOrClassName : $insteadOfNativeType;
		self::$sheets[$key] = $typeOrClassName;
	}

	/**
	 * @return array
	 */
	public static function getFieldObjects() {
		return array_values(self::$fields);
	}

	/**
	 * @return array
	 */
	public static function getButtonObjects() {
		return array_values(self::$buttons);
	}

	/**
	 * @return array
	 */
	public static function getSheetObjects() {
		return array_values(self::$sheets);
	}

}
