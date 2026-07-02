<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_Split_Content_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-split-content';
	}

	public function get_title()
	{
		return __('SJA Split Content', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-split-layout';
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
			'section_id',
			[
				'label' => __('Section ID', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __('Enter a unique ID for anchor links (e.g., moodle, webdev)', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'bg_style',
			[
				'label' => __('Background Style', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'light' => __('Light', 'sja-elementor-addons'),
					'alt' => __('Alt (Grey)', 'sja-elementor-addons'),
					'dark' => __('Dark (Navy)', 'sja-elementor-addons'),
				],
				'default' => 'light',
			]
		);

		$this->add_control(
			'layout_direction',
			[
				'label' => __('Layout Direction', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'normal' => __('Normal (Text Left, Image Right)', 'sja-elementor-addons'),
					'reverse' => __('Reverse (Image Left, Text Right)', 'sja-elementor-addons'),
				],
				'default' => 'normal',
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => __('Eyebrow', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('LMS Services', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => __('Eyebrow Colour', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => __('Default (Purple)', 'sja-elementor-addons'),
					'green' => __('Green', 'sja-elementor-addons'),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Moodle Learning Management System (LMS) Services', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'body_text',
			[
				'label' => __('Body Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Modern learners expect flexible, engaging and easy-to-navigate online learning. We design, develop and support Moodle platforms that help training providers improve learner engagement, automate enrolment and streamline course delivery.', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'feature_items',
			[
				'label' => __('Feature List Items', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __('Item Text', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Moodle installation, configuration & branding',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'browser_badge',
			[
				'label' => __('Browser Badge Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Enterprise Grade', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'browser_image',
			[
				'label' => __('Browser Image', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __('CTA Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Learn More About Moodle Services', 'sja-elementor-addons'),
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

		$this->add_control(
			'cta_style',
			[
				'label' => __('CTA Button Style', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'green' => __('Green', 'sja-elementor-addons'),
					'purple' => __('Purple', 'sja-elementor-addons'),
				],
				'default' => 'purple',
			]
		);

		$this->add_control(
			'enrol_label',
			[
				'label' => __('Enrol Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('From enrol', 'sja-elementor-addons'),
			]
		);
		$this->add_control(
			'price',
			[
				'label' => __('Price', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('£50', 'sja-elementor-addons'),
			]
		);
		$this->add_control(
			'today_label',
			[
				'label' => __('Today Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('to day', 'sja-elementor-addons'),
			]
		);


		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$bg_class = $settings['bg_style'] === 'dark' ? 'dark' : ($settings['bg_style'] === 'alt' ? 'alt' : '');
		$layout_class = $settings['layout_direction'] === 'reverse' ? 'reverse' : '';
		$eyebrow_class = $settings['eyebrow_color'] === 'green' ? 'green' : '';
		?>
		<section id="<?php echo esc_attr($settings['section_id']); ?>" class="<?php echo esc_attr($bg_class); ?>">
			<div class="container">
				<div class="split <?php echo esc_attr($layout_class); ?>">
					<div>
						<?php if (!empty($settings['eyebrow'])): ?>
							<span
								class="eyebrow <?php echo esc_attr($eyebrow_class); ?>"><?php echo esc_html($settings['eyebrow']); ?></span>
						<?php endif; ?>

						<?php if (!empty($settings['section_title'])): ?>
							<h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
						<?php endif; ?>

						<?php if (!empty($settings['body_text'])): ?>
							<p style="color:#475275"><?php echo wp_kses_post($settings['body_text']); ?></p>
						<?php endif; ?>

						<?php if (!empty($settings['feature_items'])): ?>
							<ul class="feature-grid">
								<?php foreach ($settings['feature_items'] as $item): ?>
									<li class="feature-grid-item"><?php echo esc_html($item['text']); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if (!empty($settings['cta_label'])): ?>
							<a href="<?php echo esc_url(is_array($settings['cta_url']) ? ($settings['cta_url']['url'] ?? '') : $settings['cta_url']); ?>"
								class="btn btn-<?php echo esc_attr($settings['cta_style']); ?>">
								<?php echo esc_html($settings['cta_label']); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class="premium-img-wrap">
						<?php if (!empty($settings['browser_badge'])): ?>
							<div class="premium-badge"><?php echo esc_html($settings['browser_badge']); ?></div>
						<?php endif; ?>
						<div class="browser-mockup">
							<div class="browser-topbar">
								<div class="browser-dots">
									<span class="dot-red"></span>
									<span class="dot-yellow"></span>
									<span class="dot-green"></span>
								</div>
							</div>
							<?php if (!empty($settings['browser_image']['url'])): ?>
								<img src="<?php echo esc_url($settings['browser_image']['url']); ?>"
									alt="<?php echo esc_attr($settings['section_title']); ?>" />
							<?php else: ?>
								<img src="https://via.placeholder.com/800x600" alt="Placeholder" />
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}
