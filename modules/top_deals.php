<section id="deals" class="deals-section custom-products-design">
    <div class="container">
        <?php if(get_row_layout() == 'top_deals'){
            $top_deal_main_title=get_sub_field('top_deal_main_title');
            $top_deal_sub_title=get_sub_field('top_deal_sub_title');
            $top_deal_content=get_sub_field('top_deal_content');
            ?>
        <div class="deal-top section-top">
            <div class="section-top-left">
                <h2><?php echo $top_deal_main_title; ?></h2>
                <h3><?php echo $top_deal_sub_title; ?></h3>
            </div>
            <div class="section-top-right">
                <a href="/vacspecs/products/top-deals/" class="btn btn-dark">View all<i class="icon-chevron-right"></i></a>
            </div>
        </div>
       

        <div class="deal-wrapper">
            <div class="deals-content">
            <?php echo $top_deal_content; ?>
            </div>  
        </div>    
         
    </div>

    <?php };?>
</section>