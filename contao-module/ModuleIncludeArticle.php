<?php

class ModuleIncludeArticle extends Module {

	public function __construct($objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
	}

	public function generate() {
		return IncludeArticleUtils::generateArticle(
			$this->bbit_mod_art_id,
			$this->bbit_mod_art_nosearch,
			$this->bbit_mod_art_container,
			$this->strColumn,
			$this->cssID
		);
	}

	protected function compile() {
	}

}
