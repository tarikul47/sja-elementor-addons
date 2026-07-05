<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (function_exists('WC')) {
	// "Buy Now" flow: clear the cart before WooCommerce adds the new item,
	// so checkout only ever contains the single course being bought.
	add_action('wp_loaded', function () {
		if (!empty($_GET['sja_buy_now']) && isset($_GET['add-to-cart']) && is_numeric($_GET['add-to-cart'])) {
			if (WC()->cart) {
				WC()->cart->empty_cart();
			}
		}
	}, 5);

	// Some stores enable "Redirect to cart page after successful addition".
	// Force our Buy Now links to land on checkout regardless of that setting.
	add_filter('woocommerce_add_to_cart_redirect', function ($url) {
		if (!empty($_GET['sja_buy_now'])) {
			return wc_get_checkout_url();
		}
		return $url;
	});
}

class SJA_Featured_Courses_Widget extends \Elementor\Widget_Base
{

	public function get_name()
	{
		return 'sja-featured-courses';
	}

	public function get_title()
	{
		return __('SJA Featured Courses', 'sja-elementor-addons');
	}

	public function get_icon()
	{
		return 'eicon-post- l-box';
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
				'default' => __('Featured Courses', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label' => __('Section Title', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Featured Online Training Courses', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __('Intro Text', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __('Our most popular Focus Awards qualifications — each available with flexible payment from £50.', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'courses_limit',
			[
				'label' => __('Courses Limit', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'level_attribute',
			[
				'label' => __('Level Attribute Name', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __('The WooCommerce attribute slug for the course level (e.g., pa_level)', 'sja-elementor-addons'),
				'default' => 'pa_level',
			]
		);

		$this->add_control(
			'view_course_label',
			[
				'label' => __('View Course Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('View Course', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'buy_now_label',
			[
				'label' => __('Buy Now Button Label (paid courses)', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Buy Now', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'enrol_label',
			[
				'label' => __('Enrol Button Label (free courses)', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('Enrol', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'view_all_label',
			[
				'label' => __('View All Button Label', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __('View All Courses', 'sja-elementor-addons'),
			]
		);

		$this->add_control(
			'view_all_url',
			[
				'label' => __('View All Button URL', 'sja-elementor-addons'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		// Check if WooCommerce is active
		if (!class_exists('WooCommerce')) {
			echo '<p>WooCommerce is required for this widget.</p>';
			return;
		}

		$products = wc_get_products([
			'limit' => $settings['courses_limit'],
			'status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
		]);
		?>
		<section id="featured">
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

				<?php if (!empty($products)): ?>
					<div class="course-grid">
						<?php foreach ($products as $product):
							$product_id = $product->get_id();
							$image_url = wp_get_attachment_url($product->get_image_id());
							if (!$image_url) {
								$image_url = wc_placeholder_img_src();
							}

							// Get level from attribute
							$level = $product->get_attribute($settings['level_attribute']);
							if (empty($level)) {
								$level = get_post_meta($product_id, '_course_level', true);
							}
							// Check if we are currently looking at the Elementor Editor backend
							$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
							$reveal_class = $is_editor ? '' : 'reveal'; // Removes opacity:0 wrapper inside editor
			
							// Prefer the short description; fall back to a trimmed excerpt of
							// the full description when the short description is empty.
							$short_description = $product->get_short_description();
							//	if (empty($short_description)) {
							//$short_description = wp_trim_words(wp_strip_all_tags($product->get_description()), 20);
							//}
			
							// Free vs paid course determines the CTA label ("Enrol" vs "Buy Now")
							$is_free = floatval($product->get_price()) <= 0;
							$buy_now_label = $is_free ? $settings['enrol_label'] : $settings['buy_now_label'];
							$can_buy_now = $product->is_purchasable() && $product->is_in_stock();

							// Buy Now skips the single product/cart pages and goes straight to checkout
							$buy_now_url = add_query_arg(
								[
									'add-to-cart' => $product_id,
									'quantity' => 1,
									'sja_buy_now' => 1,
								],
								wc_get_checkout_url()
							);
							?>
							<div class="course-card <?php echo esc_attr($reveal_class); ?>">
								<div class="thumb"
									style="background-image: url('<?php echo esc_url($image_url); ?>'); background-size: cover; background-position: center;">
									<?php if (!empty($level)): ?>
										<span class="level"><?php echo esc_html($level); ?></span>
									<?php endif; ?>
								</div>
								<div class="body">
									<h3><?php echo esc_html($product->get_name()); ?></h3>
									<p><?php echo wp_kses_post($short_description); ?></p>
									<div class="foot">
										<div class="price"><?php echo $product->get_price_html(); ?></div>
										<div class="actions">
											<a href="<?php echo esc_url($product->get_permalink()); ?>" class="btn-view">
												<?php echo esc_html($settings['view_course_label']); ?>
											</a>
											<?php if ($can_buy_now): ?>
												<a href="<?php echo esc_url($buy_now_url); ?>" class="btn-buy-now">
													<?php echo esc_html($buy_now_label); ?>
												</a>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($settings['view_all_label'])): ?>
					<div style="text-align:center;margin-top:40px">
						<a href="<?php echo esc_url(is_array($settings['view_all_url']) ? ($settings['view_all_url']['url'] ?? '') : $settings['view_all_url']); ?>"
							class="btn btn-purple">
							<?php echo esc_html($settings['view_all_label']); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
