<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_University_Topup_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-university-topup';
	}

	public function get_title()
	{
		return __('SJA University Top-Up', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-graduation-cap';
	}

	public function get_categories()
	{
		return ['sja-widgets'];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'sja-elementor-addons'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => __('Eyebrow', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('University Top-Up Programmes', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Take Your Education to the Next Level', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __('Intro Paragraph', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('SJA Global Academia also offers access to University Top-Up Programmes through our trusted partner training providers. These programmes are designed for learners who wish to progress towards internationally recognised higher education qualifications while benefiting from flexible study opportunities.', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'programme_cards',
			[
				'label' => __('Programme Cards', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'tag',
						'label' => __('Tag/Badge Label', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Bachelor',
					],
					[
						'name' => 'title',
						'label' => __('Programme Title', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'BBA Top-Up',
					],
					[
						'name' => 'description',
						'label' => __('Description', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => 'Advance your business and leadership knowledge through a recognised Bachelor of Business Administration Top-Up programme.',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __('CTA Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Explore Top-Up Programmes', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'cta_url',
			[
				'label' => __('CTA Button URL', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		// Check if we are currently looking at the Elementor Editor backend
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$reveal_class = $is_editor ? '' : 'reveal'; // Removes opacity:0 wrapper inside editor

		?>
		<section id="topup" class="dark">
			<div class="container">
				<?php if (!empty($settings['eyebrow'])): ?>
					<span class="eyebrow"><?php echo esc_html($settings['eyebrow']); ?></span>
				<?php endif; ?>

				<?php if (!empty($settings['section_title'])): ?>
					<h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
				<?php endif; ?>

				<?php if (!empty($settings['intro_text'])): ?>
					<p class="lead"><?php echo wp_kses_post($settings['intro_text']); ?></p>
				<?php endif; ?>

				<?php if (!empty($settings['programme_cards'])): ?>
					<div class="topup-grid">
						<?php foreach ($settings['programme_cards'] as $card): ?>
							<div class="topup-card <?php echo esc_attr($reveal_class); ?>">
								<?php if (!empty($card['tag'])): ?>
									<span class="tag"><?php echo esc_html($card['tag']); ?></span>
								<?php endif; ?>
								<h3><?php echo esc_html($card['title']); ?></h3>
								<p><?php echo wp_kses_post($card['description']); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($settings['cta_label'])): ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url(is_array($settings['cta_url']) ? ($settings['cta_url']['url'] ?? '') : $settings['cta_url']); ?>"
							class="btn btn-green">
							<?php echo esc_html($settings['cta_label']); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
