<table class="kerninformatie-scores-table">
	<thead>
		<tr>
			<th scope="col"><?php _e( 'Description', 'kerninformatie' ); ?></th>
			<th scope="col"><?php _e( 'Score', 'kerninformatie' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $scores->group as $score ): ?>
			<tr>
				<td><?php echo $score->description; ?></td>
				<td><?php echo $score->score; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>