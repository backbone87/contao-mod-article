<?php

class ModuleIncludeArticle extends Module {

	public function generate() {
		$strArticle = $this->getArticle($this->backboneit_mod_article_id, false, true);
		
		return $this->backboneit_mod_article_nosearch
			? '<!-- indexer::stop -->' . $strArticle . '<!-- indexer::continue -->'
			: $strArticle;
	}

	protected function compile() {
		return;
	}
	
}
