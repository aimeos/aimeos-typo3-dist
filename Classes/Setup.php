<?php

/**
 * @license GPLv3, http://www.gnu.org/copyleft/gpl.html
 * @copyright Aimeos (aimeos.org), 2015
 * @package TYPO3_Aimeos
 */


namespace Aimeos\AimeosDist;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;


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
	 * @param string|null $extname Installed extension name
	 */
	public function process( $extname = null )
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
		$filename = dirname( __DIR__ ) . $ds . 'Configuration' . $ds . 'TypoScript' . $ds . 'constants.txt';
		$q = GeneralUtility::makeInstance( ConnectionPool::class )->getQueryBuilderForTable( 'pages' );

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Basket' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.basket.target = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'Users' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.customer.pid = ' . intval( $record['uid'] ) . "\n";
		}

		$expr = $q->expr()->eq( 'title', $q->createNamedParameter( 'My account' ) );
		$stmt = $q->select( 'uid' )->from( 'pages' )->where( $expr )->execute();

		while( $record = $stmt->fetch() ) {
			$data .= 'tx_aimeos.myaccount.target = ' . intval( $record['uid'] ) . "\n";
		}

		GeneralUtility::writeFile( $filename, $data );
	}
}