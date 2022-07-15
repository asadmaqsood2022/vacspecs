<?php
/* Rankmath breadcrumbs */
if (function_exists('rank_math_the_breadcrumbs')):
?>
<section id="breadcrumb" class="container-fluid breadcrumb px-0">
    <div class="container"><?php rank_math_the_breadcrumbs(); ?></div>
</section>
<?php
endif;