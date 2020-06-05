<?php

	namespace app;

	use Rain\Tpl;

	class Page {

		private $tpl;

		public function __construct()
		{
			$config = array(
			    "tpl_dir"       => __DIR__.'/../../views',
			    "cache_dir"     => __DIR__.'/../../views-cache',
			    "debug"         => false,
			);

			Tpl::configure($config);

			$this->tpl = new Tpl;
		}

		private function setArgs($args = array()){
			foreach ($args as $key => $value) {
				$this->tpl->assign($key, $value);
			}
		}

		public function setPage($pageHtml, $args = array()){
			$this->setArgs($args);

			$this->tpl->draw($pageHtml);
		}
	}

?>