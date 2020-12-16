<?php

/**
 * @license GPLv3, http://www.gnu.org/copyleft/gpl.html
 * @copyright Aimeos (aimeos.org), 2015-2020
 * @package TYPO3_Aimeos
 */


namespace Aimeos\AimeosDist\EventListener;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extensionmanager\Event\AfterExtensionFilesHaveBeenImportedEvent;


/**
 * Aimeos distribution setup class.
 *
 * @package TYPO3_Aimeos
 */
class Setup
{
	/**
	 * Executes the setup tasks if extension is installed.
	 *
	 * @param AfterExtensionFilesHaveBeenImportedEvent $event Event object
	 */
	public function __invoke( AfterExtensionFilesHaveBeenImportedEvent $event ) : void
	{
		if( $event->getPackageKey() !== 'aimeos_dist' ) {
			return;
		}

		// $this->createTypoScriptConstants();
	}


	/**
	 * Executes the setup tasks if extension is installed.
	 *
	 * @param string|null $extname Installed extension name
	 */
	public function process( string $extname = null )
	{
		if( $extname !== 'aimeos_dist' ) {
			return;
		}

		$this->createTypoScriptConstants();
	}


	/**
	 * Creates the TypoScript constants.txt file with necessary page IDs
	 */
	protected function createTypoScriptConstants()
	{
		$data = '';
		$ds = DIRECTORY_SEPARATOR;
		$filename = dirname( __DIR__, 2 ) . $ds . 'Configuration' . $ds . 'TypoScript' . $ds . 'constants.txt';
		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'pages' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Basket' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.basket.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Profile' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.profile.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'jsonapi' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.jsonapi.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Users' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.customer.pid = ' . intval( $record['uid'] ) . "\n";
		}

		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'fe_groups' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'customers' ) );
		$stmt = $q->select( 'uid' )->from( 'fe_groups' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.customer.groupid = ' . intval( $record['uid'] ) . "\n";
		}

		GeneralUtility::writeFile( $filename, $data );
	}
}