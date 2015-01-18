<?php
namespace FluidTYPO3\Fromage\Provider;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

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
		if ($row['CType'] !== $this->contentObjectType) {
			return array(NULL, NULL, TRUE);
		}
		$values = $this->getFlexFormValues($row);
		if (FALSE === isset($values['pipesIn'])) {
			$values['pipesIn'] = array();
		}
		if (FALSE === isset($values['pipesOut'])) {
			$values['pipesOut'] = array();
		}
		$content = array();
		foreach ((array) $values['structure'] as $grouping) {
			$content[] = $this->renderPreviewFloatBlock($grouping['sheet']['name'], 'test', 'Group');
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
