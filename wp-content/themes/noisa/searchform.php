<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' )); ?>">
	<fieldset>
		<input type="text" placeholder="<?php echo esc_attr( __( 'Search...', 'noisa' ) ) ?>" value="<?php get_search_query(); ?>" name="s" id="s" />
		<button type="submit" id="searchsubmit"><i class="icon icon-search"></i></button>
	</fieldset>
</form>