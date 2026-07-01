<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_QTLS_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-qtls';
	}

	public function get_title() {
		return __( 'SJA QTLS Support', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-badge';
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
				'default' => __( 'QTLS Support', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'QTLS Application Support', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'body_text_1',
			[
				'label' => __( 'Body Paragraph 1', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'For many education professionals, achieving the Level 5 Diploma in Teaching (Further Education and Skills) is an important milestone towards professional recognition. At SJA Global Academia, our support does not end when your qualification is completed.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'body_text_2',
			[
				'label' => __( 'Body Paragraph 2', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Eligible learners who complete the Level 5 Diploma in Teaching (FE & Skills) can receive guidance with the Qualified Teacher Learning and Skills (QTLS) application process — helping you prepare your application with confidence.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'highlight_word',
			[
				'label' => __( 'Highlight Word', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'not end', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'seal_top',
			[
				'label' => __( 'Seal Top Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'QTLS',
			]
		);

		$this->add_control(
			'seal_icon',
			[
				'label' => __( 'Seal Icon', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '★',
			]
		);

		$this->add_control(
			'seal_bottom',
			[
				'label' => __( 'Seal Bottom Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'SUPPORTED',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __( 'CTA Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Learn About QTLS Support', 'sja-elementor-addons' ),
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

		// Handle highlight word replacement
		$text_1 = $settings['body_text_1'];
		if ( ! empty( $settings['highlight_word'] ) ) {
			$text_1 = str_replace(
				$settings['highlight_word'],
				'<strong style="color:var(--purple)">' . esc_html( $settings['highlight_word'] ) . '</strong>',
				$text_1
			);
		}
		?>
		<section id="qtls">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<div class="qtls-card">
					<div>
						<?php if ( ! empty( $text_1 ) ) : ?>
							<p style="color:#475275;margin-bottom:16px"><?php echo wp_kses_post( $text_1 ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['body_text_2'] ) ) : ?>
							<p style="color:#475275;margin-bottom:24px"><?php echo wp_kses_post( $settings['body_text_2'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $settings['cta_label'] ) ) : ?>
							<a href="<?php echo esc_url( is_array( $settings['cta_url'] ) ? ( $settings['cta_url']['url'] ?? '' ) : $settings['cta_url'] ); ?>" class="btn btn-purple">
								<?php echo esc_html( $settings['cta_label'] ); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class="seal">
						<div>
							<div class="l"><?php echo esc_html( $settings['seal_top'] ); ?></div>
							<div class="b"><?php echo esc_html( $settings['seal_icon'] ); ?></div>
							<div style="font-size:11px;margin-top:6px"><?php echo esc_html( $settings['seal_bottom'] ); ?></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
