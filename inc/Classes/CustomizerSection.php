<?php

namespace PerkoCustomizerUI\Classes;

/**
 * Class CustomizerSection
 * @package PerkoCustomizerUI\Classes
 */
class CustomizerSection{
	public $id;
	public $title;
	public $priority;
	public $controls = [];
	public $visible = true;

	public function __construct($id, $title, $priority, $controls, $visible = true) {
		$this->id = $id;
		$this->title = $title;
		$this->priority = $priority;
		$this->controls = $controls;
		$this->visible = $visible;
	}
}