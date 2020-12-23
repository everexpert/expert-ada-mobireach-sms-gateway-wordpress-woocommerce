<?php 

	wp_register_style('stylesheet_1', EEMR_SMS_URL . "lib/asset/css/jquery.dataTables.min.css");
    wp_register_style('stylesheet_2', EEMR_SMS_URL . "lib/asset/css/buttons.dataTables.min.css");
    wp_register_style('stylesheet_3', EEMR_SMS_URL . "lib/asset/css/dataTables.searchHighlight.css");
    
    wp_register_script('script_1', EEMR_SMS_URL . "lib/asset/js/jquery.dataTables.min.js");
    wp_register_script('script_2', EEMR_SMS_URL . "lib/asset/js/dataTables.buttons.min.js");
    wp_register_script('script_3', EEMR_SMS_URL . "lib/asset/js/jszip.min.js");
    wp_register_script('script_4', EEMR_SMS_URL . "lib/asset/js/pdfmake.min.js");
    wp_register_script('script_5', EEMR_SMS_URL . "lib/asset/js/buttons.html5.min.js");
    wp_register_script('script_6', EEMR_SMS_URL . "lib/asset/js/buttons.print.min.js");
    wp_register_script('script_7', EEMR_SMS_URL . "lib/asset/js/dataTables.searchHighlight.min.js");
    wp_register_script('script_8', EEMR_SMS_URL . "lib/asset/js/jquery.highlight.js");
    wp_register_script('script_9', EEMR_SMS_URL . "lib/asset/js/dataTables.select.min.js");

    wp_enqueue_script('script_1');
    wp_enqueue_script('script_2');
    wp_enqueue_script('script_3');
    wp_enqueue_script('script_4');
    wp_enqueue_script('script_5');
    wp_enqueue_script('script_6');
    wp_enqueue_script('script_7');
    wp_enqueue_script('script_8');
    wp_enqueue_script('script_9');

    wp_enqueue_style('stylesheet_1');
    wp_enqueue_style('stylesheet_2');
    wp_enqueue_style('stylesheet_3');
?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $('#payments').DataTable({
                // aLengthMenu: [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "ALL"]],
                searchHighlight: true,
                dom: 'Blfrtip',
                order: [[ 3, 'desc' ]],
                select: true,
                pageLength: 25,
                buttons: [  
                    {
                        extend:    'copyHtml5',
                        titleAttr: 'Copy to Clipboard'
                    },
                    {
                        extend:    'csvHtml5',
                        titleAttr: 'Download CSV'
                    },
                    {
                        extend:    'excelHtml5',
                        titleAttr: 'Download Excel'
                    }
                ]
            });
        });
    </script>
    <table id='payments' class='display nowrap' cellspacing='0' width='100%'>
        <thead>
            <tr style="background:#0073aa;color: white;">
                <th>SL#</th>
                <th>Customer Name</th>
                <th>Phone Number</th>
                <th>SMS Sending Time</th>
                <th>SMS Type</th>
                <th>API Response</th>
            </tr>
        </thead>
        <tbody>
            <?php
            global $wpdb;
    		$table_name = $wpdb->prefix . 'eemr_woo_alert';
            $sql = 'SELECT * FROM ' . $table_name . ' ORDER BY sending_time DESC';
			$results = $wpdb->get_results($sql, ARRAY_A);

            if (!empty($results)) {
            	$i = 0;
                foreach ($results as $row) { 
                	$i++;
                	?>
                    <tr style="font-size: 13px;">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><b><?php echo $row['phone_no']; ?></b></td>
                        <td><?php echo $row['sending_time']; ?></td>
                        <td><?php echo $style_class.$row['sms_type']; ?></td>
                        <td><?php echo $row['api_response']; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>