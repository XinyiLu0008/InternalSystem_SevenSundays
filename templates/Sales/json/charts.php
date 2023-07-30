<?php
$data = [];
foreach ($sales as $sale) {
    $item = [
        'quantity' => $sale->quantity,
        'sale_date' => $sale->sales_date,
        'user_name' => $sale->user->first_name
          ];
    $data[] = $item;
}

echo json_encode($data);
