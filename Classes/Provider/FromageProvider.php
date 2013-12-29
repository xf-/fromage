<?php
namespace FluidTYPO3\Fromage\Provider;
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

use FluidTYPO3\Flux\Form\Container\Grid;
use FluidTYPO3\Flux\Form\Container\Sheet;
use FluidTYPO3\Flux\Provider\AbstractProvider;
use FluidTYPO3\Flux\Provider\ProviderInterface;
use FluidTYPO3\Fromage\Core;
use FluidTYPO3\Fromage\Form\StandardForm;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Fromage Provider
 *
 * @package Fromage
 */
class FromageProvider extends AbstractProvider implements ProviderInterface {

	/**
	 * @var integer
	 */
	protected $priority = 100;

	/**
	 * @var string
	 */
	protected $extensionKey = 'fromage';

	/**
	 * @var string
	 */
	protected $fieldName = 'pi_flexform';

	/**
	 * @var string
	 */
	protected $tableName = 'tt_content';

	/**
	 * @var string
	 */
	protected $contentObjectType = 'fromage_form';

	/**
	 * @var string
	 */
	protected $templatePathAndFilename = 'EXT:fromage/Resources/Private/Templates/Form/Form.html';

	/**
	 * @param array $row
	 * @return Form
	 */
	public function getForm(array $row = array()) {
		$extensionKey = $this->getExtensionKey($row);
		$variables = $this->configurationService->convertFlexFormContentToArray($row[$this->fieldName]);
		/** @var StandardForm $form */
		$formClassName = $this->getFormClassName($row);
		$form = $this->objectManager->get($formClassName);
		$form->setExtensionName($extensionKey);
		$form->setConfiguration($variables);
		return $form;
	}

	/**
	 * @param array $row
	 * @return Grid|\FluidTYPO3\Flux\Provider\FluidTYPO3\Flux\Form\Container\Grid
	 */
	public function getGrid(array $row) {
		$extensionKey = $this->getExtensionKey($row);
		$values = $this->getFlexFormValues($row);
		$areas = $this->recursivelyFetchAllContentAreaNames($values['structure']);
		/** @var Grid $grid */
		$grid = Grid::create();
		$grid->setExtensionName($extensionKey);
		foreach ($areas as $areaName) {
			$grid->createContainer('Row', 'row')->createContainer('Column', 'column')->createContainer('Content', $areaName)->setLabel($areaName);
		}
		return $grid;
	}

	/**
	 * @param array $structure
	 * @return array
	 */
	protected function recursivelyFetchAllContentAreaNames($structure) {
		$names = array();
		if (TRUE === is_array($structure)) {
			foreach ($structure as $index => $subValue) {
				if ($index === 'content' && TRUE === is_array($subValue) && 1 === count($subValue) && TRUE === isset($subValue['name'])) {
					array_push($names, $subValue['name']);
				} else {
					$names = array_merge($names, $this->recursivelyFetchAllContentAreaNames($subValue));
				}
			}
		}
		$names = array_unique($names);
		return $names;
	}

	/**
	 * @param array $row
	 * @return array
	 */
	public function getPreview(array $row) {
		$values = $this->getFlexFormValues($row);
		if ($row['CType'] !== $this->contentObjectType) {
			return array(NULL, NULL, TRUE);
		}
		if (FALSE === isset($values['pipesIn'])) {
			$values['pipesIn'] = array();
		}
		if (FALSE === isset($values['pipesOut'])) {
			$values['pipesOut'] = array();
		}
		$hrStyle = 'padding: 0px; border: 1px solid #ededed; clear: both; margin-top: 1.5em;';
		$content = array();
		foreach ((array) $values['structure'] as $grouping) {
			$content[] = $this->renderPreviewFloatBlock($grouping['sheet']['name'], 'test', 'Group');
		}
		$content[] = '<hr style="' . $hrStyle . '" />';
		foreach ((array) $values['pipesIn'] as $pipe) {
			$content[] = $this->renderPreviewFloatBlock($pipe['pipe']['name'], 'test', 'Pipe');
		}
		$content[] = '<hr style="height: 1px; padding: 0px; border: 1px solid #ededed; clear: both; margin-top: 0.5em;" />';
		foreach ((array) $values['pipesOut'] as $pipe) {
			$content[] = $this->renderPreviewFloatBlock($pipe['pipe']['name'], 'test', 'Pipe');
		}
		$content[] = '<div style="clear: both;"></div>';
		$html = implode(LF, $content);
		return array(NULL, $html, FALSE);
	}

	/**
	 * @param string $title
	 * @param string $content
	 * @param string $type
	 * @return string
	 */
	protected function renderPreviewFloatBlock($title, $content, $type = NULL) {
		if (NULL !== $type) {
			$type = '<span style="color: silver;">' . $type . '</span> ';
		}
		$lines = array();
		$lines[] = '<div style="float: left; margin-right: 1em; margin-bottom: 0.5em; border: 1px solid #ededed; padding: 1em; min-width: 25%; max-width: 25%;">';
		$lines[] = '<h4>' . $type . $title . '</h4>';
		$lines[] = $content;
		$lines[] = '</div>';
		return implode(LF, $lines);
	}

	/**
	 * @param array $row
	 * @return string
	 */
	protected function getFormClassName(array $row) {
		$formClassName = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fromage']['setup']['defaultFormClassName'];
		return $formClassName;
	}

}
