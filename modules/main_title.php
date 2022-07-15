<section class="main-title">
    <div class="container">
        <?php if(get_row_layout() == 'main_title'){
            $title=get_sub_field('pagetitle');
            ?>
        <div class="main-top">
            <h2><?php echo $title; ?></h2>
        </div>
    </div>

    <?php };?>
</section>