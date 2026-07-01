<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Why_Choose_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-why-choose';
	}

	public function get_title() {
		return __( 'SJA Why Choose', 'sja-elementor-addons' );
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
				'default' => __( 'Why SJA Global Academia', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Quality, Affordability & Flexibility — in One Place', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text_1',
			[
				'label' => __( 'Intro Paragraph 1', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Choosing the right training provider is an important step towards achieving your professional goals. At SJA Global Academia, we combine quality, affordability and flexibility to provide a learning experience that supports individuals, employers and training providers alike.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text_2',
			[
				'label' => __( 'Intro Paragraph 2', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Our mission is simple—to make recognised qualifications accessible without compromising quality. We believe professional education should be affordable, flexible and designed around your lifestyle.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'feature_cards',
			[
				'label' => __( 'Feature Cards', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'icon',
						'label' => __( 'Icon Character', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '✓',
					],
					[
						'name' => 'title',
						'label' => __( 'Card Title', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Feature Title', 'sja-elementor-addons' ),
					],
					[
						'name' => 'description',
						'label' => __( 'Card Description', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __( 'Feature description goes here.', 'sja-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="why">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text_1'] ) ) : ?>
					<p class="lead"><?php echo wp_kses_post( $settings['intro_text_1'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text_2'] ) ) : ?>
					<p class="lead"><?php echo wp_kses_post( $settings['intro_text_2'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['feature_cards'] ) ) : ?>
					<div class="why-grid">
						<?php foreach ( $settings['feature_cards'] as $card ) : ?>
							<div class="why-card reveal">
								<div class="ico"><?php echo esc_html( $card['icon'] ); ?></div>
								<h3><?php echo esc_html( $card['title'] ); ?></h3>
								<p><?php echo wp_kses_post( $card['description'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
