<?php

namespace Inc\Classes;

class CustomizerControl{
	public $id;
	public $label;
	public $setting_id;
	public $type;

	public function __construct($id, $label, $setting_id, $type) {
		$this->id = $id;
		$this->label = $label;
		$this->setting_id = $setting_id;
		$this->type = $type;
	}
}