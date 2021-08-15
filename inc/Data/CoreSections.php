<?php

namespace PerkoCustomizerUI\Data;

use PerkoCustomizerUI\Classes\CustomizerSection;

/**
 * Class CoreSections
 * @package PerkoCustomizerUI\Data
 */
class CoreSections {

	/**
	 * Get all of the core sections.
	 *
	 * @return CustomizerSection[]
	 */
	public static function get() {
		$siteIdentity     = new CustomizerSection( "Site Identity (core)", 20 );
		$siteIdentity->id = "title_tagline";

		$colors     = new CustomizerSection( "Colors (core)", 40 );
		$colors->id = "colors";

		$headerImage     = new CustomizerSection( "Header Image (core)", 60 );
		$headerImage->id = "header_image";

		$backgroundImage     = new CustomizerSection( "Background Image (core)", 80 );
		$backgroundImage->id = "background_image";

		$homepageSettings     = new CustomizerSection( "Homepage Settings (core)", 100 );
		$homepageSettings->id = "static_front_page";

		$additionalCss     = new CustomizerSection( "Additional CSS (core)", 200 );
		$additionalCss->id = "custom_css";

		return [ $siteIdentity, $colors, $headerImage, $backgroundImage, $homepageSettings, $additionalCss ];
	}

}