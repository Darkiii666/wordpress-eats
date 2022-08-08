<?php use wp_eats\Invoice;
use wp_eats\WP_Eats;

include "parts/header.php";?>

<main class="wp-eats__content wp-eats__content--invoices-list">

    <div class="wp-eats__title-wrap">
        <h1 class="wp-eats__title"><?php echo get_the_title()?></h1>
    </div>
    <form action="" method="GET">
        <?php wp_nonce_field( 'wp_eats_invoice_list', 'wp_eats_nonce' );
        ?>

        <div class="wp-eats__filters wp-eats__filters--invoices row my-3 g-3 align-items-end">
            <div class="wp-eats__status-filters col col-md-4 flex-fill align-self-start">
                <?php
                $statuses = array("all" => __("All", "wp-eats"));
                $statuses = array_merge($statuses, Invoice::get_invoice_statuses());
                if (isset($_REQUEST["invoice-status"]) && isset($statuses[$_REQUEST['invoice-status']])){
                    $current_status = $_REQUEST['invoice-status'];
                } else {
                    $current_status = "all";
                }
                foreach ($statuses as $status_key => $status):?>

                    <span class="wp-eats__status-filter">
                        <input autocomplete="off" class="btn-check" id="filter_status_<?php echo esc_attr($status_key);?>" type="radio" name="invoice_status" value="<?php echo $status_key?>"<?php if($status_key == $current_status) echo ' checked="true"'?>>
                        <label for="filter_status_<?php echo esc_attr($status_key);?>" class="btn btn-sm wp-eats__status-filter-text"><?php echo $status?></label>
                    </span>
                <?php endforeach;?>

            </div>
            <div class="wp-eats__date-filters col-md-3">
                <?php
                if (@strtotime($_REQUEST['date-from']) && @strtotime($_REQUEST['date-to'])) {
                    $date_from = $_REQUEST["date-from"];
                    $date_to = $_REQUEST["date-to"];
                } else {
                    $date_from = date(WP_Eats::get_format_date());
                    $date_to = date(WP_Eats::get_format_date(), strtotime('midnight +30 day', time()));
                }
                ?>
                <div class="input-group wp-eats__date-filters-wrap">
                    <span class="input-group-text">
                        <span class="me-2 lh-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
  <path fill="#6c7481" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
</svg>
                        </span>
                         <?php _ex("From", "Invoices from date", "wp-eats")?></span>
                    <input class="form-control" name="date-range" type="text" value="<?php echo esc_attr($date_from) . " → " . esc_attr($date_to)?>">
                </div>


            </div>
            <div class="wp-eats__search-filter col">
                <div class="input-group">


                <span class="input-group-text bg-white pe-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path fill="#6c7481" d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg>
                           </span>
                <input class="form-control border-start-0" type="text" name="search-name" value="<?php echo @esc_attr($_REQUEST['search-name'])?>" placeholder="<?php _e("Search", "wp-eats")?>">
                </div>
            </div>
            <div class="wp-eats__actions col">
                <button class="btn btn-primary button button--mark-as-paid"><?php _e("Mark as paid")?></button>
            </div>
        </div>
        <div class="wp-eats__list wp-eats__list--invoices">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            <input class="form-check-input" type="checkbox" value="" id="selectAll">
                            <label class="form-check-label" for="selectAll"></label>
                        </th>
                        <th scope="col"><?php _e("ID","wp-eats")?></th>
                        <th scope="col"><?php _e("Restaurant","wp-eats")?></th>
                        <th scope="col"><?php _e("Status","wp-eats")?></th>
                        <th scope="col"><?php _e("Start Date","wp-eats")?></th>
                        <th scope="col"><?php _e("End Date","wp-eats")?></th>
                        <th scope="col"><?php _e("Total","wp-eats")?></th>
                        <th scope="col"><?php _e("Fees","wp-eats")?></th>
                        <th scope="col"><?php _e("Transfer","wp-eats")?></th>
                        <th scope="col"><?php _e("Orders","wp-eats")?></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_REQUEST)) $invoice_args = WP_Eats::parse_invoices_list_request($_REQUEST);
                    else $invoice_args = array();
                    $invoices_query = WP_Eats::get_invoice_list($invoice_args);
                    $invoices = $invoices_query->posts;
                    foreach ($invoices as $invoice):
                        $invoice = new Invoice($invoice);
                        $dates = $invoice->get_invoice_dates(WP_Eats::get_format_date());
                        $prices = $invoice->get_invoice_prices();
                        ?>
                    <tr>
                        <td class="wp-eats__table-data">
                            <input class="form-check-input" name="posts[]" type="checkbox" value="<?php echo esc_attr($invoice->ID);?>" id="checkbox-<?php echo esc_attr($invoice->ID);?>">
                            <label class="form-check-label" for="checkbox-<?php echo esc_attr($invoice->ID);?>"></label>
                        </td>
                        <td class="wp-eats__table-data">#<?php echo $invoice->ID?></td>
                        <td class="wp-eats__table-data wp-eats__table-data--company">
                            <?php $company = get_post($invoice->get_company()); ?>
                            <div class="wp-eats__company-image"><?php echo get_the_post_thumbnail($company, 'company-thumbnail')?></div>
                            <div class="wp-eats__company-name"><?php echo $company->post_title?></div>
                        </td>
                        <td class="wp-eats__table-data"><span class="wp-eats__status-name wp-eats__status-name--<?php echo $invoice->get_invoice_status();?>"><?php echo $invoice->get_invoice_status_name()?></span></td>
                        <td class="wp-eats__table-data"><?php echo $dates['start_date']?></td>
                        <td class="wp-eats__table-data"><?php echo $dates['end_date'] ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['total']) ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['fees']) ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['transfer']) ?></td>
                        <td class="wp-eats__table-data"><?php // for now hardcoded ?> 20</td>
                        <td class="wp-eats__table-data"><a href=""><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                    <path fill="#ff9500" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                    <path fill="#ff9500" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                                </svg></a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="15">
                        <div class="wp-eats__table-footer">
                            <div class="wp-eats__table--page-counter">
                                <?php
                                $paged = get_query_var('paged');
                                if ($paged < 2) $paged = 1;
                                echo __("Page", "wp-eats") . ' ' . $paged . ' ' . __("of", "wp-eats") . ' ' . $invoices_query->max_num_pages;
                                ;?>
                            </div>
                            <div class="wp-eats__table-pagination">
                                <?php $pagination = paginate_links( array(
                                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                    'total'        => $invoices_query->max_num_pages,
                                    'current'      => max( 1, get_query_var( 'paged' ) ),
                                    'format'       => '?paged=%#%',
                                    'show_all'     => true,
                                    'type'         => 'plain',
                                    'end_size'     => 2,
                                    'mid_size'     => 1,
                                    'prev_next'    => true,
                                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Prev', 'text-domain' ) ),
                                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'text-domain' ) ),
                                    'add_args'     => true,
                                    'add_fragment' => '',
                                ) );
                                echo $pagination;
                                ?>
                            </div>
                        </div>

                    </td>
                </tr>


                </tfoot>
            </table>
        </div>
    </form>
</main>

<?php include "parts/footer.php"?>
