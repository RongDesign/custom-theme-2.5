<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

                    <div id="main" class="twelvecol first clearfix" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                            <section class="entry-content clearfix" itemprop="articleBody">
                                <?php the_content(); ?>
                            </section>

                        </article>

                        <?php endwhile; else : ?>

                                <article id="post-not-found" class="hentry clearfix">
                                        <header class="article-header">
                                            <h1><?php _e( 'Oops, Post Not Found!', 'webdraftertheme' ); ?></h1>
                                    </header>
                                        <section class="entry-content">
                                            <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'webdraftertheme' ); ?></p>
                                    </section>
                                    <footer class="article-footer">
                                            <p><?php _e( 'This is the error message in the page-custom.php template.', 'webdraftertheme' ); ?></p>
                                    </footer>
                                </article>

                        <?php endif; ?>

                    </div>

				</div>

			</div>

<?php get_footer(); ?>
