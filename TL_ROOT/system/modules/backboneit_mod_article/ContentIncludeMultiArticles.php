<?php

class ContentIncludeMultiArticles extends ContentElement {
	
	protected $strTemplate = 'ce_bbit_mod_art_multi';
	
	protected $strArticles;
	
	public function __construct(Database_Result $objElement) {
		parent::__construct($objElement);
	}

	public function generate() {
		$this->strArticles = IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi);
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
