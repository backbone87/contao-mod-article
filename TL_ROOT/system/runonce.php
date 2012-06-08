<?php

/**
 * PHP version 5
 * @copyright  Andreas Schempp 2011
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id: runonce.php 2367 2011-08-08 07:55:14Z aschempp $
 */

class UniversalRunonce extends Controller
{

	/**
	 * Initialize the object
	 */
	public function __construct()
	{
		parent::__construct();
		
		// Fix potential Exception on line 0 because of __destruct method (see http://dev.contao.org/issues/2236)
		$this->import((TL_MODE=='BE' ? 'BackendUser' : 'FrontendUser'), 'User');
		$this->import('Database');
	}


	/**
	 * Execute all runonce files in module config directories
	 */
	public function run()
	{
		$this->import('Files');
		$arrModules = scan(TL_ROOT . '/system/modules/');
		
		foreach ($arrModules as $strModule)
		{
			if ((@include(TL_ROOT . '/system/modules/' . $strModule . '/config/runonce.php')) !== false)
			{
				$this->Files->delete('system/modules/' . $strModule . '/config/runonce.php');
			}
		}
	}
}


/**
 * Instantiate controller
 */
if (version_compare(VERSION, '2.10', '<'))
{
	$objUniversalRunonce = new UniversalRunonce();
	$objUniversalRunonce->run();
}

