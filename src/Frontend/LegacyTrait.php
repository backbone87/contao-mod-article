<?php

namespace BackboneIT\Contao\Article\Frontend;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 * @deprecated
 */
trait LegacyTrait {

	/**
	 * @return void
	 */
	protected function compile() {
		if(0 !== strpos($this->strTemplate, 'bbit_mod_art_multi_')) {
			return;
		}

		$this->Template->articles = self::convertReferencesToArticles($this->hofff_content_references);
	}

	/**
	 * @param array $references
	 * @return array
	 */
	public static function convertReferencesToArticles($references) {
		$references = deserialize($references, true);
		$articles = [];

		foreach($references as $reference) {
			list($type, $id) = explode('.', $reference['_key'], 2);

			if($type != 'article') {
				continue;
			}

			$article = [];
			$article['id'] = $id;
			$article['cssID'] = [ $reference['css_id'], $reference['css_classes'] ];
			$article['nosearch'] = $reference['exclude_from_search'];
			$article['container'] = $reference['render_container'];

			$articles[] = $article;
		}

		return $articles;
	}

}
