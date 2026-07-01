<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_About_Stats_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-about-stats';
	}

	public function get_title() {
		return __( 'SJA About Stats', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-info-circle';
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
				'default' => __( 'About Us', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'About SJA Global Academia', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __( 'Intro Paragraph', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'SJA Global Academia is committed to making professional education accessible through high-quality training, affordable qualifications and flexible online learning. As a Focus Awards Approved Training Provider, we deliver recognised qualifications across teacher training, assessment and quality assurance, business management, teaching assistance, functional skills and health and social care.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'quote_text',
			[
				'label' => __( 'Quote Text', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Quality education should be available to everyone.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'stat_items',
			[
				'label' => __( 'Stat Items', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'number',
						'label' => __( 'Stat Number', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '17',
					],
					[
						'name' => 'label',
						'label' => __( 'Stat Label', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Qualifications',
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __( 'CTA Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Start Your Learning Journey Today', 'sja-elementor-addons' ),
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
		<section id="about" class="dark">
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

				<?php if ( ! empty( $settings['quote_text'] ) ) : ?>
					<p class="lead" style="color:var(--green);font-weight:700;font-size:20px;font-style:italic">
						"<?php echo esc_html( $settings['quote_text'] ); ?>"
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['stat_items'] ) ) : ?>
					<div class="about-stats">
						<?php foreach ( $settings['stat_items'] as $stat ) : ?>
							<div class="stat">
								<div class="n"><?php echo esc_html( $stat['number'] ); ?></div>
								<div class="l"><?php echo esc_html( $stat['label'] ); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['cta_label'] ) ) : ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url( is_array( $settings['cta_url'] ) ? ( $settings['cta_url']['url'] ?? '' ) : $settings['cta_url'] ); ?>" class="btn btn-green">
							<?php echo esc_html( $settings['cta_label'] ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
