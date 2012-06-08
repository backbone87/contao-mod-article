<?php

class ModuleIncludeMultiArticles extends Module {

	public function __construct(Database_Result $objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
	}
	
	public function generate() {
		return IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi, $this->strColumn);
	}

	protected function compile() {
	}
	
}
