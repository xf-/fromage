<?php
namespace FluidTYPO3\Fromage\Provider;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@wildside.dk>, Wildside A/S
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

use FluidTYPO3\Flux\Form;
use FluidTYPO3\Flux\Form\Container\Sheet;
use FluidTYPO3\Flux\Provider\AbstractProvider;
use FluidTYPO3\Fromage\Core;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Fromage Provider
 *
 * @package Fromage
 */
class FromageProvider extends AbstractProvider {

	/**
	 * @var integer
	 */
	protected $priority = 0;

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
	 * @param array $row
	 * @return Form
	 */
	public function getForm(array $row) {
		$form = Form::create();
		$form->setExtensionName('fromage');
		$form->setId('form');
		$form->setLocalLanguageFileRelativePath($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['fromage']['setup']['languageFileRelativePath']);
		$this->createStructureSheet($form);
		$this->createPipeSheet($form, 'pipesIn');
		$this->createPipeSheet($form, 'pipesOut');
		return $form;
	}

	/**
	 * @param array $row
	 * @return array
	 */
	public function getPreview(array $row) {
		$values = $this->getFlexFormValues($row);
		if (FALSE === isset($values['structure'])) {
			return array('', 'Plugin not yet configured, requires at least one form field');
		}
		if (FALSE === isset($values['pipesIn'])) {
			$values['pipesIn'] = array();
		}
		if (FALSE === isset($values['pipesOut'])) {
			$values['pipesOut'] = array();
		}
		$hrStyle = 'padding: 0px; border: 1px solid #ededed; clear: both; margin-top: 1.5em;';
		$content = array();
		foreach ($values['structure'] as $grouping) {
			$content[] = $this->renderPreviewFloatBlock($grouping['sheet']['name'], 'test', 'Group');
		}
		$content[] = '<hr style="' . $hrStyle . '" />';
		foreach ($values['pipesIn'] as $pipe) {
			$content[] = $this->renderPreviewFloatBlock($pipe['pipe']['name'], 'test', 'Pipe');
		}
		$content[] = '<hr style="height: 1px; padding: 0px; border: 1px solid #ededed; clear: both; margin-top: 0.5em;" />';
		foreach ($values['pipesOut'] as $pipe) {
			$content[] = $this->renderPreviewFloatBlock($pipe['pipe']['name'], 'test', 'Pipe');
		}
		#$content[] = '<h4 style="clear: both;">Pipes</h4>';
		$content[] = '<div style="clear: both;"></div>';
		return array(NULL, implode(LF, $content));
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
	 * @param Form $form
	 * @return void
	 */
	protected function createStructureSheet(Form $form) {
		$sheet = $form->createContainer('Sheet', 'structure')->createContainer('Section', 'structure');
		$sheets = Core::getSheetObjects();
		$namespace = 'FluidTYPO3\Fromage\Backend\FormComponent\Sheet\\';
		foreach ($sheets as $sheetTypeOrClassName) {
			$className = TRUE === class_exists($sheetTypeOrClassName) ? $sheetTypeOrClassName : $namespace . ucfirst($sheetTypeOrClassName) . 'Object';
			$sheet->createContainer($className, NULL);
		}
	}

	/**
	 * @param Form $form
	 * @param string $name
	 * @return void
	 */
	protected function createPipeSheet(Form $form, $name) {
		$sheet = $form->createContainer('Sheet', $name)->createContainer('Section', $name);
		$sheet->createContainer('FluidTYPO3\Fromage\Backend\FormComponent\PipeObject', 'pipe');
	}

}
