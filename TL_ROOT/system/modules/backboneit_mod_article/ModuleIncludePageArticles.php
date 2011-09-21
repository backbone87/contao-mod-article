<?php

class ModuleIncludePageArticles extends ModuleIncludeArticle {
	
	public function generate() {
		$strArticles = $this->generateArticles(
			$this->backboneit_mod_article_page,
			$this->backboneit_mod_article_setColumns
				? deserialize($this->backboneit_mod_article_columns)
				: $this->strColumn,
			$this->backboneit_mod_article_container
		);
		
		$this->backboneit_mod_article_nosearch && $strArticles = $this->wrapNoIndex($strArticles);
		
		return $strArticles;
	}
	
	protected function generateArticles($intPageID, $arrColumns, $blnContainer) {
		if($intPageID < 1)
			return '';
		
		$arrArgs = array_filter((array) $arrColumns);
		if(!$arrArgs)
			return '';
		
		array_unshift($arrArgs, intval($intPageID));
		
		$arrArticleIDs = $this->Database->prepare('
			SELECT	a.id
			FROM	tl_page AS p
			JOIN	tl_article AS a ON p.id = a.pid
			WHERE	p.id = ?
			AND		a.inColumn IN (' . implode(',', array_fill(0, count($arrArgs) - 1, '?')) . ')
			ORDER BY a.sorting
		')->execute($arrArgs)->fetchEach('id');
		
		return $arrArticleIDs
			? implode("\n", array_map(
				array($this, 'generateArticle'),
				$arrArticleIDs,
				array_fill(0, count($arrArticleIDs), $blnContainer)
			))
			: '';
	}
	
}
