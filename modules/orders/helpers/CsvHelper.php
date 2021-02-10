<?php

namespace orders\helpers;


use yii\data\ActiveDataProvider;

/**
 * Helper class to compose csv from output buffer
 *
 * Class CsvHelper
 */
class CsvHelper
{
    /**
     * @param $dataProvider ActiveDataProvider
     */
    public static
    function sendCsvFromBuffer(ActiveDataProvider $dataProvider)
    {
        ob_start();
        $fileName = date('YmdHis', time());
        $stream = fopen('php://output', 'a');
        header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');

            foreach ($dataProvider->query->batch(100) as  $orders) {
                foreach ($orders as $key => $order)
                fputcsv($stream, $order);
            }
            ob_flush();
            flush();
        ob_end_clean();
        exit;
    }
}