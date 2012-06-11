<?php

class ModuleIncludeMultiArticles extends Module {
	
	protected $strTemplate = 'mod_bbit_mod_art_multi';
	
	protected $strArticles;
	
	public function __construct(Database_Result $objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
	}
	
	public function generate() {
		$this->strArticles = IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi, $this->strColumn);
		if($this->bbit_mod_art_multiContainer) {
			return parent::generate();
		} else {
			return $this->strArticles;
		}
	}

	protected function compile() {
		$this->Template->articles = $this->strArticles;
	}
	
}
