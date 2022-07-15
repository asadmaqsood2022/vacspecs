<section id="featured" class="container-fluid featured-section custom-products-design">
    <div class="container">
        <?php if(get_row_layout() == 'featured'){
            $featuredtitle=get_sub_field('featured_title');
            $featuredcontent=get_sub_field('featured_content');
            ?>
        <div class="featured-top section-featured section-top">
            <div class="section-featured-left">
                <h2><?php echo $featuredtitle; ?></h2>
            </div>
            <div class="section-featured-right">
                <a href="/shop/" class="btn btn-dark">View all New Products<i class="icon-chevron-right"></i></a>
            </div>
        </div>
       
   
        <div class="featured-wrapper">
            <div class="featured-content">
            <?php echo $featuredcontent; ?>
            </div>  
        </div>    
         
    </div>

    <?php };?>
</section>