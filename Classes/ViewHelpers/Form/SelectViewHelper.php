<?php
namespace FluidTYPO3\Fromage\ViewHelpers\Form;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Extended form select box ViewHelper
 * @package Fromage
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper {

	/**
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->overrideArgument('options', 'array', 'Override; optional in this ViewHelper', FALSE, array());
		$this->registerArgument('csv', 'string', 'Optional CSV alternative options list', FALSE);
		$this->registerArgument('table', 'string', 'Optional table name from which to load options', FALSE);
	}

	/**
	 * @return array
	 */
	protected function getOptions() {
		if (FALSE === empty($this->arguments['table'])) {
			$table = $this->arguments['table'];
			$labelField = $GLOBALS['TCA'][$this->arguments['table']]['ctrl']['label'];
			if (TRUE === $this->hasArgument('optionLabelField') && $this->arguments['optionLabelField'] !== $labelField) {
				$labelField = $this->arguments['optionLabelField'];
			} else {
				$this->arguments['optionLabelField'] = $labelField;
			}
			if (TRUE === empty($this->arguments['optionValueField'])) {
				$this->arguments['optionValueField'] = 'uid';
			}
			$clause = '1=1 ' . $this->configurationManager->getContentObject()->enableFields($table);
			$fields = trim($labelField . ',' . $this->arguments['optionValueField'], ',');
			$this->arguments['options'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($fields, $table, $clause);
		} elseif (FALSE === empty($this->arguments['csv'])) {
			$exploded = GeneralUtility::trimExplode(',', $this->arguments['csv']);
			$this->arguments['options'] = array_combine($exploded, $exploded);
		}
		$first = reset($this->arguments['options']);
		$options = array();
		if (TRUE === isset($first['item']) && 1 === count($first) && 2 === count($first['item'])) {
			foreach ($this->arguments['options'] as $item) {
				list ($name, $value) = array_values($item['item']);
				$options[$value] = $name;
			}
			$this->arguments['options'] = $options;
		} elseif (2 === count($first)) {
			foreach ($this->arguments['options'] as $item) {
				list ($name, $value) = array_values($item);
				$options[$value] = FALSE === empty($name) ? $name : '[' .$this->arguments['optionValueField'] . ':' . $value . ']';
			}
			$this->arguments['options'] = $options;
		}
		return parent::getOptions();
	}


}
