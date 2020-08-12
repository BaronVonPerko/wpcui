<?php

namespace PerkoCustomizerUI\Classes;

/**
 * Class CustomizerControl
 * @package PerkoCustomizerUI\Classes
 */
class CustomizerControl{
	public $id;
	public $label;
	public $type;
	public $choices;
	public $default;

	public function __construct($id, $label, $type, $default, $choices=null) {
		$this->id = $id;
		$this->label = $label;
		$this->type = $type;
		$this->default = $default;
		$this->choices = $choices;
	}
}