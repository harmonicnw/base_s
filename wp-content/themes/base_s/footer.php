<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Harmonic Northwest Underscores Base Theme
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'hnw_base_s' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'hnw_base_s' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'hnw_base_s' ), 'Harmonic Northwest Underscores Base Theme', '<a href="http://www.harmonicnw.com" rel="designer">Harmonic Northwest</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
