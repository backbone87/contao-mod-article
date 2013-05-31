<?php

class ModuleIncludeMultiArticles extends Module {

	protected $strArticles;

	public function __construct(Database_Result $objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
	}

	public function generate() {
		$this->strTemplate = $this->bbit_mod_art_multiTemplate;
		if($this->strTemplate) {
			return parent::generate();
		} else {
			return IncludeArticleUtils::generateMultiArticles($this->bbit_mod_art_multi, $this->strColumn);
		}
	}

	protected function compile() {
		$this->Template->articles = deserialize($this->bbit_mod_art_multi, true);
		$this->Template->column = $this->strColumn;
	}

}
