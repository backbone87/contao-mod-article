<?php

class ContentIncludeMultiArticles extends ContentElement {
	
	protected $strArticles;
	
	public function __construct(Database_Result $objElement) {
		parent::__construct($objElement);
	}

	public function generate() {
		$this->strTemplate = $this->bbit_mod_art_multiTemplate;
		if($this->strTemplate) {
			return parent::generate();
		} else {
			return IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi);
		}
	}
	
	protected function compile() {
		$this->Template->articles = deserialize($this->bbit_mod_art_multi, true);
	}
	
}
