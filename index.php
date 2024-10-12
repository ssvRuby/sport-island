<?php

get_header();

if ( is_home() ): ?>
    <main class="main-content">
        <h1 class="sr-only">Страница категорий блога на сайте спорт-клуба SportIsland</h1>
        <div class="wrapper">
			<?php get_template_part( 'templates/breadcrumbs', 'none' ); ?>
        </div>
		<?php
		// Запускаем цикл WP =================================================>
		if ( have_posts() ): ?>
            <section class="last-posts">
                <div class="wrapper">
                    <h2 class="main-heading last-posts__h"> Последние записи </h2>
                    <ul class="posts-list">
						<?php while ( have_posts() ):
							the_post(); ?>
                            <li class="last-post">
                                <a href="<?php the_permalink(); ?>"
                                   class="last-post__link"
                                   aria-label="Читать текст статьи: <?php the_title(); ?>">
                                    <figure class="last-post__thumb">
										<?php the_post_thumbnail( 'post-thumbnail', [ 'class' => 'post__img' ] ); ?>
                                    </figure>
                                    <div class="last-post__wrap">
                                        <h3 class="last-post__h"> <?php the_title(); ?> </h3>
                                        <p class="last-post__text">
											<?php echo get_the_excerpt(); ?>
                                        </p>
                                        <span class="last-post__more link-more">Подробнее</span>
                                    </div>
                                </a>
                            </li>
						<?php endwhile; ?>
                    </ul>
					<?php the_posts_pagination() ?>
                </div>
            </section>
		<?php else: ?>
			<?php get_template_part( 'templates/no-posts', 'none' ); ?>
		<?php endif; ?>

		<?php $categories = get_categories();
		if ( ! empty( $categories ) ): ?>
            <section class="categories">
                <div class="wrapper">
                    <h2 class="categories__h main-heading"> категории </h2>
                    <ul class="categories-list">
						<?php foreach ( $categories as $category ):
							$category_link = get_category_link( $category->term_id );
							$img = get_field( 'category_thumbnails', 'category_' . $category->term_id );
                            $img_url = $img['url'];
                            $img_alt = $img['alt'];
							?>
                            <li class="category">
                                <a href="<?php echo $category_link; ?>" class="category__link">
                                    <img
                                            src="<?php echo $img_url; ?>"
                                            alt="<?php echo $img_alt; ?>" class="category__thumb">
                                    <span class="category__name">
                                        <?php echo $category->name; ?>
                                    </span>
                                </a>
                            </li>
						<?php endforeach; ?>
                    </ul>
                </div>
            </section>
		<?php endif; ?>
    </main>
<?php else: ?>
    <main class="main-content">
        <h1 class="sr-only">Страница на сайте спорт-клуба SportIsland</h1>
        <div class="wrapper">
			<?php get_template_part( 'templates/breadcrumbs', 'none' ); ?>
        </div>
		<?php
		// Запускаем цикл WP =================================================>
		if ( have_posts() ): ?>
            <section class="last-posts">
                <div class="wrapper">
                    <h2 class="main-heading last-posts__h"> Последние записи </h2>
                    <ul class="posts-list">
						<?php while ( have_posts() ):
							the_post(); ?>
              <li class="last-post">
                <a href="<?php the_permalink(); ?>"
                   class="last-post__link"
                   aria-label="Читать текст статьи: <?php the_title(); ?>">
                  <figure class="last-post__thumb">
					  <?php the_post_thumbnail( 'post-thumbnail', [ 'class' => 'post__img' ] ); ?>
                  </figure>
                  <div class="last-post__wrap">
                    <h3 class="last-post__h"> <?php the_title(); ?> </h3>
                    <p class="last-post__text">
						<?php echo get_the_excerpt(); ?>
                    </p>
                    <span class="last-post__more link-more">Подробнее</span>
                  </div>
                </a>
              </li>
						<?php endwhile; ?>
                    </ul>
					<?php the_posts_pagination() ?>
                </div>
            </section>
		<?php else: ?>
			<?php get_template_part( 'templates/no-posts', 'none' ); ?>
		<?php endif; ?>

    </main>
<?php endif; ?>

<?php
get_footer();
?>