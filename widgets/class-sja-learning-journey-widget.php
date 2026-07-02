<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class SJA_Learning_Journey_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-learning-journey';
	}

	public function get_title()
	{
		return __('SJA Learning Journey Timeline', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-bullet-list';
	}

	public function get_categories()
	{
		return ['sja-widgets'];
	}

	protected function register_controls()
	{

		// --- Header Content Section ---
		$this->start_controls_section(
			'header_section',
			[
				'label' => __('Header Content', 'sja-elementor-addons'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => __('Eyebrow', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Your Learning Journey', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Your Learning Journey with SJA Global Academia', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __('Intro Paragraph', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('A simple, supportive and learner-focused journey — from initial enquiry through to achieving your recognised qualification.', 'sja-elementor-addons'),
			]
		);

		$this->end_controls_section();

		// --- Timeline Steps Repeater Section ---
		$this->start_controls_section(
			'timeline_section',
			[
				'label' => __('Timeline Steps', 'sja-elementor-addons'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'timeline_steps',
			[
				'label' => __('Steps', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'title',
						'label' => __('Step Title', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXT,
						'default' => __('Step Title', 'sja-elementor-addons'),
						'label_block' => true,
					],
					[
						'name' => 'description',
						'label' => __('Step Description', 'sja-elementor-addons'),
						'type' => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __('Step description details go here.', 'sja-elementor-addons'),
					],
				],
				'title_field' => '{{{ title }}}',
				'default' => [
					[
						'title' => __('Explore Our Course Categories', 'sja-elementor-addons'),
						'description' => __('Browse our range of professional categories and qualification bundles. Compare different career pathways and select the option that best supports your ambitions.', 'sja-elementor-addons'),
					],
					[
						'title' => __('Choose Your Qualification', 'sja-elementor-addons'),
						'description' => __('Visit the course page to learn about the qualification, entry requirements, flexible payment options and career opportunities before making your decision.', 'sja-elementor-addons'),
					],
					[
						'title' => __('Enrol Online', 'sja-elementor-addons'),
						'description' => __('Complete your online enrolment and, on eligible qualifications, start your learning journey from just £50 using our flexible payment option.', 'sja-elementor-addons'),
					],
					[
						'title' => __('Access Your Learning Portal', 'sja-elementor-addons'),
						'description' => __('Receive access to your online learning platform — study anytime, anywhere with resources, assignments and learner support always available.', 'sja-elementor-addons'),
					],
					[
						'title' => __('Study with Expert Tutor Support', 'sja-elementor-addons'),
						'description' => __('Progress at your own pace while receiving constructive feedback, academic guidance and ongoing support from experienced tutors.', 'sja-elementor-addons'),
					],
					[
						'title' => __('Achieve Your Qualification', 'sja-elementor-addons'),
						'description' => __('Successfully complete your assessments and gain your recognised qualification — ready for your next career step.', 'sja-elementor-addons'),
					],
				],
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
		<section id="journey">
			<div class="container">
				<div class="<?php echo esc_attr($reveal_class); ?>">
					<?php if (!empty($settings['eyebrow'])): ?>
						<span class="eyebrow"><?php echo esc_html($settings['eyebrow']); ?></span>
					<?php endif; ?>

					<?php if (!empty($settings['section_title'])): ?>
						<h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
					<?php endif; ?>

					<?php if (!empty($settings['intro_text'])): ?>
						<p class="lead"><?php echo wp_kses_post($settings['intro_text']); ?></p>
					<?php endif; ?>
				</div>

				<?php if (!empty($settings['timeline_steps'])): ?>
					<div class="timeline">
						<?php
						$counter = 1;
						foreach ($settings['timeline_steps'] as $step):
							?>
							<div class="tl-step <?php echo esc_attr($reveal_class); ?>">
								<div class="marker"><?php echo esc_html($counter); ?></div>
								<div class="body">
									<?php if (!empty($step['title'])): ?>
										<h4><?php echo esc_html($step['title']); ?></h4>
									<?php endif; ?>

									<?php if (!empty($step['description'])): ?>
										<p><?php echo wp_kses_post($step['description']); ?></p>
									<?php endif; ?>
								</div>
							</div>
							<?php
							$counter++;
						endforeach;
						?>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}