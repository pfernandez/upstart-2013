						
						
						<div class="blog-text">	
							<?php if( is_single() ) {} else { ?>
								<div class="title-meta">
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								</div>
							<?php } ?>
							
							<div class="blog-entry">
								<div class="blog-content">
									<?php if( is_search() || is_archive() || ! is_single() ) { ?>
										<div class="excerpt-more">
											<?php the_excerpt(__( 'Read More','okay')); ?>
										</div>
									<?php } else { ?>
										<?php the_content(__( 'Read more...', 'okay' )); ?>	
									<?php } ?>
								</div>
							</div><!-- blog entry -->
						</div><!-- blog text -->
						
						<div class="blog-meta">
						
						    <?php if ( get_post_meta( $post->ID, 'okvideo', true ) ) { ?>
							<div class="okvideo">
								<?php echo get_post_meta( $post->ID, 'okvideo', true ) ?>
							</div>
						<?php } else { ?>
						
							<?php if ( has_post_thumbnail() ) { ?>
								<a class="blog-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'blog-image' ); ?></a>
							<?php } ?>
						
						<?php } ?>
						
							<ul class="meta-links">
						    	<li><?php echo get_the_date('m/d/Y'); ?></li>
						    	<li><?php the_author_posts_link(); ?></li>
						    	<li><a href="<?php the_permalink(); ?>#comments"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></li> 
						    </ul>
							
							<?php if( is_single() ) { ?>
								<ul class="meta-links">
									<li class="share-title"><?php _e('Category:','okay'); ?></li>
									<li>
										<?php the_category('<br/>') ?>
									</li>
									<?php /*							
										$post_tags = wp_get_post_tags( $post->ID );
										if( !empty( $post_tags ) ) {
									?>
										<li></li>
										<li class="share-title meta-tag-title"><?php _e('Tag:','okay'); ?></li>
										<li>
											<?php the_tags('', '<br />', ''); ?> 
										</li>
									<?php } */ ?>
								</ul>
							<?php } ?>
							
							<?php if( is_search() || is_archive() || is_attachment() ) {} else { ?>
								<ul class="meta-links">
									<li class="share-title"><?php _e('Share:','okay'); ?></li>
									<li class="twitter">
										<a onclick="window.open('http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="<?php the_title(); ?>" target="blank"><?php _e('Twitter','okay'); ?></a>
									</li>
									
									<li class="facebook">
										<a onclick="window.open('http://www.facebook.com/share.php?u=<?php the_permalink(); ?>','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" title="<?php the_title(); ?>"  target="blank"><?php _e('Facebook','okay'); ?></a>
									</li>
									
									<li class="googleplus">
										<a class="share-google" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;"><?php _e('Google+','okay'); ?></a>
									</li>
								</ul>
							<?php } ?>
						</div><!-- blog meta -->
