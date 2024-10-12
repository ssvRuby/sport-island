<?php
/*
require_once( __DIR__ . '/inc/widget-text.php' );
require_once( __DIR__ . '/inc/widget-contacts.php' );
require_once( __DIR__ . '/inc/widget-social.php' );
require_once( __DIR__ . '/inc/widget-iframe.php' );
require_once( __DIR__ . '/inc/widget-info.php' );
require_once( __DIR__ . '/inc/widget-banner-button.php' );*/

// Подключение require_once() всех файлов из директории виджетов
$path_to_widget = __DIR__ . '/inc/';

$widgets_file_list = list_files( $path_to_widget, 1 );
foreach ( $widgets_file_list as $file ) {
	require_once( $file );
}

add_shortcode( 'si-paste-link', 'si_paste_link_shortcode' );

function si_paste_link_shortcode( $atts ) {
	$defaults_params = [
		'link' => '',
		'text' => '',
		'type' => 'link',
	];
	$params          = shortcode_atts( $defaults_params, $atts, 'si-paste-link' );

	$params['text'] = $params['text'] ? $params['text'] : $params['link'];
	if ( $params['link'] ) {
		$protocol = '';
		switch ( $params['type'] ) {
			case 'email':
				$protocol = 'mailto:';
				break;
			case 'phone':
				$protocol       = 'tel:';
				$params['link'] = preg_replace( '/[^+0-9]/', '', $params['link'] );
				break;
			case 'url':
				$protocol = 'http://';
				break;
		}
		$link = $protocol . $params['link'];
		$text = $params['text'];

		return "<a href='$link' target='_blank'>$text</a>";
	} else {
		return '';
	}
}

add_filter( 'si_widget_text', 'do_shortcode' );

add_action( 'after_setup_theme', 'sportisland_theme_setup' );
function sportisland_theme_setup() {
	register_nav_menus( [
		'header_menu'  => 'Меню в шапке',
		'footer_menu'  => 'Меню в подвале',
		'central_menu' => 'Меню центра главной страницы',
	] );

	add_theme_support( 'custom-logo' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	//    add_theme_support('menus');

}

add_action( 'widgets_init', 'si_register' );
function si_register(): void {
	register_sidebar( [
		'name'          => 'Пост главной страницы',
		'id'            => 'si_post_for_main_page_sidebar',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_sidebar( [
		'name'          => 'Кнопка Записаться - баннер',
		'id'            => 'si_banner_button_sidebar',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_sidebar( [
		'name'          => 'Контакты в шапке сайта',
		'id'            => 'si_header_sidebar',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_sidebar( [
		'name'          => 'Контакты в подвале сайта',
		'id'            => 'si_footer_sidebar',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_sidebar( [
		'name'          => 'Сайдбар в футере - колонка 1',
		'id'            => 'si_footer_sidebar_column_1',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );
	register_sidebar( [
		'name'          => 'Сайдбар в футере - колонка 2',
		'id'            => 'si_footer_sidebar_column_2',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );
	register_sidebar( [
		'name'          => 'Сайдбар в футере - колонка 3',
		'id'            => 'si_footer_sidebar_column_3',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_sidebar( [
		'name'          => 'Карта',
		'id'            => 'si_map',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );
	register_sidebar( [
		'name'          => 'После карты',
		'id'            => 'si_after_map',
		'before_widget' => NULL,
		'after_widget'  => NULL,
	] );

	register_widget( 'Si_widget_text' );
	register_widget( 'Si_widget_contacts' );
	register_widget( 'Si_widget_social' );
	register_widget( 'Si_widget_iframe' );
	register_widget( 'Si_widget_info' );

	register_widget( 'sportisland_banner_button_widget' );
	register_widget( 'SI_post_for_main_page' );
}

add_action( 'wp_enqueue_scripts', 'sportisland_theme_enqueue_scripts' );
function sportisland_theme_enqueue_scripts() {
	wp_enqueue_script( 'js', get_template_directory_uri() . '/_assets/js/js.js', [], '1.0', TRUE );
	wp_enqueue_style( 'si-style', get_template_directory_uri() . '/_assets/css/styles.css', [], '1.0', 'all' );
}

add_filter( 'show_admin_bar', '__return_false' );
function _si_assets_path( $path ) {
	return get_template_directory_uri() . '/_assets/' . $path;
}

//Регистрация собственного типа записи
add_action( 'init', 'si_register_type' );
function si_register_type() {

	register_post_type( 'services', [
		'labels'        => [
			'name'               => 'Услуги',
			// основное название для типа записи
			'singular_name'      => 'Услуга',
			// название для одной записи этого типа
			'add_new'            => 'Добавить новую услугу',
			// для добавления новой записи
			'add_new_item'       => 'Добавить новую услугу',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать услугу',
			// для редактирования типа записи
			'new_item'           => 'Новая услуга',
			// текст новой записи
			'view_item'          => 'Смотреть услуги',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать услуги',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Услуги',
			// название меню
		],
		'public'        => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-smiley',
		'hierarchical'  => FALSE,
		'supports'      => [ 'title' ],
		'has_archive'   => TRUE,
	] );

	register_post_type( 'trainers', [
		'labels'        => [
			'name'               => 'Тренеры',
			// основное название для типа записи
			'singular_name'      => 'Тренер',
			// название для одной записи этого типа
			'add_new'            => 'Добавить нового тренера',
			// для добавления новой записи
			'add_new_item'       => 'Добавить нового тренера',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать тренера',
			// для редактирования типа записи
			'new_item'           => 'Новый тренер',
			// текст новой записи
			'view_item'          => 'Смотреть тренеров',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать тренера',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Тренеры',
			// название меню
		],
		'public'        => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-universal-access',
		'hierarchical'  => FALSE,
		'supports'      => [ 'title' ],
		'has_archive'   => TRUE,
	] );

	register_post_type( 'shedules', [
		'labels'        => [
			'name'               => 'Занятия',
			// основное название для типа записи
			'singular_name'      => 'Занятие',
			// название для одной записи этого типа
			'add_new'            => 'Добавить новое занятие',
			// для добавления новой записи
			'add_new_item'       => 'Добавить новое занятие',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать занятие',
			// для редактирования типа записи
			'new_item'           => 'Новое занятие',
			// текст новой записи
			'view_item'          => 'Смотреть занятия',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать расписание',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Занятия',
			// название меню
		],
		'public'        => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-calendar-alt',
		'hierarchical'  => FALSE,
		'supports'      => [ 'title' ],
		'has_archive'   => TRUE,
	] );

	register_taxonomy( 'shedule_days', [ 'shedules' ], [
		'labels'       => [
			'name'          => 'Дни недели',
			'singular_name' => 'День',
			'search_items'  => 'Найти день недели',
			'all_items'     => 'Все дни недели',
			'view_item '    => 'Посмотреть дни недели',
			'edit_item'     => 'Редактировать дни недели',
			'update_item'   => 'Обновить',
			'add_new_item'  => 'Добавить день недели',
			'new_item_name' => 'Добавить день недели',
			'menu_name'     => 'Все дни недели',
		],
		'description'  => '',
		'public'       => TRUE,
		'hierarchical' => TRUE,
	] );

	register_taxonomy( 'places', [ 'shedules' ], [
		'labels'       => [
			'name'          => 'Залы',
			'singular_name' => 'Залы',
			'search_items'  => 'Найти залы',
			'all_items'     => 'Все залы',
			'view_item '    => 'Посмотреть залы',
			'edit_item'     => 'Редактировать залы',
			'update_item'   => 'Обновить',
			'add_new_item'  => 'Добавить залы',
			'new_item_name' => 'Добавить залы',
			'menu_name'     => 'Все залы',
		],
		'description'  => '',
		'public'       => TRUE,
		'hierarchical' => TRUE,
	] );

	register_post_type( 'prices', [
		'labels'        => [
			'name'               => 'Цены',
			// основное название для типа записи
			'singular_name'      => 'Цена',
			// название для одной записи этого типа
			'add_new'            => 'Добавить новую цену',
			// для добавления новой записи
			'add_new_item'       => 'Добавить новую цену',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать цену',
			// для редактирования типа записи
			'new_item'           => 'Новая цена',
			// текст новой записи
			'view_item'          => 'Смотреть цены',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать цены',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Цены',
			// название меню
		],
		'public'        => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-money-alt',
		'hierarchical'  => FALSE,
    'show_in_rest'    => TRUE,
		'supports'      => [ 'title', 'editor' ],
		'has_archive'   => TRUE,
	] );

	register_post_type( 'cards', [
		'labels'        => [
			'name'               => 'Карты',
			// основное название для типа записи
			'singular_name'      => 'Карта',
			// название для одной записи этого типа
			'add_new'            => 'Добавить новую карту',
			// для добавления новой записи
			'add_new_item'       => 'Добавить новую карту',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать карту',
			// для редактирования типа записи
			'new_item'           => 'Новая карта',
			// текст новой записи
			'view_item'          => 'Смотреть карты',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать карты',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Карты',
			// название меню
		],
		'public'        => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-tickets-alt',
		'hierarchical'  => FALSE,
		'supports'      => [ 'title' ],
		'has_archive'   => FALSE,
	] );

	register_post_type( 'orders', [
		'labels'        => [
			'name'               => 'Заявки',
			// основное название для типа записи
			'singular_name'      => 'Заявка',
			// название для одной записи этого типа
			'add_new'            => 'Добавить новую заявку',
			// для добавления новой записи
			'add_new_item'       => 'Добавить новую заявку',
			// заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать заявку',
			// для редактирования типа записи
			'new_item'           => 'Новая заявка',
			// текст новой записи
			'view_item'          => 'Смотреть заявки',
			// для просмотра записи этого типа.
			'search_items'       => 'Искать заявки',
			// для поиска по этим типам записи
			'not_found'          => 'Не найдено',
			// если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине',
			// если не было найдено в корзине
			'parent_item_colon'  => '',
			// для родителей (у древовидных типов)
			'menu_name'          => 'Заявки',
			// название меню
		],
		'public'        => FALSE,
		'show_ui'       => TRUE,
		'show_in_menu'  => TRUE,
		'menu_position' => 20,
		'menu_icon'     => 'dashicons-format-chat',
		'hierarchical'  => FALSE,
		'supports'      => [ 'title' ],
		'has_archive'   => FALSE,
	] );
}

//Добавление кастомных полей к записи (в админке)
add_action( 'add_meta_boxes', 'si_add_meta_boxes' );
function si_add_meta_boxes() {
	add_meta_box(
		'si_like_meta_box',
		'Количество лайков: ',
		'si_like_meta_box_callback',
		'post',
	);

	$order_fields = [
		'si_order_date'   => 'Дата заявки: ',
		'si_order_name'   => 'Имя клиента: ',
		'si_order_phone'  => 'Номер телефона: ',
		'si_order_choice' => 'Выбор клиента: ',
	];

	foreach ( $order_fields as $key => $value ) {
		add_meta_box(
			$key,
			$value,
			'si_orders_fields_meta_box_callback',
			'orders',
			'advanced',
			'default',
			$key
		);
	}
}
function si_like_meta_box_callback( $post_obj ) {
	$likes = get_post_meta( $post_obj->ID, 'si_like', TRUE );
	$likes = $likes ? $likes : 0;

	//	echo "<input type='text' name='si_like' value='$likes' />";
	echo '<p>' . $likes . '</p>';
}
function si_orders_fields_meta_box_callback( $post_obj, $args ) {
	$slag =  $args['args'];
  $order_data = '';

	switch ( $slag ) {
		case 'si_order_date':
      $order_data = $post_obj->post_date;
			break;
		case 'si_order_choice':
      $id = get_post_meta( $post_obj->ID, $slag, TRUE );
      $title = get_the_title($id);
      $type = get_post_type_object(get_post_type($id))->labels->name;
      $order_data = ' Клиент выбрал: <strong>' . $title . '</strong>' . '<br>' . 'из раздела <strong>' . $type . ' </strong>';
			break;
		default:
			$order_data = get_post_meta( $post_obj->ID, $slag, TRUE );
			$order_data = $order_data ? $order_data : 'Нет данных';
			break;
	}
	echo '<p>' . $order_data . '</p>';
}

add_action( 'save_post', 'si_save_meta_box_data' );
function si_save_meta_box_data( $post_id ) {
	if ( isset( $_POST['si_like'] ) ) {
		update_post_meta( $post_id, 'si_like', $_POST['si_like'] );
	}
}

add_action( 'admin_init', 'si_register_slogan' );
function si_register_slogan() {
	add_settings_field(
		'si_option_field_slogan',
		'Слоган сайта: ',
		'si_option_slogan_callback',
		'general',
		'default',
		[
			'label_for' => 'si_option_field_slogan',
		]
	);
	register_setting(
		'general',
		'si_option_field_slogan',
		'strval'
	);
}
function si_option_slogan_callback( $args ) {
	?>
  <input
    type="text"
    id="<?php echo esc_attr( $args['label_for'] ); ?>"
    value="<?php echo get_option( $args['label_for'] ); ?>"
    name="<?php echo esc_attr( $args['label_for'] ); ?>"
    class="regular-text code"
  >
	<?php
}

//Обработка модального окна с формой
add_action( 'admin_post_nopriv_' . 'si_modal_form', 'si_modal_form_handler' );
add_action( 'admin_post_' . 'si_modal_form', 'si_modal_form_handler' );

function si_modal_form_handler() {
	//echo 'Все получили!!!';
	$choice_id    = $_POST['form-post-id'] ? $_POST['form-post-id'] : 'empty';
	$clients_name = $_POST['si-user-name'] ? $_POST['si-user-name'] : 'Аноним';
	$phone_number = $_POST['si-user-phone'] ? $_POST['si-user-phone'] : FALSE;

	if ( $phone_number ) {
		$choice_id    = wp_strip_all_tags( $choice_id );
		$clients_name = wp_strip_all_tags( $clients_name );
		$phone_number = wp_strip_all_tags( $phone_number );

		$new_records_id = wp_insert_post( wp_slash( [
			'post_title'  => 'Заявка № ',
			'post_type'   => 'orders',
			'post_status' => 'publish',
			'meta_input'  => [
				'si_order_name'   => $clients_name,
				'si_order_phone'  => $phone_number,
				'si_order_choice' => $choice_id,
			],
		] ) );

    if ( $new_records_id !== 0) {
      wp_update_post( [
        'ID' => $new_records_id,
          'post_title'  => 'Заявка № ' . $new_records_id,
      ] );

      update_field('orders_status', 'new', $new_records_id);

    }
	}


	header( 'Location:' . home_url() );
}

//Обработка нажатия кнопки Like
add_action( 'wp_ajax_nopriv_' . 'post_likes', 'si_post_like_handler' );
add_action( 'wp_ajax_' . 'post_likes', 'si_post_like_handler' );
function si_post_like_handler() {
	//	echo 'Все получили !!!';

	$id           = $_POST['id'];
	$todo         = $_POST['todo'];
	$current_data = get_post_meta( $id, 'si_like', TRUE );
	$current_data = $current_data ? $current_data : 0;

	if ( $todo === 'plus' ) {
		$current_data ++;
	} else {
		$current_data --;
	}
	$res = update_post_meta( $id, 'si_like', $current_data );
	if ( $res ) {
		echo $current_data;
		wp_die();
	} else {
		wp_die( 'Лайк не сохранился. попробуйте еще раз', 500 );
	}
}

// добавляем колонку Лайки в аминку (таблица записей)
add_action( 'manage_posts_custom_column', 'si_post_like_column_for_admin', 5, 2 );
add_filter( 'manage_posts_columns', 'si_add_col_likes' );
function si_post_like_column_for_admin( $column_name, $id ) {
	if ( $column_name == 'col_likes' ) {
		$likes_number = get_post_meta( $id, 'si_like', TRUE );
		echo $likes_number ? $likes_number : 0;
	}
}
function si_add_col_likes( $default_columns ) {
	$type = get_current_screen()->post_type;
	if ( $type === 'post' ) {
		$default_columns['col_likes'] = 'Лайки';
	}

	return $default_columns;
}

// Добавляем колонку Статус в табицу заказов админпанели

add_filter( 'manage_posts_columns', 'si_add_column_orders_status' );
function si_add_column_orders_status( $default_columns ) {
  $type = get_current_screen()->post_type;
  if ( $type === 'orders' ) {
//    $default_columns['orders_status'] = 'Статус';
      $default_columns =  array_slice( $default_columns, 0, 2 ) +
                          ['orders_status' => 'Статус'] +
                          ['managers_comment' => 'Комментарий'] +
                          $default_columns;
  }
  return $default_columns;
}

add_action( 'manage_posts_custom_column', 'si_fill_orders_status_column_for_admin', 5, 2 );
function si_fill_orders_status_column_for_admin( $column_name, $id ): void {

  if ( $column_name === 'orders_status' ) {

    $orders_status = get_field('orders_status', $id);
    $orders_status['label'] = $orders_status['label'] ?: '';

	  $status_color_class = match ( $orders_status['value'] ) {
		  'new' => 'si_font_red',
		  'done' => 'si_font_green',
		  'processing' => 'si_font_blue'
	  };

    echo ' <span class="' . $status_color_class . '">' . $orders_status['label'] . '</span>';

  }

	if ( $column_name === 'managers_comment' ) {
		$orders_comment = get_field( 'orders_comment', $id ) ?: '';
		echo ' <span>' . $orders_comment . '</span>';
	}
}
// подправим стиль колонки через css
add_action('admin_head', 'add_views_column_css');
function add_views_column_css(): void {
	echo '<style>.column-views{ width:10%; }</style>';
  echo '<style>.si_font_red{ color:#ff0000; }</style>';
  echo '<style>.si_font_green{ color:#00ff00; }</style>';
  echo '<style>.si_font_blue{ color:#0000ff; }</style>';
}
