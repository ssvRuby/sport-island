<?php
/*
 Template Name: Шаблон для главной страницы

 */
get_header();
?>
    <main class="main-content">
    <h1 class="sr-only"> Домашняя страница спортклуба SportIsland. </h1>
    <div class="banner">
        <span class="sr-only">Будь в форме!</span>
<!-----------------------------------------------------------------------------------------------------------------------         -->
<!-- Стандартный вариант вывода кнопки -->
<!--        <a href="--><?php //echo get_post_type_archive_link('services') ?><!--" class="banner__link btn">записаться</a>-->

<!-----------------------------------------------------------------------------------------------------------------------        -->
<!-- Учебный вариант вывода кнопки через механизм меню-->
	    <?php
	    $menu_item = wp_get_nav_menu_items( get_nav_menu_locations()['central_menu'] )[0];
	    ?>
	    <?php if ( $menu_item ) { ?>
            <nav class="main-navigation">
                <ul class="main-navigation__list">
                    <li>
                        <a href="<?php echo $menu_item->url; ?>" class="banner__link btn">
						    <?php echo $menu_item->title; ?>
                        </a>
                    </li>
                </ul>
            </nav>
	    <?php } ?>
<!------------------------------------------------------------------------------------------------------------------------->

<!--Вариант с использованием механизма меню и функции wp_nav_menu()  - все работает, но слетает настройка цвета в кнопке,-->
<!--        -->
	  <!--  --><?php
/*	    wp_nav_menu( [
		    'theme_location'  => 'central_menu',
		    'container'       => 'nav',
		    'container_class' => 'main-navigation',
		    'menu_class'      => 'banner__link btn',
		    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
	    ] )
	    */?>
<!------------------------------------------------------------------------------------------------------------------------->
<!-- Учебный вариант вывода кнопки через механизм виджетов-->

<!--        --><?php
//	    if ( is_active_sidebar( 'si_banner_button_sidebar' ) ) {
//		    dynamic_sidebar( 'si_banner_button_sidebar' );
//	    }
//	    ?>
<!-----------------------------------------------------------------------------------------------------------------------        -->
    </div>
	    <?php
	    if ( is_active_sidebar( 'si_post_for_main_page_sidebar' ) ) {
		    dynamic_sidebar( 'si_post_for_main_page_sidebar' );
	    } else {
		    $post_about = get_post( 109 );
		    if ( $post_about ): ?>
                <article class="about">
                    <div class="wrapper about__flex">
                        <div class="about__wrap">
                            <h2 class="main-heading about__h">
							    <?php echo $post_about->post_title ?>
                            </h2>
                            <p class="about__text">
							    <?php echo $post_about->post_excerpt ?>
                            </p>
                            <a href="<?php echo get_the_permalink( $post_about->ID ); ?>"
                               class="about__link btn">подробнее</a>
                        </div>
                        <figure class="about__thumb">
						    <?php echo get_the_post_thumbnail( $post_about->ID, 'full' ); ?>
                        </figure>
                    </div>
                </article>
		    <?php endif;
	    }
	    ?>
<!-- ===================================================================  -->
	    <?php $actions = get_posts( [
		    'numberposts'   => - 1,
		    'category_name' => 'action',
		    'meta_key'      => 'real_action',
		    'meta_value'    => '1',
	    ] );
	    if ( $actions ) {
		    ?>
          <section class="sales">
            <div class="wrapper">
              <header class="sales__header">
                <h2 class="main-heading sales__h"> акции и скидки </h2>
                <p class="sales__btns">
                  <button class="sales__btn sales__btn_prev">
                    <span class="sr-only"> Предыдущие акции </span>
                  </button>
                  <button class="sales__btn sales__btn_next">
                    <span class="sr-only"> Следующие акции </span>
                  </button>
                </p>
              </header>
              <div class="sales__slider slider">
			      <?php
			      global $post;
			      foreach ( $actions as $post ) {
				      setup_postdata( $post );
				      ?>
                    <section class="slider__slide stock">
                      <a href="<?php the_permalink(); ?>" class="stock__link"
                         aria-label="Подробнее об акции скидка 20% на групповые занятия">
					      <?php the_post_thumbnail( 'full', [ 'class' => 'stock__link' ] ); ?>
                        <h3 class="stock__h"> <?php the_title(); ?> </h3>
                        <p
                          class="stock__text"> <?php echo get_the_excerpt(); ?> </p>
                        <span class="stock__more link-more_inverse link-more">Подробнее</span>
                      </a>
                    </section>
				      <?php
			      }
			      wp_reset_postdata(); ?>
              </div>
            </div>
          </section>
		    <?php
	    } ?>


<!-- ===================================================================  -->
	    <?php $query = new WP_Query( [
	      'numberposts' => - 1,
	      'post_type'   => 'cards',
	      'meta_key'    => 'card_order',
	      'orderby'     => 'meta_value_num',
	      'order'       => 'ASC',
	    ] );

      if ( $query->have_posts() ) {
	      ?>

        <section class="cards cards_index">
          <div class="wrapper">
            <h2 class="main-heading cards__h"> клубные карты </h2>
            <ul class="cards__list row">
		        <?php while ( $query->have_posts() ) {
              $query->the_post();
              $profit_class = '';

              if (get_field('club_profit')) {
                $profit_class = ' card_profitable';
              }

              $benefits_list = get_field('preimushhestva');
              $benefits_list = explode('\n', $benefits_list);

              $default_bg_image = _si_assets_path('img/index__cards_card1.jpg');
              $bg_image = get_field('club_bgr_image');
		          $bg_image = $bg_image ? sprintf( "style=\"background-image: url(%s)\";", $bg_image ) :
		          sprintf( "style=\"background-image: url(%s)\";", $default_bg_image );
			        ?>
                  <li class="card <?php echo $profit_class; ?>" <?php echo $bg_image; ?> >
                    <h3 class="card__name"> <?php  the_title(); ?> </h3>
                    <p class="card__time">
                      <?php  the_field('club_start_time'); ?>
                      &ndash;
                      <?php  the_field('club_time_end'); ?>
                    </p>
                    <p class="card__price price">
                      <?php  the_field('club_price'); ?>
                      <span class="price__unit" aria-label="рублей в месяц">р.-/мес.</span>
                    </p>
                    <ul class="card__features">
	                    <?php foreach ( $benefits_list as $benefit ) { ?>
                          <li class="card__feature">
                            <?php echo $benefit; ?>
                          </li>
	                    <?php } ?>
                    </ul>
                    <a data-post-id="<?php echo $id; ?>" href="#modal-form"
                       class="card__buy btn btn_modal">купить</a>
                  </li>
			        <?php
		        }
            wp_reset_postdata();
		        ?>
            </ul>
          </div>
        </section>
	      <?php
      }
      ?>
</main>
<?php
get_footer();
?>

