<?php

class ModuleIncludeArticle extends Module {

	public function generate() {
		
		if($this->backboneit_mod_article_id < 1)
			return '';

		$this->import('Database');
		$objArticle = $this->Database->prepare('
			SELECT	*,
					a.author AS authorId,
					(SELECT name FROM tl_user WHERE id = a.author) AS author
			FROM	tl_article AS a
			WHERE	a.id = ?
		')->limit(1)->execute($this->backboneit_mod_article_id);

		if($objArticle->numRows < 1)
			return '';

		$objArticle->headline = $objArticle->title;
		$objArticle->multiMode = $blnMultiMode;

		$objArticle = new ModuleArticle($objArticle, $strColumn);
		$strArticle = $objArticle->generate(!$this->backboneit_mod_article_container);
		
		return $this->backboneit_mod_article_nosearch
			? '<!-- indexer::stop -->' . $strArticle . '<!-- indexer::continue -->'
			: $strArticle;
	}

	protected function compile() {
	}
	
}
