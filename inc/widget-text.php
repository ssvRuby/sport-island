<?php

/**
 * Класс виджета,  наследуется от класса WP_Widget
 */
class Si_widget_text extends WP_Widget {
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
			'si_widget_text',
			'SI TEXT Widget',
			array(
				'classname'   => 'si_widget_text',
				'description' => 'Show Text',
			)
		);

	}

	public function form( $instance ) {
		/**
		 * Выводит форму обновления настроек.
		 */
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'id_text' ); ?>">
			       Введите текст:
			</label>

			<textarea
				id="<?php echo $this->get_field_id( 'id_text' ); ?>"
				type="text"
				name="<?php echo $this->get_field_name( 'text-name' ); ?>"
				value="<?php echo $instance['text-name'] ?>"
                class="widefat"
			>
                <?php echo $instance['text-name'] ?>
            </textarea>
		</p>
		<?php
	}


	public function widget( $args, $instance ): void {
		/**
		 * В классе-наследнике переопределить эту функцию, чтобы создать код для своего виджета.
		 *
		 * *Параметры**
		 *
		 * - `$args` (массив, обязательный): Аргументы отображения,
		 *    включая 'before_title', 'after_title', 'before_widget' и 'after_widget'.
		 * - `$instance` (массив, обязательный): Настройки для конкретного экземпляра виджета.
		 */
		echo apply_filters('si_widget_text', $instance['text-name']);

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
