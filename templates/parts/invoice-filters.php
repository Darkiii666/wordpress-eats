<?php
use wp_eats\Invoice;
use wp_eats\WP_Eats;
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