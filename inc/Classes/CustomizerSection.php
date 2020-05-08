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

	public function __construct($id, $title, $priority, $controls) {
		$this->id = $id;
		$this->title = $title;
		$this->priority = $priority;
		$this->controls = $controls;
	}
}