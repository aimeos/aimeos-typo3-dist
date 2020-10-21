<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('aimeos_dist', 'Configuration/TypoScript', 'Aimeos Distribution');


/**
 * Updates the required data
 */
if (TYPO3_MODE === 'BE')
{
	$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
	$signalSlotDispatcher->connect(
		'TYPO3\CMS\Extensionmanager\Utility\InstallUtility',
		'afterExtensionInstall', // @deprecated, use PSR Events in 11+
		'Aimeos\AimeosDist\EventListener\Setup',
		'process'
	);
}
