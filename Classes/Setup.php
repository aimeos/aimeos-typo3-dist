<?php

/**
 * @license GPLv3, http://www.gnu.org/copyleft/gpl.html
 * @copyright Aimeos (aimeos.org), 2015
 * @package TYPO3_Aimeos
 */


namespace Aimeos\AimeosDist;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Backend\Utility\BackendUtility;


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

		$records = BackendUtility::getRecordsByField( 'pages', 'title', 'Basket' );

		foreach( $records as $record ) {
			$data .= 'tx_aimeos.basket.target = ' . intval( $record['uid'] ) . "\n";
		}

		$records = BackendUtility::getRecordsByField( 'pages', 'title', 'Users' );

		foreach( $records as $record ) {
			$data .= 'tx_aimeos.customer.pid = ' . intval( $record['uid'] ) . "\n";
		}

		$records = BackendUtility::getRecordsByField( 'pages', 'title', 'My account' );

		foreach( $records as $record ) {
			$data .= 'config.typolinkLinkAccessRestrictedPages = ' . intval( $record['uid'] ) . "\n";
		}

		GeneralUtility::writeFile( $filename, $data );
	}
}