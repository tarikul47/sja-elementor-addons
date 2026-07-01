<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Services_Hub_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-services-hub';
	}

	public function get_title() {
		return __( 'SJA Services Hub', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-grid-column';
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
				'default' => __( 'For Training Providers', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Professional Services for Training Providers', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text_1',
			[
				'label' => __( 'Intro Paragraph 1', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'SJA Global Academia is more than an online training provider. We are a trusted partner for organisations looking to establish, develop and grow successful education and training businesses across the UK and internationally.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text_2',
			[
				'label' => __( 'Intro Paragraph 2', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Our experienced team provides a comprehensive range of professional services to support colleges, training providers, businesses and educational organisations. Whether you are starting a new training centre or expanding an existing organisation, we can help you build strong foundations through expert guidance, quality assurance and innovative digital learning solutions.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'service_cards',
			[
				'label' => __( 'Service Cards', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'icon',
						'label' => __( 'Icon Character', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '⚑',
					],
					[
						'name' => 'title',
						'label' => __( 'Service Title', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Educational Centre Approval',
					],
					[
						'name' => 'description',
						'label' => __( 'Description', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => 'Guidance, policies and quality systems to achieve and maintain awarding-body approval.',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __( 'CTA Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Explore Our Services', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'cta_url',
			[
				'label' => __( 'CTA Button URL', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sja-elementor-addons' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="services" class="dark">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text_1'] ) ) : ?>
					<p class="lead" style="max-width: 800px;"><?php echo wp_kses_post( $settings['intro_text_1'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text_2'] ) ) : ?>
					<p class="lead" style="max-width: 800px;"><?php echo wp_kses_post( $settings['intro_text_2'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['service_cards'] ) ) : ?>
					<div class="services-grid">
						<?php foreach ( $settings['service_cards'] as $card ) : ?>
							<div class="svc">
								<div class="ico"><?php echo esc_html( $card['icon'] ); ?></div>
								<h4><?php echo esc_html( $card['title'] ); ?></h4>
								<p><?php echo wp_kses_post( $card['description'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['cta_label'] ) ) : ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url( is_array( $settings['cta_url'] ) ? ( $settings['cta_url']['url'] ?? '' ) : $settings['cta_url'] ); ?>" class="btn btn-purple">
							<?php echo esc_html( $settings['cta_label'] ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
