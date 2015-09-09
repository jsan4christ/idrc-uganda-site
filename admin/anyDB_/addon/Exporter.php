<?php
////////////////////////////////////////////////////////////////////////

define ('ANYDB_DUMP_CSV', 1);
define ('ANYDB_DUMP_SQL', 2);

////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__) . '/../base/UtilityClass.php';

////////////////////////////////////////////////////////////////////////
/**
* Utility class for anyDB
*
* With this class you export db or table content 
*
* @link        http://lensphp.sourceforge.net for the latest version
* @author	   Lennart Groetzbach <lennartg[at]web.de>
* @copyright	Lennart Groetzbach <lennartg[at]web.de> - distributed under the LGPL
*
* @package      anydb
* @access       public
* @version      1.2 - 11/30/04
*
*/
////////////////////////////////////////////////////////////////////////

class Exporter extends UtilityClass {

	////////////////////////////////////////////////////////////////////////
	/*
    This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.
    
    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.
    
    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	*/
	////////////////////////////////////////////////////////////////////////
	/**
	* Returns the db data content
	*
	* @access   public
	*
	* @param    AbstractDB  $db                 db identifier
	* @param    Integer     $type               ANYDB_DUMP_ constants
	* @param    String      $seperator          for csv files
	*
	* @returns  Array       the table data
	*/
	function getDBDataDump(& $db, $type = ANYDB_DUMP_SQL, $seperator = "\t") {
    	$res = array();
    	$tables = $db->getTables();
    	if (@sizeof($tables) == 0) {
        	die('dumpDB(): No tables found...');
    	}
    	foreach ($tables as $table) {
        	$res[$table] = Exporter::getTableData($db, $table, $type, $seperator) . "\n";
    	}
    	return $res;
	}

	////////////////////////////////////////////////////////////////////////
	/**
	* Returns the data for one table
	*
	* @access   public
	*
	* @param    AbstractDB  $db                 db identifier
	* @param    String      $table              table name
	* @param    Integer     $type               ANYDB_DUMP_ constants
	* @param    String      $seperator          for csv files
	*
	* @returns  Array       the table data
	*/
	function getTableData(& $db, $table, $type = ANYDB_DUMP_SQL, $seperator = "\t") {
    	$res = '';
    	$first = true;
    	// get all the data
    	$query = "SELECT * FROM $table";
    	$db->query($query, ANYDB_RES_ASSOC);
    	while ($line = $db->getNext()) {
        	$line = $db->escapeStr($line);
        	switch ($type) {
            	case ANYDB_DUMP_SQL:
                	$res .= QueryHelper::insert($table, $line) . ";\n";
                	break;
            	case ANYDB_DUMP_CSV:
                	if ($first) {
                    	$res .= implode($seperator, array_keys($line))  . "\n";
                    	$first = false;
                	}
                	$res .= implode($seperator, $line) . "\n";
                	break;
            	}
    	}
    	return $res;
	}
 	 
    /**
	 * Methd to get the dump of the table structures only
	 * 
	 * @param array $tablearray
	 * @return array $results
	 */
	function dbStructure(& $db, $tablearray)
	{
		$results = array();
		foreach($tablearray as $table)
		{
			$db->changeTable($table);
			$filter = "SHOW CREATE table $table";
			$results[] = $db->execute($filter,ANYDB_RES_ASSOC);
		}
		return $results;
	}
	
	/**
	 * File writing methods
	 */
	
	/**
	 * Method to build the sql headers
	 * @param string $appname - the application name
	 * @param string $myurl - your app's url
	 * @return string headers
	 */
	function sqlfileHeaders($appname, $myurl)
	{
		//Build the sql file headers
		//disable FK checks
		$file = "SET FOREIGN_KEY_CHECKS = 0;";
		$file .=  "\n\n";
		$file .= "-- " . $appname . " Database SQL Dump \n";
		$file .= "-- Version 0.9 \n";
		$file .= "-- " . $myurl . " \n";
		$file .= "--  \n";
		$file .= "-- Generation Time: " . date('r') . "\n";
		$file .= "-- PHP Version: " . phpversion() . "\n";
		$file .= "-- -------------------------------------------------------- \n";
		$file .= "-- \n";
		$file .= "\n\n";
		return $file;
	}
	
	/**
	 * Method to output the structure of the db to a file
	 * @param array
	 * @return file
	 */
	function writeStructure($structarray)
	{
		//get the array
		$file = null;
		foreach($structarray as $structure)
		{
			$definition = $structure['Table'];
			$createTable = $structure['Create Table'];
			
			$file .= "-- \n";
			$file .= "-- \n";
			$file .= "-- Table definition for " . $definition . "\n";
			$file .= "-- \n";
			$file .= "-- \n";
			$file .= "\n\n";
			$file .= $createTable . ";\n";
			$file .= "\n\n";
		}
			
		return $file;
	}
	
	/**
	 * write the file to a .sql file
	 * file will live with the current timestamp in
	 * $backupPath . "/time().Structure.sql"
	 * @param array $input
	 * @return bool true on success
	 */
	function writeSQL($backupPath, $input)
	{
		/**
		 * write the file to a .sql file
		 * file will live with the current timestamp in
		 * $backupPath . "/time().Structure.sql"
		 */
		$filename = $backupPath . "/" . time() . "_dbdump.sql";
		touch($filename);
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename)) {
			if (!$handle = fopen($filename, 'w')) {
    		    return false;
         		exit;
   			}
   			if (fwrite($handle, $input) === FALSE) {
       			return false;
   				exit;
   			}
 		  // Success, wrote ($input) to file ($filename)
		   fclose($handle);
		   } else {
   				return false;
		   }
		   // return the filename for the user to find it again
		   return $filename;
 	}
	 
 	/**
 	 * Method to get the table structure only
 	 * and dump it to a filename
 	 * @param $appname - the applications name
 	 * @param mixed $myurl - your apps url
 	 * @param mixed $backupPath - the path to back file up to. 
 	 * 		  NOTE: This should be writeable by the webserver user
 	 * @return string to browser (ugh)
 	 */
 	function structureOnly(& $db, $appname = "eHMIS Backup", $myurl = "http://localhost", $backupPath)
 	{
 		 //get the tables as an array
         $tableNames = $db->getTables();
         //get the structure
         $struct = Exporter::dbStructure($db, $tableNames);
         //write the file headers
         $writefile = Exporter::sqlfileHeaders($appname, $myurl);
         //build the sql file
         foreach($struct as $output)
         {
            //print_r($output); 
         	$writefile .= Exporter::writeStructure($output);
         }
         Exporter::writeSQL($backupPath, $writefile);
         return "Structure file written to: " . $backupPath;
 	}
 	
 	/**
 	 * Method to do full backup of data and structure
 	 * @param 
 	 */
 	function dataAndStruct(& $db, $appname, $myurl, $backupPath)
 	{
 		//get the table names
        $tableNames = $db->getTables();
        //get the structure of the db
        $struct = Exporter::dbStructure($db, $tableNames);
        //build the headers bit
        $writefile = Exporter::sqlfileHeaders($appname, $myurl);
        //set the data variable to null
        $dataArray = null;
        //get the data
        $dataArray = Exporter::getDBDataDump($db, ANYDB_DUMP_SQL);
        //how many tables are there?
        $tblCount = count($tableNames);
        //pass the count and the arrays to the filebuilder function
        $dataFile = Exporter::writeData($dataArray);
        //build the writefile for the create table statements
        foreach($struct as $output)
        {
            $writefile .= Exporter::writeStructure($output);  
        }
        //put in a sql comment to start the table data
        $writefile .= "-- Table data... \n\n";
        //write table data to sql file
        $writefile .= $dataFile;
        $filename = Exporter::writeSQL($backupPath, $writefile);
        return $filename;
 	}
 	
 	/**
 	 * Method to du data dump only
 	 * @param    AbstractDB  $db                 db identifier
 	 * @param    appname						 application name
 	 * @param    myurl
 	 * @param    backupPath						 backup file storage location
 	 */
 	 function dataOnly(& $db, $appname = "eHMIS Backup", $myurl = "http://localhost", $backupPath)
 	 {
 	 	//write the file headers
         $writefile = Exporter::sqlfileHeaders($appname, $myurl);
 	 	//put in a sql comment to start the table data
        $writefile .= "-- Table data... \n\n";
        //set the data variable to null
        $dataArray = null;
        //get the data
        $dataArray = Exporter::getDBDataDump($db, ANYDB_DUMP_SQL);
        $writefile .= Exporter::writeData($dataArray);
        Exporter::writeSQL($backupPath, $writefile);
 	 }
	
 	/**
 	 * Method to do full db dump of tables
 	 * @param array $data
 	 * @return string $file
 	 */
 	function writeData($sqlData)
 	{
 		$sqlFile = '';
 		foreach($sqlData as $key => $data) {
    		$sqlFile .=  "--$key--";
    		$sqlFile .=  "\n\n";
    		$sqlFile .=  $data;
    		$sqlFile .=  "\n";
		}
 		return $sqlFile;
 	}		  		
////////////////////////////////////////////////////////////////////////
}
////////////////////////////////////////////////////////////////////////

?>
