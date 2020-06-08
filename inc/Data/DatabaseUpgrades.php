<?php

namespace PerkoCustomizerUI\Data;

use PerkoCustomizerUI\Classes\CustomizerControl;
use PerkoCustomizerUI\Classes\CustomizerSection;

class DatabaseUpgrades {

	private $currentVersion;

	public function register() {
		add_action( 'plugins_loaded', [ $this, 'upgradeDatabase' ] );
	}

	public function upgradeDatabase() {
		$this->currentVersion = DataService::getDatabaseVersion();

		switch ( $this->currentVersion ) {
			case null:
				$this->upgradeToVersion1();
				break;
		}

	}

	private function upgradeToVersion1() {
		$settings = DataService::getSettings();

		/**
		 * Convert section keys into the section ids, and update
		 * the keys to match the CustomizerSection class.
		 * Also, update the controls to match the CustomizerControl class.
		 */
		$sections = $settings['sections'];

		$settings['sections'] = [];

		foreach ( $sections as $key => $section ) {
			$id = DataService::convertStringToId( $section['section_title'] );

			$updatedControls = [];

			foreach ( $section['controls'] as $control ) {
				$controlId = DataService::convertStringToId( $control['control_label'] );

				$updatedControls[ $controlId ] = new CustomizerControl(
					$controlId,
					$control['control_label'],
					$control['control_type'],
					$control['control_default'],
					$control['control_choices']
				);
			}

			$updatedSection = new CustomizerSection(
				$id,
				$section['section_title'],
				$section['priority'],
				$updatedControls,
				$section['visible']
			);

			$settings['sections'][ $id ] = $updatedSection;
		}

		/**
		 * set the database version
		 */
		$settings['db_version'] = 1;

		DataService::setSettings( $settings );
	}

}