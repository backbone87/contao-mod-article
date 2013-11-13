<?php

class ContentIncludePageArticles extends ContentElement {

	public function __construct($objElement) {
		parent::__construct($objElement);
	}

	public function generate() {
		return IncludeArticleUtils::generatePageArticles(
			$this->getPage(),
			deserialize($this->bbit_mod_art_columns),
			$this->bbit_mod_art_nosearch,
			$this->bbit_mod_art_container,
			'main',
			$this->cssID
		);
	}

	protected function compile() {
	}

	public function getPage() {
		return $this->bbit_mod_art_page;
	}

}
