<?php
namespace FluidTYPO3\Fromage\ViewHelpers\Form;
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
		$this->registerArgument('csv', 'string', 'Optional CSV alternative options list', FALSE);
	}

	/**
	 * @return array
	 */
	protected function getOptions() {
		if (FALSE === empty($this->arguments['csv'])) {
			$exploded = GeneralUtility::trimExplode(',', $this->arguments['csv']);
			$this->arguments['options'] = array_combine($exploded, $exploded);
		} else {
			$key = key($this->arguments['options']);
			if (TRUE === isset($this->arguments['options'][$key]['item']) && 2 === count($this->arguments['options'][$key]['item'])) {
				$options = array();
				foreach ($this->arguments['options'] as $item) {
					$options[$item['item']['value']] = $item['item']['label'];
				}
				$this->arguments['options'] = $options;
			}
		}
		return parent::getOptions();
	}


}