<h2>Registration</h2>

<?php
    echo "<p>" . anchor('auth','Back') . "</p>";

    echo form_open('cart/checkout_summary');

    echo form_label('Credit card number');
    echo form_error('creditcard_number');
    echo form_input('creditcard_number',set_value('creditcard_number'),"required");

    echo "<br>";

    $months = array(
                '01' => 'Jan',
                '02' => 'Feb',
                '03' => 'Mar',
                '04' => 'Apr',
                '05' => 'May',
                '06' => 'Jun',
                '07' => 'Jul',
                '08' => 'Aug',
                '09' => 'Sep',
                '10' => 'Oct',
                '11' => 'Nov',
                '12' => 'Dec',
    );

    echo form_label('Expiration month');
    echo form_error('creditcard_month');
    echo form_dropdown('month', $months, '01');

    echo "<br>";
    echo "<br>";

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

    echo "<br>";
    echo "<br>";


    echo form_submit('submit', 'Proceed');
    echo form_close();
?>
