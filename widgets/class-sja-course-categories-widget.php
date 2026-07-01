<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SJA_Course_Categories_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sja-course-categories';
	}

	public function get_title() {
		return __( 'SJA Course Categories', 'sja-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-folder';
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
				'default' => __( 'Course Categories', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __( 'Section Title', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Explore Our Course Categories', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __( 'Intro Text', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'From teacher training to health & social care, our recognised qualifications cover the pathways UK learners care about most.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'categories_limit',
			[
				'label' => __( 'Categories Limit', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'divider_cta_heading',
			[
				'label' => __( 'Divider CTA Heading', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Ready to Start Your Learning Journey?', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'divider_cta_body',
			[
				'label' => __( 'Divider CTA Body', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Join learners across the UK who are achieving recognised qualifications through affordable online learning, expert tutor support and flexible payment options.', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'divider_primary_btn_label',
			[
				'label' => __( 'Divider Primary Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Browse All Courses', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'divider_primary_btn_url',
			[
				'label' => __( 'Divider Primary Button URL', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'divider_secondary_btn_label',
			[
				'label' => __( 'Divider Secondary Button Label', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Contact Our Team', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'divider_secondary_btn_url',
			[
				'label' => __( 'Divider Secondary Button URL', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'sja-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_divider_cta',
			[
				'label' => __( 'Show Divider CTA', 'sja-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'sja-elementor-addons' ),
				'label_off' => __( 'No', 'sja-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Check if WooCommerce is active
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<p>WooCommerce is required for this widget.</p>';
			return;
		}

		$categories = get_terms( [
			'taxonomy' => 'product_cat',
			'number' => $settings['categories_limit'],
			'hide_empty' => false,
		] );
		?>
		<section id="categories" class="alt">
			<div class="container">
				<?php if ( ! empty( $settings['eyebrow'] ) ) : ?>
					<span class="eyebrow green"><?php echo esc_html( $settings['eyebrow'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<h2 class="section-title"><?php echo esc_html( $settings['section_title'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $settings['intro_text'] ) ) : ?>
					<p class="lead"><?php echo wp_kses_post( $settings['intro_text'] ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
					<div class="cat-grid">
						<?php foreach ( $categories as $category ) :
							$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
							$image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : 'https://via.placeholder.com/400x300';
							?>
							<div class="cat-card reveal">
								<div class="img" style="background-image: url('<?php echo esc_url( $image_url ); ?>');"></div>
								<div class="body">
									<h3><?php echo esc_html( $category->name ); ?></h3>
									<p><?php echo wp_kses_post( $category->description ); ?></p>
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="btn-link">
										<?php _e( 'Learn More →', 'sja-elementor-addons' ); ?>
									</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === $settings['show_divider_cta'] ) : ?>
					<div class="divider-cta">
						<div>
							<?php if ( ! empty( $settings['divider_cta_heading'] ) ) : ?>
								<h3><?php echo esc_html( $settings['divider_cta_heading'] ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $settings['divider_cta_body'] ) ) : ?>
								<p><?php echo wp_kses_post( $settings['divider_cta_body'] ); ?></p>
							<?php endif; ?>
						</div>
						<div class="ctas">
							<?php if ( ! empty( $settings['divider_primary_btn_label'] ) ) : ?>
								<a href="<?php echo esc_url( is_array( $settings['divider_primary_btn_url'] ) ? ( $settings['divider_primary_btn_url']['url'] ?? '' ) : $settings['divider_primary_btn_url'] ); ?>" class="btn btn-green">
									<?php echo esc_html( $settings['divider_primary_btn_label'] ); ?>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $settings['divider_secondary_btn_label'] ) ) : ?>
								<a href="<?php echo esc_url( is_array( $settings['divider_secondary_btn_url'] ) ? ( $settings['divider_secondary_btn_url']['url'] ?? '' ) : $settings['divider_secondary_btn_url'] ); ?>" class="btn btn-outline">
									<?php echo esc_html( $settings['divider_secondary_btn_label'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
