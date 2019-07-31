<?php

namespace Inc\Classes;

class CustomizerControl{
	public $id;
	public $label;
	public $setting_id;
	public $type;
	public $choices;

	public function __construct($id, $label, $setting_id, $type, $choices=null) {
		$this->id = $id;
		$this->label = $label;
		$this->setting_id = $setting_id;
		$this->type = $type;
		$this->choices = $choices;
	}
}