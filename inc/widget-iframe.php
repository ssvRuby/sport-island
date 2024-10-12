<?php

class Si_widget_iframe extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'si_widget_iframe',
			'SI iFrame Widget',
			array(
				'name'        => 'SI iFrame Widget',
				'classname'   => 'si_widget_iframe',
				'description' => 'Show iFrame widget',
			)
		);

	}

	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'id_code' ); ?>">
			       Введите текст:
			</label>

			<textarea
				id="<?php echo $this->get_field_id( 'id_code' ); ?>"
				name="<?php echo $this->get_field_name( 'code' ); ?>"
				value="<?php echo esc_html($instance['code']) ?>"
                class="widefat"
			>
                <?php echo esc_html($instance['code']) ?>
            </textarea>
		</p>
		<?php
	}


	public function widget( $args, $instance ): void {

		echo $instance['code'];

	}

	public function update( $new_instance, $old_instance ): array {

        return $new_instance;
	}
}

