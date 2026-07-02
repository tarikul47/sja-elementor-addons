<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SJA_Save_Bundles_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'sja-save-bundles';
    }

    public function get_title()
    {
        return __('SJA Qualification SAVE Bundles', 'sja-elementor-addons');
    }

    public function get_icon()
    {
        return 'eicon-archive-title';
    }

    public function get_categories()
    {
        return ['sja-widgets'];
    }

    protected function register_controls()
    {

        // --- Content Section ---
        $this->start_controls_section(
            'content_section',
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
                'default' => __('Save More', 'sja-elementor-addons'),
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => __('Section Title', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Save More with Our Qualification Bundles', 'sja-elementor-addons'),
            ]
        );

        $this->add_control(
            'intro_text',
            [
                'label' => __('Intro Paragraph', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Combine related qualifications into structured learning pathways. Build professional knowledge and recognised qualifications through a single convenient study package — with significant savings.', 'sja-elementor-addons'),
            ]
        );

        $this->end_controls_section();

        // --- Checklist Repeater Section ---
        $this->start_controls_section(
            'checklist_section',
            [
                'label' => __('Checklist Items', 'sja-elementor-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'checklist_items',
            [
                'label' => __('Checklist', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'icon',
                        'label' => __('Icon Character', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => '✓',
                    ],
                    [
                        'name' => 'text',
                        'label' => __('Item Text', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Checklist feature item', 'sja-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ text }}}',
                'default' => [
                    ['text' => __('Better value than individual courses', 'sja-elementor-addons')],
                    ['text' => __('Structured career progression pathways', 'sja-elementor-addons')],
                    ['text' => __('Flexible online learning', 'sja-elementor-addons')],
                    ['text' => __('Expert tutor support throughout', 'sja-elementor-addons')],
                    ['text' => __('Eligible bundles from £50 enrolment', 'sja-elementor-addons')],
                    ['text' => __('Interest-free instalment options', 'sja-elementor-addons')],
                ]
            ]
        );

        $this->end_controls_section();

        // --- Bundle Cards Repeater Section ---
        $this->start_controls_section(
            'bundles_section',
            [
                'label' => __('Bundle Cards', 'sja-elementor-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'bundle_cards',
            [
                'label' => __('Cards', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'pill_text',
                        'label' => __('Pill Label', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Pathway', 'sja-elementor-addons'),
                    ],
                    [
                        'name' => 'title',
                        'label' => __('Card Title', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Bundle Title', 'sja-elementor-addons'),
                    ],
                    [
                        'name' => 'description',
                        'label' => __('Card Description', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => __('Bundle description details.', 'sja-elementor-addons'),
                    ],
                    [
                        'name' => 'link',
                        'label' => __('Link URL', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::URL,
                        'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
                        'default' => [
                            'url' => '#',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'name' => 'link_text',
                        'label' => __('Link Text', 'sja-elementor-addons'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => __('Explore Bundle →', 'sja-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
                'default' => [
                    [
                        'pill_text' => 'Teaching Pathway',
                        'title' => 'Complete Teacher Training Pathway',
                        'description' => 'Progress from introductory teaching qualifications to advanced practice and long-term professional development.'
                    ],
                    [
                        'pill_text' => 'Trainer · Assessor · IQA',
                        'title' => 'Trainer, Assessor & IQA Bundle',
                        'description' => 'Develop the complete skills required to train learners, assess vocational competence and maintain assessment quality.'
                    ],
                    [
                        'pill_text' => 'Assessor & IQA',
                        'title' => 'Assessor & IQA Professional Bundle',
                        'description' => 'For assessors wishing to expand their professional responsibilities into internal quality assurance.'
                    ],
                    [
                        'pill_text' => 'Classroom Career',
                        'title' => 'Teaching Assistant Career Pathway',
                        'description' => 'Recognised qualifications preparing you for rewarding classroom support roles within schools and educational settings.'
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        // --- Bottom CTA Button Section ---
        $this->start_controls_section(
            'cta_section',
            [
                'label' => __('Call To Action', 'sja-elementor-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cta_button_text',
            [
                'label' => __('Button Text', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Explore All Qualification Bundles →', 'sja-elementor-addons'),
            ]
        );

        $this->add_control(
            'cta_button_link',
            [
                'label' => __('Button Link', 'sja-elementor-addons'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'sja-elementor-addons'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
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
        <section id="bundles" class="dark" style="background:linear-gradient(180deg,var(--navy-deep),var(--navy));color:#fff">
            <div class="container">
                <div class="<?php echo esc_attr($reveal_class); ?>">
                    <?php if (!empty($settings['eyebrow'])): ?>
                        <span class="eyebrow white"><?php echo esc_html($settings['eyebrow']); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($settings['section_title'])): ?>
                        <h2 class="section-title"><?php echo esc_html($settings['section_title']); ?></h2>
                    <?php endif; ?>

                    <?php if (!empty($settings['intro_text'])): ?>
                        <p class="lead" style="color:#cfd5ea"><?php echo wp_kses_post($settings['intro_text']); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($settings['checklist_items'])): ?>
                    <div class="checklist <?php echo esc_attr($reveal_class); ?>" style="grid-template-columns:repeat(3,1fr);max-width:1000px">
                        <?php foreach ($settings['checklist_items'] as $item): ?>
                            <span>
                                <?php if (!empty($item['icon'])): ?>
                                    <i><?php echo esc_html($item['icon']); ?></i>
                                <?php endif; ?>
                                <?php echo esc_html($item['text']); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($settings['bundle_cards'])): ?>
                    <div class="bundle-grid">
                        <?php foreach ($settings['bundle_cards'] as $card): ?>
                            <div class="bundle-card <?php echo esc_attr($reveal_class); ?>">
                                <?php if (!empty($card['pill_text'])): ?>
                                    <span class="pill"><?php echo esc_html($card['pill_text']); ?></span>
                                <?php endif; ?>

                                <h3><?php echo esc_html($card['title']); ?></h3>
                                <p><?php echo wp_kses_post($card['description']); ?></p>

                                <?php
                                if (!empty($card['link']['url'])):
                                    $this->add_link_attributes('card_link_' . $card['_id'], $card['link']);
                                    $this->add_render_attribute('card_link_' . $card['_id'], 'class', 'link');
                                    ?>
                                    <a <?php $this->print_render_attribute_string('card_link_' . $card['_id']); ?>>
                                        <?php echo esc_html($card['link_text']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php
                if (!empty($settings['cta_button_text']) && !empty($settings['cta_button_link']['url'])):
                    $this->add_link_attributes('cta_btn', $settings['cta_button_link']);
                    $this->add_render_attribute('cta_btn', 'class', 'btn btn-green');
                    ?>
                    <div style="text-align:center;margin-top:46px" class="<?php echo esc_attr($reveal_class); ?>">
                        <a <?php $this->print_render_attribute_string('cta_btn'); ?>>
                            <?php echo esc_html($settings['cta_button_text']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}