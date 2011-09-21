<?php

class ModuleIncludeArticle extends Module {
	
	public function __construct(Database_Result $objModule, $strColumn = 'main') {
		parent::__construct($objModule, $strColumn);
		$this->import('Database');
	}

	public function generate() {
		
		$strArticle = $this->generateArticle(
			$this->backboneit_mod_article_id,
			$this->backboneit_mod_article_container
		);

		$this->backboneit_mod_article_nosearch && $strArticle = $this->wrapNoIndex($strArticle);
		
		return $strArticle;
	}

	protected function compile() {
	}
	
	protected function wrapNoIndex($strContent) {
		return strlen($strContent) ? '<!-- indexer::stop -->' . $strContent . '<!-- indexer::continue -->' : '';
	}
	
	protected function generateArticle($intArticleID, $blnContainer = false) {
		if($intArticleID < 1)
			return '';
			
		$objArticle = $this->Database->prepare('
			SELECT	*,
					a.author AS authorId,
					(SELECT name FROM tl_user WHERE id = a.author) AS author
			FROM	tl_article AS a
			WHERE	a.id = ?
		')->limit(1)->execute(intval($intArticleID));
		
		if($objArticle->numRows < 1)
			return '';
			
		$objArticle->headline = $objArticle->title;
		$objArticle->multiMode = false;//$blnMultiMode;

		$objArticle = new ModuleArticle($objArticle, $this->strColumn);
		return $objArticle->generate(!$blnContainer);
	}
	
}
