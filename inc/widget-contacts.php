<?php

class Si_widget_contacts extends WP_Widget {
	/**
	 * Переопределяем конструктор:
	 * $id_base - Базовый идентификатор для виджета, должен быть написан в нижнем регистре и быть уникальным.
	 * Если оставить пустым, будет использована часть имени класса PHP виджета.
	 * $name - Имя виджета, отображаемое на странице настройки.
	 * $widget_options array - Массив дополнительных опций виджета для экземпляра.
	 * - `classname` (строка): Имя класса для HTML-контейнера виджета.
	 * По умолчанию используется сокращенная версия имени функции обратного вызова.
	 * - `description` (строка): Описание виджета для отображения в панели управления виджетами и/или в теме.
	 * - `show_instance_in_rest` (булево): Определяет, следует ли показывать настройки экземпляра виджета в REST API.
	 * Доступно только для виджетов, основанных на WP_Widget.
	 * https://developer.wordpress.org/reference/classes/wp_widget/__construct/
	 */
	public function __construct() {
		parent::__construct(
			'si_widget_contacts',
			'SI Contacts Widget',
			array(
				'classname'   => 'Si_widget_contacts',
				'description' => 'Show Contacts',
        'show_instance_in_rest' => true, // Разрешаем отображение в REST API
			)
		);

	}

	public function form( $instance ) {
		/**
		 * Выводит форму обновления настроек.
		 */
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'id_phone' ); ?>">
			       Введите номер телефона:
			</label>

			<input
				id="<?php echo $this->get_field_id( 'id_phone' ); ?>"
				type="text"
				name="<?php echo $this->get_field_name( 'phone_number' ); ?>"
				value="<?php echo $instance['phone_number'] ?>"
                class="widefat"
			>

            <label for="<?php echo $this->get_field_id( 'id_address' ); ?>">
			       Введите адрес:
			</label>
            <input
				id="<?php echo $this->get_field_id( 'id_address' ); ?>"
				type="text"
				name="<?php echo $this->get_field_name( 'address_text' ); ?>"
				value="<?php echo $instance['address_text'] ?>"
                class="widefat"
			>
		</p>
		<?php
	}


	public function widget( $args, $instance ): void {

        $phone_number_text = $instance['phone_number'];
        $phone_number_text_pattern = '/[^+0-9]/';
        $cleared_phone_number = preg_replace($phone_number_text_pattern, '', $instance['phone_number']);

        ?>

        <address class="main-header__widget widget-contacts">
		   <a href="tel:<?php echo $cleared_phone_number;?>" class="widget-contacts__phone">
               <?php echo $instance['phone_number'];  ?>
           </a>
		   <p class="widget-contacts__address">
               <?php echo $instance['address_text']; ?>
           </p>
        </address>


<?php

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
