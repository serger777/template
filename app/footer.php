<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package RealTo
 * @since RealTo 1.5
 */
?>
<!-- begin footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-sx-12"><?php dynamic_sidebar("footer widget 1");?></div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12"><?php dynamic_sidebar("footer widget 2");?></div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12"><?php dynamic_sidebar("footer widget 3");?></div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-sx-12"><?php dynamic_sidebar("footer widget 4");?></div>
        </div>
    </div>
</footer>

<!-- end footer -->
<?php wp_footer(); ?>

</body>
</html>