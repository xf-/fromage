<?php
namespace FluidTYPO3\Fromage\Form;

/*
 * This file is part of the FluidTYPO3/Fromage project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\Form;
use FluidTYPO3\Flux\Core as FluxCore;
use FluidTYPO3\Fromage\Core;
use FluidTYPO3\Fromage\Backend\FormComponent\PipeObject;
use FluidTYPO3\Flux\Outlet\Pipe\PipeInterface;

/**
 * @package Fromage
 */
class StandardForm extends Form {

	/**
	 * @var array
	 */
	protected $configuration = array();

	/**
	 * @param array $configuration
	 * @return void
	 */
	public function setConfiguration(array $configuration) {
		$this->configuration = $configuration;
		foreach ((array) $configuration['pipesIn'] as $pipeSettings) {
			$pipeSettings = reset($pipeSettings);
			/** @var PipeInterface $pipe */
			$pipe = $this->objectManager->get($pipeSettings['class']);
			$pipe->loadSettings($pipeSettings);
			$this->outlet->addPipeIn($pipe);
		}
		foreach ((array) $configuration['pipesOut'] as $pipeSettings) {
			$pipeSettings = reset($pipeSettings);
			/** @var PipeInterface $pipe */
			$pipe = $this->objectManager->get($pipeSettings['class']);
			$pipe->loadSettings($pipeSettings);
			$this->outlet->addPipeOut($pipe);
		}
	}

	/**
	 * Initialization
	 */
	public function initializeObject() {
		$this->outlet = $this->objectManager->get('FluidTYPO3\Flux\Outlet\StandardOutlet');
		$this->setId('form');
		$this->createStructureSheet();
		$this->createPipeSheet('pipesIn');
		$this->createPipeSheet('pipesOut');
	}

	/**
	 * @return void
	 */
	protected function createStructureSheet() {
		$sheet = $this->createContainer('Sheet', 'structure')->createContainer('Section', 'structure');
		$sheets = Core::getSheetObjects();
		$namespace = 'FluidTYPO3\Fromage\Backend\FormComponent\Sheet\\';
		foreach ($sheets as $sheetTypeOrClassName) {
			$className = TRUE === class_exists($sheetTypeOrClassName) ? $sheetTypeOrClassName : $namespace . ucfirst($sheetTypeOrClassName) . 'Object';
			$sheet->createContainer($className, NULL);
		}
	}

	/**
	 * @param string $name
	 * @return void
	 */
	protected function createPipeSheet($name) {
		$sheet = $this->createContainer('Sheet', $name)->createContainer('Section', $name);
		$namespace = 'FluidTYPO3\Flux\Outlet\Pipe\\';
		$pipes = FluxCore::getPipes();
		foreach ($pipes as $pipeTypeOrClassName) {
			$className = TRUE === class_exists($pipeTypeOrClassName) ? $pipeTypeOrClassName : $namespace . ucfirst($pipeTypeOrClassName) . 'Pipe';
			if ('FluidTYPO3\Flux\Outlet\Pipe\StandardPipe' === $className) {
				continue;
			}
			$instance = $this->objectManager->get($className);
			$label = $instance->getLabel();
			/** @var PipeObject $pipe */
			$pipe = $sheet->createContainer('FluidTYPO3\Fromage\Backend\FormComponent\PipeObject', $pipeTypeOrClassName);
			$pipe->setLabel($label)->addAll($instance->getFormFields());
		}
	}

}
