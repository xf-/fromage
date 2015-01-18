<?php
namespace FluidTYPO3\Fromage\Controller;
use FluidTYPO3\Flux\Controller\AbstractFluxController;
use FluidTYPO3\Flux\Outlet\Exception;

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
 *****************************************************************/

/**
 * Main Fromage Controller
 *
 * Renders Flux forms as selected/configured by a plugin instance.
 *
 * @package FluidTYPO3\Fromage\Controller
 */
class FormController extends AbstractFluxController {

	/**
	 * @throws \RuntimeException
	 * @return void
	 */
	protected function initializeProvider() {
		$this->provider = $this->objectManager->get('FluidTYPO3\Fromage\Provider\FromageProvider');
	}

	/**
	 * @param array $data
	 * @param \FluidTYPO3\Flux\Outlet\Exception $error
	 * @return void
	 */
	public function formAction($data = array(), $error = NULL) {
		$this->view->assign('data', $data);
		$this->view->assign('error', $error);
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function submitAction($data) {
		$record = $this->getRecord();
		try {
			$this->provider->getForm($record)->getOutlet()->fill($data)->produce();
		} catch (Exception $error) {
			$this->forward('form', NULL, NULL, array('data' => $data, 'error' => $error));
		}
		$this->redirectOrForwardToReceipt();
	}

	/**
	 * @return void
	 */
	public function receiptAction() {
		$record = $this->getRecord();
		$this->view->assign('form', $this->provider->getForm($record));
	}

	/**
	 * @return void
	 */
	protected function redirectOrForwardToReceipt() {
		if (FALSE === empty($this->setup['receiptPageUid'])) {
			$record = $this->getRecord();
			$pageUid = intval($this->settings['receiptPageUid']);
			if ($pageUid !== intval($record['pid'])) {
				#$this->redirect('receipt', 'Form');
			}
		}
		$this->forward('receipt', 'Form');
	}

}
