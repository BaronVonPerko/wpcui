<?php

namespace PerkoCustomizerUI\Classes;

class CustomizerSetting{
	public $id;
	public $default;

	public function __construct($id, $default) {
		$this->id = $id;
		$this->default = $default;
	}
}