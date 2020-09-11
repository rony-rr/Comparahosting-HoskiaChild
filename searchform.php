<div class="search--widget bg-color--alabaster">
	<form action="<?php echo esc_url( site_url( '/' ) ); ?>" method="get">
		<div class="input-group">
			<input type="text" name="s" class="form-control" placeholder="<?php esc_html_e( "Explorar", 'hoskia' ); ?>" required />
			
			<span class="input-group-addon">
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>
</div>