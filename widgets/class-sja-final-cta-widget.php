<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Final_CTA_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-final-cta';
	}

	public function get_title() {
		return __( 'SJA Final CTA', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-button';
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
				'default' => __( 'Get Started', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Start Your Professional Journey Today', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'body_text',
			[
				'label' => __( 'Body Paragraph', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( "Whether you're starting a new career, gaining recognised professional qualifications, or developing your organisation through expert consultancy services — SJA Global Academia is here to support your success. Join learners and training providers who trust us for high-quality education, flexible online learning and affordable professional qualifications.", 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'highlight_text',
			[
				'label' => __( 'Highlighted Line', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Study recognised qualifications. Build your career. Develop your future.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'tag_pills',
			[
				'label' => __( 'Tag Pills', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __( 'Text', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '✓ Focus Awards Approved',
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
				'default' => __( 'Explore Our Courses', 'sja-elementor-addons' ),
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
			'secondary_btn_label',
			[
				'label' => __( 'Secondary Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Contact Our Team', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'secondary_btn_url',
			[
				'label' => __( 'Secondary Button URL', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sja-elementor-addons' ),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="final" class="final-cta">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow" style="color:var(--green)"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['body_text'] ) ) : ?>
					<p style="color:#d6dcef;max-width:720px;margin:0 auto;font-size:17px"><?php echo wp_kses_post( $settings['body_text'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['highlight_text'] ) ) : ?>
					<p style="color:var(--green);font-weight:700;margin-top:14px;font-size:18px"><?php echo esc_html( $settings['highlight_text'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $settings['tag_pills'] ) ) : ?>
					<div class="tag-list">
						<?php foreach ( $settings['tag_pills'] as $pill ) : ?>
							<span><?php echo esc_html( $pill['text'] ); ?></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="ctas">
					<?php if ( ! empty( $settings['primary_btn_label'] ) ) : ?>
						<a href="<?php echo esc_url( is_array( $settings['primary_btn_url'] ) ? ( $settings['primary_btn_url']['url'] ?? '' ) : $settings['primary_btn_url'] ); ?>" class="btn btn-green">
							<?php echo esc_html( $settings['primary_btn_label'] ); ?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $settings['secondary_btn_label'] ) ) : ?>
						<a href="<?php echo esc_url( is_array( $settings['secondary_btn_url'] ) ? ( $settings['secondary_btn_url']['url'] ?? '' ) : $settings['secondary_btn_url'] ); ?>" class="btn btn-outline">
							<?php echo esc_html( $settings['secondary_btn_label'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
