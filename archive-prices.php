<?php
get_header();
?>
    <main class="main-content">
      <h1 class="sr-only">Цены на наши услуги и клубные карты</h1>
      <div class="wrapper">
	      <?php get_template_part( 'templates/breadcrumbs', 'none' ); ?>
<!--      </div>-->
        <section class="prices">
          <h2 class="main-heading prices__h">Цены</h2>
          <?php
          if ( have_posts() ) :
	          while ( have_posts() ) : the_post();
		          if ( ! get_field( 'prices_show' ) ) {
			          continue;
		          }
              the_content();

          endwhile;
          else :
          get_template_part( 'templates/no-posts', 'none' );
          endif;
          ?>
        </section>

	    <?php $query = new WP_Query( [
		    'numberposts' => - 1,
		    'post_type'   => 'cards',
		    'meta_key'    => 'card_order',
		    'orderby'     => 'meta_value_num',
		    'order'       => 'ASC',
	    ] );

	    if ( $query->have_posts() ) {
		    ?>
<!--        <div class="wrapper">-->
          <section class="cards">
            <h2 class="main-heading cards__h"> клубные карты </h2>
            <ul class="cards__list row">
			    <?php while ( $query->have_posts() ) {
				    $query->the_post();
				    $profit_class = '';

				    if ( get_field( 'club_profit' ) ) {
					    $profit_class = ' card_profitable';
				    }

				    $benefits_list = get_field( 'preimushhestva' );
				    $benefits_list = explode( '\n', $benefits_list );

				    $default_bg_image = _si_assets_path( 'img/index__cards_card1.jpg' );
				    $bg_image         = get_field( 'club_bgr_image' );
				    $bg_image         = $bg_image ? "style=\"background-image: url(${bg_image})\";" :
					    "style=\"background-image: url(${default_bg_image})\";";
				    ?>
                  <li
                    class="card <?php echo $profit_class; ?>" <?php echo $bg_image; ?> >
                    <h3 class="card__name"> <?php the_title(); ?> </h3>
                    <p class="card__time">
					    <?php the_field( 'club_start_time' ); ?>
                      &ndash;
					    <?php the_field( 'club_time_end' ); ?>
                    </p>
                    <p class="card__price price">
					    <?php the_field( 'club_price' ); ?>
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

          </section>
            </div>
		    <?php
	    }
	    ?>
    </main>

<?php
get_footer();
?>

