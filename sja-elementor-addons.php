<?php
/**
 * Plugin Name: SJA Elementor Addons
 * Description: Custom Elementor widgets for SJA Global Academia.
 * Version: 1.0.0
 * Author: Claude
 * Text Domain: sja-elementor-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class SJA_Elementor_Addons {

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		// Ensure Elementor is installed and active
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Register Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

		// Register Widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Enqueue Assets
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	public function add_category( $categories ) {
		\Elementor\Plugin::$instance->elements_manager->add_category(
			'sja-widgets',
			[
				'title' => 'SJA Global Academia',
				'icon' => 'fa fa-graduation-cap'
			],
			1
		);
	}

	public function enqueue_assets() {
		wp_enqueue_style(
			'sja-addons-style',
			plugins_url( 'assets/style.css', __FILE__ ),
			[],
			'1.0.0'
		);

		wp_enqueue_script(
			'sja-addons-script',
			plugins_url( 'assets/script.js', __FILE__ ),
			[],
			'1.0.0',
			true
		);
	}

	public function register_widgets( $widgets_manager ) {
		$widgets = [
			'widgets/class-sja-why-choose-widget.php',
			'widgets/class-sja-faq-widget.php',
			'widgets/class-sja-testimonials-widget.php',
			'widgets/class-sja-university-topup-widget.php',
			'widgets/class-sja-about-stats-widget.php',
			'widgets/class-sja-final-cta-widget.php',
			'widgets/class-sja-services-hub-widget.php',
			'widgets/class-sja-course-categories-widget.php',
			'widgets/class-sja-featured-courses-widget.php',
			'widgets/class-sja-bundles-widget.php',
			'widgets/class-sja-qualification-bundles-widget.php',
			'widgets/class-sja-save-bundles-widget.php',
			'widgets/class-sja-payment-plan-widget.php',
			'widgets/class-sja-split-content-widget.php',
			'widgets/class-sja-centre-approval-widget.php',
			'widgets/class-sja-qtls-widget.php',
			'widgets/class-sja-hero-widget.php',
		];

		foreach ( $widgets as $widget_file ) {
			$path = plugin_dir_path( __FILE__ ) . $widget_file;
			if ( file_exists( $path ) ) {
				require_once $path;

				// Assuming the class name is SJA_{WidgetName}
				// We need to derive the class name from the filename
				$class_name = $this->get_class_name_from_path( $widget_file );
				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}
	}

	private function get_class_name_from_path( $path ) {
		$filename = basename( $path ); // e.g. class-sja-why-choose-widget.php
		$class_name = str_replace( [ 'class-', '.php' ], '', $filename ); // sja-why-choose-widget

		// Convert kebab-case to PascalCase for the class name
		// e.g. sja-why-choose-widget -> SJA_Why_Choose_Widget
		$parts = explode( '-', $class_name );
		$pascal_parts = array_map( function( $part ) {
			return ucfirst( $part );
		}, $parts );

		// Special case for SJA
		if ( ! empty( $pascal_parts[0] ) ) {
			$pascal_parts[0] = 'SJA';
		}

		return implode( '_', $pascal_parts );
	}
}

SJA_Elementor_Addons::get_instance();
