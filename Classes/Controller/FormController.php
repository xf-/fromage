<?php
namespace FluidTYPO3\Fromage\Controller;
use FluidTYPO3\Flux\Controller\AbstractFluxController;
use FluidTYPO3\Flux\Outlet\Exception;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

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
