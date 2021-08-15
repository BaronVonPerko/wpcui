<?php

namespace PerkoCustomizerUI\Classes;

use PerkoCustomizerUI\Data\DataService;

/**
 * Class CustomizerSection
 * @package PerkoCustomizerUI\Classes
 */
class CustomizerSection {
	public $id;
	public $title;
	public $priority;
	public $controls = [];
	public $visible = true;

	public function __construct( $title, $priority, $controls = [], $visible = true ) {
		$this->id       = DataService::convertStringToId( $title );
		$this->title    = $title;
		$this->priority = $priority;
		$this->controls = $controls;
		$this->visible  = $visible;
	}
}