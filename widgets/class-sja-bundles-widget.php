<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Bundles_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-bundles';
	}

	public function get_title() {
		return __( 'SJA Qualification Bundles', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-post-l-box';
	}

	public function get_categories() {
		return [ 'sja-widgets' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'sja-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => __( 'Eyebrow', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Qualification Bundles', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Save More with Qualification Bundles UK', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __( 'Intro Paragraph', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Combine related qualifications into one convenient package — a structured progression pathway with outstanding value. Enrol from just £50, study online and pay through interest-free instalments with no additional charges.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'benefits_heading',
			[
				'label' => __( 'Benefits Subheading', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Why Choose a Qualification Bundle?', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'benefits_list',
			[
				'label' => __( 'Benefits List', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __( 'Benefit Text', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Better value than 17 individual qualifications',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'primary_btn_label',
			[
				'label' => __( 'Primary Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Explore Qualification Bundles', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'primary_btn_url',
			[
				'label' => __( 'Primary Button URL', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'bundles_list_heading',
			[
				'label' => __( 'Bundles List Subheading', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Most Popular Bundles', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'bundles_list',
			[
				'label' => __( 'Bundle Items', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'name',
						'label' => __( 'Bundle Name', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Complete Teacher Training Pathway',
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="bundles" class="dark">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text'] ) ) : ?>
					<p class="lead"><?php echo wp_kses_post( $settings['intro_text'] ); ?></p>
				<?php endif; ?>

				<div class="bundles-grid">
					<div>
						<?php if ( ! empty( $settings['benefits_heading'] ) ) : ?>
							<h4 style="font-family:var(--font-display);color:#fff;font-size:22px;margin-bottom:14px"><?php echo esc_html( $settings['benefits_heading'] ); ?></h4>
						<?php endif; ?>

						<?php if ( ! empty( $settings['benefits_list'] ) ) : ?>
							<ul class="benefits">
								<?php foreach ( $settings['benefits_list'] as $benefit ) : ?>
									<li><?php echo esc_html( $benefit['text'] ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $settings['primary_btn_label'] ) ) : ?>
							<a href="<?php echo esc_url( is_array( $settings['primary_btn_url'] ) ? ( $settings['primary_btn_url']['url'] ?? '' ) : $settings['primary_btn_url'] ); ?>" class="btn btn-green">
								<?php echo esc_html( $settings['primary_btn_label'] ); ?>
							</a>
						<?php endif; ?>
					</div>

					<div class="bundles-list">
						<?php if ( ! empty( $settings['bundles_list_heading'] ) ) : ?>
							<h4><?php echo esc_html( $settings['bundles_list_heading'] ); ?></h4>
						<?php endif; ?>

						<?php if ( ! empty( $settings['bundles_list'] ) ) : ?>
							<?php foreach ( $settings['bundles_list'] as $index => $bundle ) : ?>
								<div class="item">
									<span class="n"><?php echo sprintf( '%02d', $index + 1 ); ?></span>
									<?php echo esc_html( $bundle['name'] ); ?>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
