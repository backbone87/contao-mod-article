<?php

final class IncludeArticleUtils {
	
	public static function wrapNoIndex($strContent) {
		return strlen($strContent) ? '<!-- indexer::stop -->' . $strContent . '<!-- indexer::continue -->' : '';
	}
	
	public static function generateArticle($intArticleID, $blnNoSearch = false, $blnContainer = false, $strColumn = 'main', $arrCSS = null) {
		if($intArticleID < 1) {
			return '';
		}
			
		$objArticle = Database::getInstance()->prepare('
			SELECT	*,
					a.author AS authorId,
					(SELECT name FROM tl_user WHERE id = a.author) AS author
			FROM	tl_article AS a
			WHERE	a.id = ?
		')->limit(1)->execute(intval($intArticleID));
		
		if($objArticle->numRows < 1) {
			return '';
		}
		
		$objArticle = new ModuleArticle($objArticle, $strColumn);
		
		$arrCSS = deserialize($arrCSS, true);
		strlen($arrCSS[0]) || $arrCSS[0] = $objArticle->cssID[0];
		$arrCSS[1] = trim($arrCSS[1] . ' ' . $objArticle->cssID[1]);
		
		$objArticle->cssID = $arrCSS;
		$objArticle->headline = $objArticle->title;
		$objArticle->multiMode = false;//$blnMultiMode;
		
		$strArticle = $objArticle->generate(!$blnContainer);
		$blnNoSearch && $strArticle = self::wrapNoIndex($strArticle);
		
		return $strArticle;
	}
	
	public static function generateMultiArticles($arrArticles, $strColumn = 'main') {
		$arrArticles = deserialize($arrArticles, true);
		
		if(!$arrArticles) {
			return '';
		}
		
		$arrGenerated = array();
		
		foreach($arrArticles as $i => &$arrArticle) {
			$arrGenerated[$i] = self::generateArticle(
				$arrArticle['id'],
				$arrArticle['nosearch'],
				$arrArticle['container'],
				$strColumn,
				$arrArticle['cssID']
			);
		}
		
		return implode("\n", $arrGenerated);
	}

	public static function generatePageArticles($intPageID, $arrColumns, $blnNoSearch, $blnContainer, $strColumn = 'main', $arrCSS = null) {
		if($intPageID < 1) {
			return '';
		}
		
		$arrArgs = array_filter((array) $arrColumns);
		if(!$arrArgs) {
			return '';
		}
		
		array_unshift($arrArgs, intval($intPageID));
		
		$objArticleIDs = Database::getInstance()->prepare('
			SELECT	a.id
			FROM	tl_page AS p
			JOIN	tl_article AS a ON p.id = a.pid
			WHERE	p.id = ?
			AND		a.inColumn IN (' . implode(',', array_fill(0, count($arrArgs) - 1, '?')) . ')
			ORDER BY a.sorting
		')->execute($arrArgs);
		
		$arrGenerated = array();
		
		while($objArticleIDs->next()) {
			$arrGenerated[] = IncludeArticleUtils::generateArticle(
				$objArticleIDs->id,
				false,
				$blnContainer,
				$strColumn,
				$arrCSS
			);
		}
		
		$strArticles = implode("\n", $arrGenerated);
		$blnNoSearch && $strArticles = self::wrapNoIndex($strArticles);
		
		return $strArticles;
	}
	
	protected function __construct() {
	}
	
	protected function __clone() {
	}
	
}
