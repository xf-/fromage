<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('FluidTYPO3.Fromage', 'Form',
	array('Form' => 'form,submit,receipt'),
	array('Form' => 'submit'),
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin('FluidTYPO3.Fromage', 'Receipt',
	array('Form' => 'form,submit,receipt'),
	array('Form' => 'submit'),
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\Fromage\Provider\FromageProvider');

// native field type registrations. Added using simple names which are easy to target (see Core class' doc comment)
\FluidTYPO3\Fromage\Core::registerFieldObject('content');
\FluidTYPO3\Fromage\Core::registerFieldObject('input');
\FluidTYPO3\Fromage\Core::registerFieldObject('text');
\FluidTYPO3\Fromage\Core::registerFieldObject('checkbox');
\FluidTYPO3\Fromage\Core::registerFieldObject('select');
\FluidTYPO3\Fromage\Core::registerFieldObject('relation');

// native sheet types, there's only one of these and it is called "Grouping" and allows all fields to be used
\FluidTYPO3\Fromage\Core::registerSheetObject('grouping');
