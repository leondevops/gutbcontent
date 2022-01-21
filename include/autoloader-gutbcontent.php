<?php
/*
 * @package Devsunshine_Plugin
 * @version 1.0.1
 */


/* =========== Main methods ================  */
/* 1. Specify all resources directory here */
//$resourcesDir = dirname(__FILE__).'/inc/base'; // valid

$resourcesDirList = array();
/* It is important to specify the proper order of files included */
$resourcesDirList[] = dirname(__FILE__).'/Base'; // valid
$resourcesDirList[] = dirname(__FILE__).'/Api'; // valid
$resourcesDirList[] = dirname(__FILE__).'/Helper'; // valid
$resourcesDirList[] = dirname(__FILE__).'/Controller'; // valid
$resourcesDirList[] = dirname(__FILE__).'/Pages'; // valid

// 2021-Nov-11: For debug. levels = 2 ~ go up 1 level to outer directory
$resourcesDirList[] = dirname(__FILE__ , 2).'/troubleshoot'; // valid. Used to valid

/** 2. Iterate through all files in (1), then include all .php files ***/
foreach( $resourcesDirList as $resourcesDir ){
  //echo 'resource dir : '.$resourcesDir.PHP_EOL;
  $includedResources =  devsunshine_get_all_files_in_directory($resourcesDir);

  foreach($includedResources as $item){
    // Check if the suffix is .php file
    if(".php" == substr($item, -4)){
      // echo 'item included : '.$item.PHP_EOL;
      include($item);
    }
  }

}//foreach( $resourcesDirList as $resourcesDir )



/* =========== Helper methods ================  */


/** 1. List all files in a given directory .
 * - Files in the given directory
 * - Files given in a sub directory
 * * Referential recursive methods to obtain all files
 * https://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function/24784144
 *
 */
function devsunshine_get_all_files_in_directory($dir, &$results = array()){
  // $scannedResults = scandir($dir);

  if( is_dir($dir) ){
    $scannedResults = array_diff( scandir($dir) , array('.', '..') ); // Remove the default back directory
  } else {
    $scannedResults = array();
  }

  foreach($scannedResults as $item){
    //echo 'item : '.var_dump($item).PHP_EOL;
    $itemPath = realpath($dir.DIRECTORY_SEPARATOR.$item);
    // echo '$itemPath : '.var_dump($itemPath).PHP_EOL;

    // If not a directory
    if( !is_dir($itemPath) ){
      $results[] = $itemPath;
    }

    // If is directory
    if( ("." != $item) && (".." != $item) ){
      devsunshine_get_all_files_in_directory($itemPath, $results);
      // $results[] = $itemPath;
    }

  }// End foreach

  return $results;
}

/** Get all files & directories **/
function devsunshine_get_full_content_in_directory($dir, &$results = array()){

  // Scan results if it is a directory
  if( is_dir($dir) ){
    $scannedResults = array_diff( scandir($dir) , array('.', '..') ); // Remove the default back directory
  } else {
    $scannedResults = array();
  }

  foreach($scannedResults as $item){
    //echo 'item : '.var_dump($item).PHP_EOL;
    $itemPath = realpath($dir.DIRECTORY_SEPARATOR.$item);
    // echo '$itemPath : '.var_dump($itemPath).PHP_EOL;

    // If not a directory
    if( !is_dir($itemPath) ){
      $results[] = $itemPath;
    }

    // If is directory, then also include the directory without suffix
    if( ("." != $item) && (".." != $item) ){
      devsunshine_get_full_content_in_directory($itemPath, $results);
      $results[] = $itemPath;
    }

  }// End foreach

  return $results;
}


