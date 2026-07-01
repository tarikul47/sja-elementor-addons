<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_Hero_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-hero';
	}

	public function get_title()
	{
		return __('SJA Hero', 'sja-elementon-addons');
	}

	public function get_icon()
	{
		return 'eicon-banner';
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
				'default' => __('Focus Awards Approved Training Provider', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'h1_before',
			[
				'label' => __('H1 Text (Before Accent)', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Online Training Courses UK with ', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'h1_accent',
			[
				'label' => __('H1 Accent Words', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Affordable Flexible', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'h1_after',
			[
				'label' => __('H1 Text (After Accent)', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __(' Learning', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'body_text_1',
			[
				'label' => __('Body Paragraph 1', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('SJA Global Academia is a Focus Awards Approved Training Provider delivering high-quality online training courses in the UK. Whether you are looking to become a teacher, assessor, internal quality assurer, teaching assistant, manager, or healthcare professional, we provide flexible learning designed to help you achieve recognised qualifications while keeping education affordable.', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'body_text_2',
			[
				'label' => __('Body Paragraph 2 (Lead)', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Our learners benefit from expert tutor support, flexible online study, interest-free instalment plans, and qualification bundles that offer outstanding value. You can enrol today from just £50 and complete your qualification one unit at a time with no additional instalment charges.', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'primary_btn_label',
			[
				'label' => __('Primary Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Explore Courses', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'primary_btn_url',
			[
				'label' => __('Primary Button URL', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'secondary_btn_label',
			[
				'label' => __('Secondary Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('View Qualification Bundles', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'secondary_btn_url',
			[
				'label' => __('Secondary Button URL', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'trust_badges',
			[
				'label' => __('Trust Badges', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'icon',
						'label' => __('Icon (Default is ✓)', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => '✓',
					],
					[
						'name' => 'label',
						'label' => __('Label', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Focus Awards Approved',
					],
				],
				'title_field' => '{{{ label }}}',
			]
		);

		$this->add_control(
			'show_hero_image',
			[
				'label' => __('Show Hero Image', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'enable_price_orb',
			[
				'label' => __('Enable Price Orb', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'price_orb_label',
			[
				'label' => __('Price Orb Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Enrol From', 'sja-elementor-addons'),
				'condition' => ['enable_price_orb' => 'yes'],
			]
		);

		$this->add_control(
			'price_orb_amount',
			[
				'label' => __('Price Orb Amount', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '£50',
				'condition' => ['enable_price_orb' => 'yes'],
			]
		);

		$this->add_control(
			'hero_image',
			[
				'label' => __('Hero Image', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['show_hero_image' => 'yes'],
			]
		);

		$this->add_control(
			'hero_image_alt',
			[
				'label' => __('Hero Image Alt Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Online Training Courses UK by SJA Global Academia', 'sja-elementon-addons'),
				'condition' => ['show_hero_image' => 'yes'],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$show_image = $settings['show_hero_image'] === 'yes';
		$enable_orb = $settings['enable_price_orb'] === 'yes';
		?>
		<section class="hero">
			<div class="container">
				<div class="grid <?php echo !$show_image ? 'hero-centered' : ''; ?>">
					<div class="reveal">
						<?php if (!empty($settings['eyebrow'])): ?>
							<span class="eyebrow" style="color:var(--green)"><?php echo esc_html($settings['eyebrow']); ?></span>
						<?php endif; ?>

						<?php if (!empty($settings['h1_before']) || !empty($settings['h1_accent']) || !empty($settings['h1_after'])): ?>
							<h1 style="<?php echo !$show_image ? 'text-align:center; margin: 14px auto 22px;' : ''; ?>">
								<?php echo esc_html($settings['h1_before']); ?>
								<?php if (!empty($settings['h1_accent'])): ?>
									<span class="accent"><?php echo esc_html($settings['h1_accent']); ?></span>
								<?php endif; ?>
								<?php echo esc_html($settings['h1_after']); ?>
							</h1>
						<?php endif; ?>

						<?php if (!empty($settings['body_text_1'])): ?>
							<p style="<?php echo !$show_image ? 'text-align:center; margin: 0 auto 16px;' : ''; ?>">
								<?php echo wp_kses_post($settings['body_text_1']); ?>
							</p>
						<?php endif; ?>

						<?php if (!empty($settings['body_text_2'])): ?>
							<p class="lead" style="<?php echo !$show_image ? 'text-align:center; margin: 0 auto 28px;' : ''; ?>">
								<?php echo wp_kses_post($settings['body_text_2']); ?>
							</p>
						<?php endif; ?>

						<?php if (!empty($settings['primary_btn_label']) || !empty($settings['secondary_btn_label'])): ?>
							<div class="ctas" style="<?php echo !$show_image ? 'justify-content:center;' : ''; ?>">
								<?php if (!empty($settings['primary_btn_label'])): ?>
									<a href="<?php echo esc_url(is_array($settings['primary_btn_url']) ? ($settings['primary_btn_url']['url'] ?? '') : $settings['primary_btn_url']); ?>"
										class="btn btn-green">
										<?php echo esc_html($settings['primary_btn_label']); ?>
									</a>
								<?php endif; ?>

								<?php if (!empty($settings['secondary_btn_label'])): ?>
									<a href="<?php echo esc_url(is_array($settings['secondary_btn_url']) ? ($settings['secondary_btn_url']['url'] ?? '') : $settings['secondary_btn_url']); ?>"
										class="btn btn-purple">
										<?php echo esc_html($settings['secondary_btn_label']); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if (!empty($settings['trust_badges'])): ?>
							<div class="trust" style="<?php echo !$show_image ? 'justify-content:center;' : ''; ?>">
								<?php foreach ($settings['trust_badges'] as $badge): ?>
									<span>
										<span class="dot"><?php echo esc_html($badge['icon']); ?></span>
										<?php echo esc_html($badge['label']); ?>
									</span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<?php if ($show_image): ?>
						<div class="reveal">
							<div class="hero-visual">
								<?php if (!empty($settings['hero_image']['url'])): ?>
									<img src="<?php echo esc_url($settings['hero_image']['url']); ?>"
										alt="<?php echo esc_attr($settings['hero_image_alt']); ?>" />
								<?php else: ?>
									<img src="https://via.placeholder.com/800x600" alt="Placeholder" />
								<?php endif; ?>
								<?php if ($enable_orb): ?>
									<div class="price-orb">
										<small><?php echo esc_html($settings['price_orb_label']); ?></small>
										<strong><?php echo esc_html($settings['price_orb_amount']); ?></strong>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}
