<?php

namespace SA_EL_ADDONS\Elements\Calendly;

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;

use \Elementor\Widget_Base as Widget_Base;

class Calendly extends Widget_Base
{

    use \SA_EL_ADDONS\Helper\Elementor_Helper;

    public function get_name()
    {
        return 'sa_el_calendly';
    }

    public function get_title()
    {
        return esc_html__('Calendly', SA_EL_ADDONS_TEXTDOMAIN);
    }

    public function get_icon()
    {
        return 'eicon-calendar oxi-el-admin-icon';
    }

    public function get_categories()
    {
        return ['sa-el-addons'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
			'_section_calendly',
			[
				'label' => __( 'Calendly', SA_EL_ADDONS_TEXTDOMAIN ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'calendly_username',
			[
				'label'       => __( 'Username', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( '', SA_EL_ADDONS_TEXTDOMAIN ),
				'placeholder' => __( 'Type calendly username here', SA_EL_ADDONS_TEXTDOMAIN ),
			]
		);

		$this->add_control(
			'calendly_time',
			[
				'label'   => __( 'Time Slot', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'15min' => __( '15 Minutes', SA_EL_ADDONS_TEXTDOMAIN ),
					'30min' => __( '30 Minutes', SA_EL_ADDONS_TEXTDOMAIN ),
					'60min' => __( '60 Minutes', SA_EL_ADDONS_TEXTDOMAIN ),
					'' => __( 'All', SA_EL_ADDONS_TEXTDOMAIN ),
				],
				'default' => '15min'
			]
		);

		$this->add_control(
			'event_type_details',
			[
				'label'        => __( 'Hide Event Type Details', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', SA_EL_ADDONS_TEXTDOMAIN ),
				'label_off'    => __( 'no', SA_EL_ADDONS_TEXTDOMAIN ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'      => __( 'Height', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 10,
						'max'  => 1000,
						'step' => 5,
					],
					'%'  => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '630',
				],
				'selectors'  => [
					'{{WRAPPER}} .calendly-inline-widget' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .calendly-wrapper'       => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
			'_section_style_calendly',
			[
				'label' => __( 'Calendly', SA_EL_ADDONS_TEXTDOMAIN ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'  => Controls_Manager::COLOR,
				'alpha' => false,
			]
		);

		$this->add_control(
			'button_link_color',
			[
				'label' => __( 'Button & Link Color', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', SA_EL_ADDONS_TEXTDOMAIN ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->end_controls_section();
     }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
		$calendly_time = $settings['calendly_time']!=''?"/{$settings['calendly_time']}":'';
		?>
		<?php if ( $settings['calendly_username'] ): ?>
            <div class="calendly-inline-widget"
                 data-url="https://calendly.com/<?php echo esc_attr( $settings['calendly_username'] ); ?><?php echo esc_attr( $calendly_time ); ?>/?<?php if ( 'yes' === $settings['event_type_details'] ): echo 'hide_event_type_details=1'; endif; ?><?php if ( $settings['text_color'] ): echo "&text_color=" . str_replace( '#', '', $settings['text_color'] ); endif; ?><?php if ( $settings['button_link_color'] ): echo "&primary_color=" . str_replace( '#', '', $settings['button_link_color'] ); endif; ?><?php if ( $settings['background_color'] ): echo "&background_color=" . str_replace( '#', '', $settings['background_color'] ); endif; ?>"
                 style="min-width:320px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
			<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
                <div class="calendly-wrapper" style="width:100%; position:absolute; top:0; left:0; z-index:100;"></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
        
    }
}
