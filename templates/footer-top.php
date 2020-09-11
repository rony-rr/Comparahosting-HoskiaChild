<!-- Contact Info Area Start -->
<div id="contactInfo">
	<div class="container">
		<!-- Contact Info Wrapper Start -->
		<div class="contact-info--wrapper">
			<div class="row reset-gutter">
				<?php 
				$contacts = hoskia_opt( 'hoskia_footertop_supports_contact' );
				$column = hoskia_opt( 'hoskia_footertop_supports_contact_col' );
				$col = '4';
				if( $column ){
					$col = $column;
				}

				foreach( $contacts as $contact ){
				?>
				<div class="col-xl-<?php echo esc_attr( $col );?>">
					<!-- Contact Info Item Start -->
					<div class="contact-info--item">
						<?php 						
						
						// Icon
						if( !empty( $contact['icon'] ) && empty( $contact['image'] )  ){
							echo '<div class="contact-info--icon">';
								echo '<i class="fa '.esc_attr( $contact['icon'] ).'"></i>';
							echo '</div>';
						}
						
						// Icon
						if( !empty( $contact['image'] ) ){
							echo '<div class="contact-info--icon">';
								echo hoskia_img_tag(
									array(
										'url' => esc_url( $contact['image'] )
									)
								);
								
							echo '</div>';
						}
						?>
						<div class="contact-info--content">
							<?php 
							// Title
							if( !empty( $contact['title'] ) ){
								echo hoskia_heading_tag(
									array(
										'tag' 	 => 'h2',
										'text' 	 => esc_html( $contact['title'] ),
										'class'  => 'h3',
									)
								);
							}
							// Text
							if( !empty( $contact['progress'] ) ){
								echo hoskia_paragraph_tag(
									array(
										'text' 	 => esc_html( $contact['progress'] ),
									)
								);
							}
							if( !empty( $contact['url'] ) ){
								echo hoskia_paragraph_tag(
									array(
										'text' 	 => esc_html( $contact['url'] ),
									)
								);
							}
							?>
						</div>
					</div>
					<!-- Contact Info Item End -->
				</div>
				<?php
				}
				?>
		
			</div>
		</div>
		<!-- Contact Info Wrapper End -->
	</div>
</div>
<!-- Contact Info Area End -->