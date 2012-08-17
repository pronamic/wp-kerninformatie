<?php if ( $answers->count() > 0 ): ?>
	
	<ul class="kerninformatie-answers-list">
		<?php foreach ( $answers->answer as $answer ): ?>
			<li itemprop="reviews" itemscope itemtype="http://schema.org/Review">
				<p class="meta">
					<?php 
					
					printf(
						__( '%s from %s says on %s:' , 'kerninformatie' ) , 
						sprintf(
							'<strong itemprop="author">%s</strong>' , 
							$answer->guest->lastname
						) ,
						sprintf(
							'<strong itemprop="location">%s</strong>' , 
							$answer->guest->city
						) , 
						sprintf(
							'<time itemprop="datePublished" time>%s</time>' ,
							$answer->date
						)
					);
	
					?>
				</p>
	
				<div itemprop="description" class="description">
					<?php echo wpautop( $answer->comment ); ?>
				</div>
				
				<dl>
					<dt><?php _e( 'Arrival Date', 'kerninformatie' ); ?></dt>
					<dd><?php echo $answer->guest->arrival_date; ?></dd>
					
					<dt><?php _e( 'Leave Date', 'kerninformatie' ); ?></dt>
					<dd><?php echo $answer->guest->arrival_date; ?></dd>
				</dl>
			</li>
		<?php endforeach; ?>
	</ul>

<?php endif; ?>