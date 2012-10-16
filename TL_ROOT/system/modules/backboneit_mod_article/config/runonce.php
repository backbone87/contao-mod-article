<?php

//echo "MOD_ARTICLE_RUNONCE";

try {
	
	$objDB = Database::getInstance();
	
	// renaming backboneit_mod_article_* columns into bbit_mod_art_*
	foreach(array('tl_module') as $strTable) {
		if($objDB->tableExists($strTable, null, true)) {
			continue;
		}
		
		$arrCreate = $objDB->query('SHOW CREATE TABLE `' . $strTable . '`')->row(true);
		$arrCreate = explode("\n", $arrCreate[1]);
		
		foreach($arrCreate as $strLine) {
			if(!preg_match('@^[^A-Za-z]*\`backboneit_mod_article_@', $strLine)) {
				continue;
			}
			
			$strLine = preg_replace('@(`backboneit_mod_article_([A-Za-z]+)`)@', '$1 `bbit_mod_art_$2`', $strLine, 1);
			$strLine = 'ALTER TABLE `' . $strTable . '` CHANGE COLUMN ' . rtrim($strLine, ',');
			//echo $strLine;
			$objDB->query($strLine);
		}
		
	}
	
	if($objDB->tableExists('tl_module', null, true)) {
		$objDB->query('
			UPDATE	`tl_module`
			SET		`type` = \'bbit_mod_art\'
			WHERE	`type` = \'backboneit_mod_article\'
		');
		$objDB->query('
			UPDATE	`tl_module`
			SET		`type` = \'bbit_mod_pageArt\'
			WHERE	`type` = \'backboneit_mod_pageArticles\'
		');
	}
	
	foreach(array('tl_content', 'tl_module') as $strTable) {
		if(!$objDB->tableExists($strTable, null, true)) {
			continue;
		}
		if(!$objDB->fieldExists('bbit_mod_art_multiContainer', $strTable, true)) {
			continue;
		}
		if(!$objDB->fieldExists('bbit_mod_art_multiTemplate', $strTable, true)) {
			$objDB->query('ALTER TABLE `' . $strTable . '` ADD `bbit_mod_art_multiTemplate` varchar(255) NOT NULL default \'\'');
		}
	  
		$objDB->query('
			UPDATE	`' . $strTable . '`
			SET		bbit_mod_art_multiTemplate = \'bbit_mod_art_multi_container\'
			WHERE	bbit_mod_art_multiTemplate = \'\'
			AND		bbit_mod_art_multiContainer = \'1\'
		');
	}

} catch(Exception $e) {
	var_dump($e->getMessage());
	var_dump($e->getFile());
	var_dump($e->getLine());
	var_dump($e->getTrace());
	exit;
}

//exit;
