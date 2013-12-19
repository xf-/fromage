<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Fromage');
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin('FluidTYPO3.Fromage', 'Form', 'Fromage: Form', 'EXT:fromage/ext_icon.gif');

$GLOBALS['TCA']['tt_content']['types']['fromage_form']['showitem'] = '--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,pi_flexform,
	LLL:EXT:cms/locallang_ttc.xlf:list_type_formlabel,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.appearance,
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.frames;frames,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
	--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.behaviour,
	select_key;LLL:EXT:cms/locallang_ttc.xlf:select_key_formlabel,
	pages;LLL:EXT:cms/locallang_ttc.xlf:pages.ALT.list_formlabel,
	recursive,
	--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended,
	--div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories';

\FluidTYPO3\Flux\Core::registerConfigurationProvider('FluidTYPO3\Fromage\Provider\FromageProvider');
