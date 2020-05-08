<?php

namespace PerkoCustomizerUI\Classes;

class CustomizerControl{
	public $id;
	public $label;
	public $setting_id;
	public $section_id;
	public $type;
	public $choices;
	public $default;

	public function __construct($id, $label, $setting_id, $section_id, $type, $default, $choices=null) {
		$this->id = $id;
		$this->label = $label;
		$this->setting_id = $setting_id;
		$this->section_id = $section_id;
		$this->type = $type;
		$this->default = $default;
		$this->choices = $choices;
	}
}