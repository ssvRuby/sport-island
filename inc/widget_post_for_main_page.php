<?php

class SI_post_for_main_page extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'SI_post_for_main_page',
			'SI пост для главной страницы',
			array(
				'description' => 'Display post on main page',
				'classname'   => 'SI_post_for_main_page',
			)
		);
	}

	function form( $instance ) {
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_for_main_page_id' ); ?>">
                Выберите запись для главной страницы:
            </label>

            <select
                    id="<?php echo $this->get_field_id( 'post_for_main_page_id' ); ?>"
                    name="<?php echo $this->get_field_name( 'post_for_main_page_name' ); ?>"
                    class="wide fat"
            >
				<?php
				$my_posts = get_posts( array(
					'numberposts'      => - 1,
					'category'         => 0,
					'orderby'          => 'date',
					'order'            => 'DESC',
					'include'          => array(),
					'exclude'          => array(),
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => 'post',
					'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
				) );


				foreach ( $my_posts as $my_post ) {
					setup_postdata( $my_post );
					?>

                    <option value="<?php echo $my_post->ID; ?>"
						<?php selected( $instance['post_for_main_page_name'], $my_post->post_title, true ); ?>
                    >
						<?php echo $my_post->post_title; ?>
                    </option>
					<?php
				}
				wp_reset_postdata(); ?>
            </select>
        </p>
		<?php
	}

	function widget( $args, $instance ) {
		$main_post_id = $instance['post_for_main_page_name'];
		$main_post    = get_post( $main_post_id );
		?>
        <article class="about">
            <div class="wrapper about__flex">
                <div class="about__wrap">
                    <h2 class="main-heading about__h">
						<?php echo $main_post->post_title ?>
                    </h2>
                    <p class="about__text">
						<?php echo $main_post->post_excerpt ?>
                    </p>
                    <a href="<?php echo get_the_permalink( $main_post->ID ); ?>" class="about__link btn">подробнее</a>
                </div>
                <figure class="about__thumb">
					<?php echo get_the_post_thumbnail( $main_post->ID, 'full' ); ?>
                </figure>
            </div>
        </article>
		<?php
	}

	function update( $new_instance, $old_instance ) {
        return $new_instance;
	}


}