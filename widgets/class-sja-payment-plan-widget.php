<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_Payment_Plan_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-payment-plan';
	}

	public function get_title()
	{
		return __('SJA Payment Plan / Journey', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-payment-method';
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
				'default' => __('Flexible Payment Plan', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Start Your Qualification from Just £50', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'layout_mode',
			[
				'label' => __('Layout Mode', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'payment' => __('Payment Plan', 'sja-elementor-addons'),
					'journey' => __('Learning Journey', 'sja-elementor-addons'),
				],
				'default' => 'payment',
			]
		);

		// Common body text for both modes
		$this->add_control(
			'body_text',
			[
				'label' => __('Body Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __('One of the biggest barriers to professional development is cost. We\'ve built one of the most flexible payment options available — pay £50 to begin, then continue unit by unit while you study at a pace that suits your life.', 'sja-elementor-addons'),
			]
		);

		// Payment mode only controls
		$this->add_control(
			'price_orb_label',
			[
				'label' => __('Price Orb Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('From Only', 'sja-elementor-addons'),
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		$this->add_control(
			'price_orb_amount',
			[
				'label' => __('Price Orb Amount', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '£50',
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		$this->add_control(
			'price_orb_sub',
			[
				'label' => __('Price Orb Subtext', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('To Enrol Today', 'sja-elementor-addons'),
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		$this->add_control(
			'no_fee_heading',
			[
				'label' => __('No-Fee Heading', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Unlike many providers, we do not charge:', 'sja-elementor-addons'),
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		$this->add_control(
			'no_fee_items',
			[
				'label' => __('No-Fee Items', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'text',
						'label' => __('Item Text', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Interest on instalments',
					],
				],
				'title_field' => '{{{ text }}}',
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		$this->add_control(
			'highlight_text',
			[
				'label' => __('Highlight Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('The price you see is the price you pay.', 'sja-elementor-addons'),
				'condition' => ['layout_mode' => 'payment'],
			]
		);

		// Steps (Common)
		$this->add_control(
			'steps',
			[
				'label' => __('Steps', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'title',
						'label' => __('Step Title', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Step Title',
					],
					[
						'name' => 'description',
						'label' => __('Step Description', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => 'Step description goes here.',
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
				'default' => __('Enrol Today from £50', 'sja-elementor-addons'),
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
				'default' => 'green',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$mode = $settings['layout_mode'];
		?>
		<section id="<?php echo $mode === 'payment' ? 'plan' : 'journey'; ?>"
			class="<?php echo $mode === 'payment' ? 'alt' : ''; ?>">
			<div class="container">
				<?php if (!empty($settings['eyebrow'])): ?>
					<span
						class="eyebrow <?php echo $mode === 'payment' ? 'green' : ''; ?>"><?php echo esc_html($settings['eyebrow']); ?></span>
				<?php endif; ?>

				<?php if (!empty($settings['section_title'])): ?>
					<h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
				<?php endif; ?>

				<?php if ($mode !== 'payment' && !empty($settings['body_text'])): ?>
					<div class="lead"
						style="<?php echo $mode === 'payment' ? 'color:#3a4570;font-size:16px;margin-bottom:18px' : 'color:#475275;font-size:16px;margin-bottom:24px'; ?>">
						<?php echo wp_kses_post($settings['body_text']); ?>
					</div>
				<?php endif; ?>

				<?php if ($mode === 'payment'): ?>
					<div class="plan">
						<div class="price-orb">
							<div style="text-align:center">
								<div class="label"><?php echo esc_html($settings['price_orb_label']); ?></div>
								<div class="amount"><?php echo esc_html($settings['price_orb_amount']); ?></div>
								<div class="sub"><?php echo esc_html($settings['price_orb_sub']); ?></div>
							</div>
						</div>
						<div style="margin-top: 20px;">
							<?php if (!empty($settings['body_text'])): ?>
								<div class="lead"
									style="<?php echo $mode === 'payment' ? 'color:#3a4570;font-size:16px;margin-bottom:18px' : 'color:#475275;font-size:16px;margin-bottom:24px'; ?>">
									<?php echo wp_kses_post($settings['body_text']); ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($settings['no_fee_heading'])): ?>
								<p style="color:var(--navy);font-weight:700;margin-bottom:10px">
									<?php echo esc_html($settings['no_fee_heading']); ?>
								</p>
							<?php endif; ?>

							<?php if (!empty($settings['no_fee_items'])): ?>
								<ul class="no-fee">
									<?php foreach ($settings['no_fee_items'] as $item): ?>
										<li><?php echo esc_html($item['text']); ?></li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<?php if (!empty($settings['highlight_text'])): ?>
								<p style="color:var(--green-dark);font-weight:800;font-size:18px">
									<?php echo esc_html($settings['highlight_text']); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if (!empty($settings['steps'])): ?>
					<div class="<?php echo $mode === 'payment' ? 'steps' : 'journey'; ?>">
						<?php foreach ($settings['steps'] as $index => $step): ?>
							<div class="<?php echo $mode === 'payment' ? 'step' : 'j-step'; ?>">
								<div class="n"><?php echo sprintf('%d', $index + 1); ?></div>
								<h4><?php echo esc_html($step['title']); ?></h4>
								<p><?php echo wp_kses_post($step['description']); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($settings['cta_label'])): ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url(is_array($settings['cta_url']) ? ($settings['cta_url']['url'] ?? '') : $settings['cta_url']); ?>"
							class="btn btn-<?php echo esc_attr($settings['cta_style']); ?>">
							<?php echo esc_html($settings['cta_label']); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
