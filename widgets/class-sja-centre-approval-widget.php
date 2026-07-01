<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Centre_Approval_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-centre-approval';
	}

	public function get_title() {
		return __( 'SJA Centre Approval', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-checklist';
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
				'default' => __( 'Centre Approval Support', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Educational Centre Approval Support', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __( 'Intro Paragraph', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Establishing a successful training organisation requires careful planning, robust quality systems and full compliance. We guide new and existing providers through documentation, policies, quality assurance and learner management — building strong operational foundations for long-term success.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'feature_items',
			[
				'label' => __( 'Feature List Items', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __( 'Item Text', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Centre approval guidance',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __( 'CTA Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Speak to Our Consultancy Team', 'sja-elementor-addons' ),
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
		<section id="approval" class="dark">
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

				<?php if ( ! empty( $settings['feature_items'] ) ) : ?>
					<ul class="feature-grid" style="max-width:900px">
						<?php foreach ( $settings['feature_items'] as $item ) : ?>
							<li class="feature-grid-item"><?php echo esc_html( $item['text'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ! empty( $settings['cta_label'] ) ) : ?>
					<div style="margin-top:30px">
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
