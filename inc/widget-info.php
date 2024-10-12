<?php
class Si_widget_info extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'si_widget_info',
			'SI Info Widget',
			array(
				'name'        => 'SI Info Widget',
				'classname'   => 'si_widget_info',
				'description' => 'Show Info Widget',
			)
		);

	}

	public function form( $instance ) {
		$variants = [
			'position' => 'Адрес',
			'time' => 'Время работы',
			'phone' => 'Номер телефона',
			'mail' => 'Адрес электронной почты',
		];
	?>
        <p xmlns="http://www.w3.org/1999/html">
            <label for="<?php echo $this->get_field_id( 'id_info' ); ?>">
                Текст:
            </label>

            <input
                    id="<?php echo $this->get_field_id( 'id_info' ); ?>"
                    type="text"
                    name="<?php echo $this->get_field_name( 'info' ); ?>"
                    value="<?php echo $instance['info'] ?>"
                    class="widefat"
            >
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'id_variant' ); ?>">
                Выберите вариант отображения:
            </label>

            <select
                    id="<?php echo $this->get_field_id( 'id_variant' ); ?>"
                    name="<?php echo $this->get_field_name( 'variant' ); ?>"
                    class="wide fat"
            >

	        <?php
	        foreach ( $variants as $variant => $desc ) {
		        ?>
                <option value="<?php echo $variant; ?>"
			        <?php selected( $instance['variant'], $variant, true ); ?>
                >
			        <?php echo $desc; ?>
		        </option>
		        <?php
	        } ?>
	        </select>
        </p>
		<?php
	}


	public function widget( $args, $instance ): void {

		switch ( $instance['variant'] ) {
			case 'position':
				?>
			         <span class="widget-address">
				         <?php echo $instance['info'] ?>
			         </span>
				<?php
				break;
				case 'time':
				?>
				<span class="widget-working-time">
					<?php echo $instance['info'] ?>
				</span>
				<?php
				break;
			case 'phone':
				$cleared_phone_number = preg_replace('/[^+0-9]/', '', $instance['info']);
				?>
				<a href="tel:<?php echo $cleared_phone_number; ?>" class="widget-phone">
					<?php echo $instance['info']; ?>
				</a>
				<?php
				break;
			case 'mail':
				?>
			<a href="mailto:<?php echo $instance['info'] ?>" class="widget-email">
				<?php echo $instance['info'] ?>
			</a>
				<?php
				break;
			default:
				echo '';
				break;


		}

	}

	public function update( $new_instance, $old_instance ): array {
		/**
		 * Обновляет конкретный экземпляр виджета.
		 * *Описание**
		 * Эта функция должна проверить, правильно ли задан $new_instance.
		 * Должно быть возвращено вновь вычисленное значение $instance.
		 * Если возвращается false, экземпляр не будет сохранен или обновлен.
		 *
		 * *Параметры**
		 *
		 * - `$new_instance` (массив, обязательный): Новые настройки для этого экземпляра,
		 *    введенные пользователем через `WP_Widget::form()`.
		 * - `$old_instance` (массив, обязательный): Старые настройки для этого экземпляра.
		 *
		 * *Возвращает**
		 *
		 * - Массив настроек для сохранения или `false` для отмены сохранения.
		 */

        return $new_instance;
	}
}
