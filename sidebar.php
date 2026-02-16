<div class="col-12 col-md-3 mt-4 mt-md-0 Sidebar justify-content-center " id="sidebar">
    <?php
    global $wp_query;
    if (is_tax('product_cat')) {
        $current_cat = $wp_query->queried_object;
        $cats = get_terms(
            'product_cat',
            array(
                'parent' => $current_cat->term_id,
                'hierarchical' => true,
                'hide_empty' => false,
            )
        );
        if ($cats) {
            ?>
            <div class="card bg-light mb-3" >
                <h5 class="card-header sidebar_head_title h7"> children : <a href="<?= site_url('/cat/') . $current_cat->slug ?>"><?= $current_cat->name ?></a>
                </h5>
                <div class="card- bg-white">
                    <ul class="list-group list-group-flush w-100 list-unstyled">
                        <?php
                        foreach ($cats as $cat) {
                            ?>
                            <li class="list-group-item bg-transparent h8 d-flex justify-content-between align-items-center mt-2">
                                <a class="h8"  href="<?= get_term_link($cat->term_id) ?>"><?= $cat->name ?></a>
                                <span class="badge "><?= $cat->count?></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
        }
    }


    ?>
    <div class="sidebar-shop">
        <?php dynamic_sidebar('sidebar'); ?>
    </div>
</div>
