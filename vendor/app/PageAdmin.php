<?php

	namespace app;

	use Rain\Tpl;

	class PageAdmin{

		private $tpl;

		public function __construct($headerArgs = array())
		{
			$config = array(
			    "tpl_dir"       => __DIR__.'/../../views',
			    "cache_dir"     => __DIR__.'/../../views-cache',
			    "debug"         => false,
			);

			Tpl::configure($config);

			$this->tpl = new Tpl;

			$this->setPage('header', $headerArgs);
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
		
		public function __destruct()
		{
			$this->setPage('footer');
		}
	}

?>