<?php

class ModuleIncludeArticle extends Module {

	public function generate() {
		return $this->getArticle($this->backboneit_mod_article_id, false, true);
	}


	protected function compile() {
		return;
	}
	
}
