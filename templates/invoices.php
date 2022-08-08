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

        <div class="wp-eats__filters wp-eats__filters--invoices">
            <div class="wp-eats__status-filters">
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
                        <input autocomplete="off" class="btn-check" id="<?php echo "filter_status_" . esc_attr($status_key);?>" type="radio" name="invoice_status" value="<?php echo $status_key?>"<?php if($status_key == $current_status) echo " checked"?>>
                        <label for="<?php echo "filter_status_" .  esc_attr($status_key);?>" class="btn wp-eats__status-filter-text"><?php echo $status?></label>
                    </span>
                <?php endforeach;?>

            </div>
            <div class="wp-eats__date-filters">
                <?php
                if (@strtotime($_REQUEST['date-from']) && @strtotime($_REQUEST['date-to'])) {
                    $date_from = $_REQUEST["date-from"];
                    $date_to = $_REQUEST["date-to"];
                } else {
                    $date_from = date(WP_Eats::get_format_date());
                    $date_to = date(WP_Eats::get_format_date(), strtotime('midnight +30 day', time()));
                }
                ?>
                <label class="wp-eats_date-filter wp-eats_date-filter--from"><input name="date-from" type="text" value="<?php echo esc_attr($date_from)?>"></label>
                <span class="wp-eats_date-separator">→</span>
                <label class="wp-eats_date-filter wp-eats_date-filter--to"><input name="date-to" type="text" value="<?php echo esc_attr($date_to)?>"></label>
            </div>
            <div class="wp-eats__search-filter">
                <label><input type="text" name="search-name" value="<?php echo @esc_attr($_REQUEST['search-name'])?>" placeholder="<?php _e("Search", "wp-eats")?>"></label>
            </div>
            <div class="wp-eats__actions">
                <button class="button button--mark-as-paid"><?php _e("Mark as paid")?></button>
            </div>
        </div>
        <div class="wp-eats__list wp-eats__list--invoices">
            <table>
                <thead>
                    <tr>
                        <th><label><input type="checkbox"></label></th>
                        <th><?php _e("ID","wp-eats")?></th>
                        <th><?php _e("Restaurant","wp-eats")?></th>
                        <th><?php _e("Status","wp-eats")?></th>
                        <th><?php _e("Start Date","wp-eats")?></th>
                        <th><?php _e("End Date","wp-eats")?></th>
                        <th><?php _e("Total","wp-eats")?></th>
                        <th><?php _e("Fees","wp-eats")?></th>
                        <th><?php _e("Transfer","wp-eats")?></th>
                        <th><?php _e("Orders","wp-eats")?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_REQUEST)) $invoice_args = WP_Eats::parse_invoices_list_request($_REQUEST);
                    else $invoice_args = array();
                    $invoices = WP_Eats::get_invoice_list($invoice_args);

                    foreach ($invoices as $invoice):
                        $dates = $invoice->get_invoice_dates(WP_Eats::get_format_date());
                        $prices = $invoice->get_invoice_prices();
                        ?>
                    <tr>
                        <td class="wp-eats__table-data"><label><input type="checkbox" name="posts[]" value="<?php echo esc_attr($invoice->ID);?>"></label></td>
                        <td class="wp-eats__table-data"><?php echo $invoice->ID?></td>
                        <td class="wp-eats__table-data wp-eats__table-data--company">
                            <?php $company = get_post($invoice->get_company()); ?>
                            <div class="wp-eats__company-image"><?php echo get_the_post_thumbnail($company, 'company-thumbnail')?></div>
                            <div class="wp-eats__company-name"><?php echo $company->post_title?></div>
                        </td>
                        <td class="wp-eats__table-data"><span class="wp-eats__status-name wp-eats__status-name--<?php echo $invoice->get_invoice_status();?>"></span><?php echo $invoice->get_invoice_status_name()?></td>
                        <td class="wp-eats__table-data"><?php echo $dates['start_date']?></td>
                        <td class="wp-eats__table-data"><?php echo $dates['end_date'] ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['total']) ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['fees']) ?></td>
                        <td class="wp-eats__table-data"><?php echo WP_Eats::format_price($prices['transfer']) ?></td>
                        <td class="wp-eats__table-data"><?php // for now hardcoded ?> 20</td>
                        <td class="wp-eats__table-data"><a href=""><img src="<?php  ?>" alt="<?php /* TODO download PDF with Invoice */_e("Download icon", "wp-eats")?>"></a></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </form>
</main>

<?php include "parts/footer.php"?>
