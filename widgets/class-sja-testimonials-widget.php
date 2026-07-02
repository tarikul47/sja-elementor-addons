<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_Testimonials_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-testimonials';
	}

	public function get_title()
	{
		return __('SJA Testimonials', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-testimonial';
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
				'default' => __('Learner Stories', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('What Our Learners Say', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label' => __('Testimonials', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'stars',
						'label' => __('Star Rating (1-5)', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::NUMBER,
						'min' => 1,
						'max' => 5,
						'step' => 1,
						'default' => 5,
					],
					[
						'name' => 'quote',
						'label' => __('Quote Text', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __('The flexible payment option allowed me to start studying immediately...', 'sja-elementor-addons'),
					],
					[
						'name' => 'avatar',
						'label' => __('Avatar Initials', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'SM',
					],
					[
						'name' => 'name',
						'label' => __('Name', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Sarah M.',
					],
					[
						'name' => 'role',
						'label' => __('Role', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => 'Teacher',
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->add_control(
			'cta_label',
			[
				'label' => __('CTA Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Read More Success Stories', 'sja-elementor-addons'),
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
		<section id="testimonials" class="alt">
			<div class="container">
				<?php if (!empty($settings['eyebrow'])): ?>
					<span class="eyebrow"><?php echo esc_html($settings['eyebrow']); ?></span>
				<?php endif; ?>

				<?php if (!empty($settings['section_title'])): ?>
					<h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
				<?php endif; ?>

				<?php if (!empty($settings['testimonials'])): ?>
					<div class="test-grid">
						<?php foreach ($settings['testimonials'] as $test): ?>
							<div class="test <?php echo esc_attr($reveal_class); ?>">
								<div class="stars">
									<?php echo str_repeat('★', max(0, min(5, (int) $test['stars']))); ?>
								</div>
								<p>"<?php echo esc_html($test['quote']); ?>"</p>
								<div class="who">
									<div class="av"><?php echo esc_html($test['avatar']); ?></div>
									<div>
										<?php echo esc_html($test['name']); ?>
										<small><?php echo esc_html($test['role']); ?></small>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($settings['cta_label'])): ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url(is_array($settings['cta_url']) ? ($settings['cta_url']['url'] ?? '') : $settings['cta_url']); ?>"
							class="btn btn-purple">
							<?php echo esc_html($settings['cta_label']); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
