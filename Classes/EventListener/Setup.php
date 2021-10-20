<?php

/**
 * @license GPLv3, http://www.gnu.org/copyleft/gpl.html
 * @copyright Aimeos (aimeos.org), 2015-2021
 * @package TYPO3_Aimeos
 */


namespace Aimeos\AimeosDist\EventListener;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extensionmanager\Event\AfterExtensionDatabaseContentHasBeenImportedEvent;


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
	 * @param AfterExtensionDatabaseContentHasBeenImportedEvent $event Event object
	 */
	public function __invoke( AfterExtensionDatabaseContentHasBeenImportedEvent $event ) : void
	{
error_log( __METHOD__ . ': ' . $event->getPackageKey() );
		if( $event->getPackageKey() === 'aimeos_dist' ) {
			$this->createTypoScriptConstants();
		}
	}


	/**
	 * Creates the TypoScript constants.txt file with necessary page IDs
	 */
	protected function createTypoScriptConstants()
	{
error_log( __METHOD__ );
		$data = '';
		$ds = DIRECTORY_SEPARATOR;
		$filename = dirname( __DIR__, 2 ) . $ds . 'Configuration' . $ds . 'TypoScript' . $ds . 'constants.txt';
		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'pages' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Basket' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();
error_log( 'title = Basket' );

		while( $record = $stmt->fetch() ) {
error_log( print_r( $record, true ) );
			$data .= 'tx_aimeos.basket.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Profile' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();
error_log( 'title = Profile' );

		while( $record = $stmt->fetch() ) {
error_log( print_r( $record, true ) );
			$data .= 'tx_aimeos.profile.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'jsonapi' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();
error_log( 'title = jsonapi' );

		while( $record = $stmt->fetch() ) {
error_log( print_r( $record, true ) );
			$data .= 'tx_aimeos.jsonapi.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Users' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();
error_log( 'title = Users' );

		while( $record = $stmt->fetch() ) {
error_log( print_r( $record, true ) );
			$data .= 'tx_aimeos.customer.pid = ' . intval( $record['uid'] ) . "\n";
		}

		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'fe_groups' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'customers' ) );
		$stmt = $q->select( 'uid' )->from( 'fe_groups' )->where( $expr )->execute();
error_log( 'title = customers' );

		while( $record = $stmt->fetch() ) {
error_log( print_r( $record, true ) );
			$data .= 'tx_aimeos.customer.groupid = ' . intval( $record['uid'] ) . "\n";
		}
error_log( $filename );
error_log( $data );

		GeneralUtility::writeFile( $filename, $data );
	}
}