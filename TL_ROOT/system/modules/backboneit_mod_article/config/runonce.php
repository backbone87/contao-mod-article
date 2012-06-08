<?php

$objDB = Database::getInstance();

//echo "MOD_ARTICLE_RUNONCE";

// renaming backboneit_mod_article_* columns into bbit_mod_art_*
foreach(array('tl_module') as $strTable) {
	if(!$objDB->tableExists($strTable)) {
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

if($objDB->tableExists('tl_module')) {
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

//exit;
