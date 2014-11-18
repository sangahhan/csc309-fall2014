<h1>Payment</h1>

<?php
    echo "<p>" . anchor(site_url('cart'),'Back to cart') . "</p>";

    echo form_open('cart/checkout_summary');

    echo form_label('Credit card number');
    echo form_error('creditcard_number');
    echo form_input('creditcard_number',set_value('creditcard_number'),"required");


    $months = array(
                '01' => 'January',
                '02' => 'February',
                '03' => 'March',
                '04' => 'April',
                '05' => 'May',
                '06' => 'June',
                '07' => 'July',
                '08' => 'August',
                '09' => 'September',
                '10' => 'October',
                '11' => 'November',
                '12' => 'December',
    );

    echo form_label('Expiration month');
    echo form_error('creditcard_month');
    echo form_dropdown('month', $months, '01');

    $years = array(
                '2014' => '2014',
                '2015' => '2015',
                '2016' => '2016',
                '2017' => '2017',
                '2018' => '2018',
                '2019' => '2019',
                '2020' => '2020',
                '2021' => '2021',
                '2022' => '2022',
                '2023' => '2023',
                '2024' => '2024',
                '2025' => '2025',
                '2026' => '2026',
    );

    echo form_label('Expiration year');
    echo form_error('creditcard_year');
    echo form_dropdown('year', $years, '2014');


    echo form_submit('submit', 'Proceed', 'class="button"');
    echo form_close();
?>
