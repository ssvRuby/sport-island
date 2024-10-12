<?php

class sportisland_banner_button_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'sportisland_banner_button_widget',
			'SI Banner Button',
			array(
				'description' => 'Display banner button',
				'classname'   => 'sportisland_banner_button_widget',
			)
		);
	}

	function form( $instance ) {
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'id_button_text' ); ?>">
                Введите текст кнопки:
            </label>
        </p>
        <input
                id="<?php echo $this->get_field_id( 'id_button_text' ); ?>"
                type="text"
                name="<?php echo $this->get_field_name( 'button_text' ); ?>"
                value="<?php echo $instance['button_text'] ?>"
                class="widefat"
        >

        <p>
            <label for="<?php echo $this->get_field_id( 'id_button_link' ); ?>">
                Введите ссылку на страницу перехода:
            </label>
        </p>
        <input
                id="<?php echo $this->get_field_id( 'id_button_link' ); ?>"
                type="text"
                name="<?php echo $this->get_field_name( 'button_link' ); ?>"
                value="<?php echo $instance['button_link'] ?>"
                class="widefat"
        >
		<?php
	}


	function widget( $args, $instance ) {
		?>
        <a href="<?php echo $instance['button_link'] ?>"
           class="banner__link btn">
			<?php echo $instance['button_text'] ?>
        </a>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}
