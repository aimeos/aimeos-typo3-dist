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
		if( $event->getPackageKey() === 'aimeos_dist' ) {
			$this->createTypoScriptConstants();
		}
	}


	/**
	 * Creates the TypoScript constants with necessary page IDs
	 */
	protected function createTypoScriptConstants()
	{
		$data = '';
		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'pages' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'My Shop' ) );
		$pid = $q->select( 'uid' )->from( 'pages' )->where( $expr )->executeQuery()->fetchOne();

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Basket' ) );
		$uid = $q->select( 'uid' )->from( 'pages' )->where( $expr )->executeQuery()->fetchOne();
		$data .= 'tx_aimeos.basket.target = ' . intval( $uid ) . "\n";

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Profile' ) );
		$uid = $q->select( 'uid' )->from( 'pages' )->where( $expr )->executeQuery()->fetchOne();
		$data .= 'tx_aimeos.profile.target = ' . intval( $uid ) . "\n";

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'jsonapi' ) );
		$uid = $q->select( 'uid' )->from( 'pages' )->where( $expr )->executeQuery()->fetchOne();
		$data .= 'tx_aimeos.jsonapi.target = ' . intval( $uid ) . "\n";

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Users' ) );
		$uid = $q->select( 'uid' )->from( 'pages' )->where( $expr )->executeQuery()->fetchOne();
		$data .= 'tx_aimeos.customer.pid = ' . intval( $uid ) . "\n";


		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'fe_groups' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'customers' ) );
		$uid = $q->select( 'uid' )->from( 'fe_groups' )->where( $expr )->executeQuery()->fetchOne();
		$data .= 'tx_aimeos.customer.groupid = ' . intval( $uid ) . "\n";


		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'sys_template' );

		$expr = $q->expr()->eq( 'pid', $q->createNamedParameter( $pid ) );
		$constants = $q->select( 'constants' )->from( 'sys_template' )->where( $expr )->execute()->fetchOne();

		$q->update( 'sys_template' )
			->where( $q->expr()->eq( 'pid', $q->createNamedParameter( $pid ) ) )
			->set( 'constants', $constants . "\n" . $data )
			->executeStatement();
	}
}