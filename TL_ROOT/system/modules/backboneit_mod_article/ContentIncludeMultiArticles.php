<?php

class ContentIncludeMultiArticles extends ContentElement {
	
	public function __construct(Database_Result $objElement) {
		parent::__construct($objElement);
	}

	public function generate() {
		return IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi);
	}
	
	protected function compile() {
	}
	
}
