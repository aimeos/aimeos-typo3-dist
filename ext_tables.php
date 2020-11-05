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

	/**
	 * Execute the Aimeos setup tasks automatically to create the required tables
	 */
	$signalSlotDispatcher->connect(
		'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
		'hasInstalledExtensions', // @deprecated, use "afterExtensionInstall" in TYPO3 10+ and PSR Events in 11+
		'Aimeos\\Aimeos\\Setup',
		'signal'
	);
	$signalSlotDispatcher->connect(
		'TYPO3\CMS\Extensionmanager\Utility\InstallUtility',
		'afterExtensionInstall', // @deprecated, use PSR Events in 11+
		'Aimeos\\Aimeos\\Setup',
		'signal'
	);
}
