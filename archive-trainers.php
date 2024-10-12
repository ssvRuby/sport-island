<?php
get_header();
?>
<main class="main-content">
    <div class="wrapper">
		<?php get_template_part( 'templates/breadcrumbs', 'none' ); ?>
    </div>

	<?php if ( have_posts() ) : ?>
        <section class="trainers">
            <div class="wrapper">
                <h1 class="main-heading trainers__h">Тренеры</h1>
                <?php while ( have_posts() ) : the_post(); ?>
                  <ul class="trainers-list">
                    <li class="trainers-list__item">
                      <article class="trainer">
                        <img
                          src="<?php echo get_field( 'trainers_img' )['url']; ?>"
                          alt="<?php echo get_field( 'trainers_img' )['alt']; ?>"
                          class="trainer__thumb">
                        <div class="trainer__wrap">
                          <h2 class="trainer__name">
			                  <?php the_title(); ?>
                          </h2>
                          <p class="trainer__text">
			                  <?php the_field( 'trainer_description' ); ?>
                          </p>
                        </div>
                        <a data-post-id="<?php echo $id; ?>"
                           href="#modal-form"
                           class="trainer__subscribe btn btn_modal">
                          записаться
                        </a>
                      </article>
                    </li>

                  </ul>
                <?php endwhile; ?>
            </div>
        </section>
	<?php else: ?>
		<?php get_template_part( 'templates/no-posts', 'none' ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
?>
