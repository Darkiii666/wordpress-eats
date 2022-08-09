<?php use wp_eats\Invoice;
use wp_eats\WP_Eats;
WP_Eats::parse_invoices_action($_REQUEST);
include "parts/header.php";?>

<main class="wp-eats__content wp-eats__content--invoices-list">

    <div class="wp-eats__title-wrap">
        <h1 class="wp-eats__title"><?php echo get_the_title()?></h1>
    </div>
    <form action="" class="wp_eats__list-from" method="GET">
        <?php //wp_nonce_field( 'mark-as-paid', 'wp_eats_nonce' );
        include "parts/invoice-filters.php";
        ?>

        <div class="wp-eats__list wp-eats__list--invoices">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="wp-eats__checkbox-wrap">
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
                    if ($invoices_query->have_posts()):
                    foreach ($invoices as $invoice):
                        $invoice = new Invoice($invoice);
                        $dates = $invoice->get_invoice_dates(WP_Eats::get_format_date());
                        $prices = $invoice->get_invoice_prices();
                        ?>
                    <tr>
                        <td class="wp-eats__table-data wp-eats__table-data--checkbox wp-eats__checkbox-wrap">
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
                    <?php
                    endforeach;
                    else:?>

                        <tr><td colspan="15" class="wp-eats__table-data"><?php _e("No Invoices Found", "wp-eats")?></td></tr>

                    <?php endif;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="15" class="wp-eats__table-data text-center">
                        <?php include "parts/invoice-table-footer.php";?>

                    </td>
                </tr>


                </tfoot>
            </table>
        </div>
    </form>
</main>

<?php include "parts/footer.php"?>
