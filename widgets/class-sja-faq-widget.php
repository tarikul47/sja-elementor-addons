<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_FAQ_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-faq';
	}

	public function get_title() {
		return __( 'SJA FAQ', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-faq';
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
				'default' => __( 'FAQ', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Frequently Asked Questions', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'faq_items',
			[
				'label' => __( 'FAQ Items', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'question',
						'label' => __( 'Question', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Question here?', 'sja-elementor-addons' ),
					],
					[
						'name' => 'answer',
						'label' => __( 'Answer', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __( 'Answer here.', 'sja-elementor-addons' ),
					],
					[
						'name' => 'open_by_default',
						'label' => __( 'Open by default', 'sja-elementor-addons' ),
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label_on' => __( 'Yes', 'sja-elementor-addons' ),
						'label_off' => __( 'No', 'sja-elementor-addons' ),
						'return_value' => 'yes',
						'default' => 'no',
					],
				],
				'title_field' => '{{{ question }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<section id="faq">
			<div class="container">
				<div style="text-align:center">
					<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
						<span class="eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $settings['section_title'] ) ) : ?>
						<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
					<?php endif; ?>
				</div>

				<?php if ( ! empty( $settings['faq_items'] ) ) : ?>
					<div class="faq-wrap">
						<?php foreach ( $settings['faq_items'] as $item ) : ?>
							<details class="faq" <?php echo ( 'yes' === $item['open_by_default'] ) ? 'open' : ''; ?>>
								<summary><?php echo esc_html( $item['question'] ); ?></summary>
								<div class="a"><?php echo wp_kses_post( $item['answer'] ); ?></div>
							</details>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
