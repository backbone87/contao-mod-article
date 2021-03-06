<?php

class ModuleIncludePageArticles extends Module {

	public function __construct($objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
	}

	public function generate() {
		return IncludeArticleUtils::generatePageArticles(
			$this->getPage(),
			$this->bbit_mod_art_setColumns
				? deserialize($this->bbit_mod_art_columns)
				: $this->strColumn,
			$this->bbit_mod_art_nosearch,
			$this->bbit_mod_art_container,
			$this->strColumn,
			$this->cssID
		);
	}

	protected function compile() {
	}

	public function getPage() {
		return $this->bbit_mod_art_page;
	}

}
