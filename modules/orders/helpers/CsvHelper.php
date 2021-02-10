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

        if($dataProvider->getTotalCount() > 10){
            $maxRecordsInOutput = intdiv($dataProvider->getTotalCount(), 10);
            $maxIterations = intdiv($dataProvider->getTotalCount(), $maxRecordsInOutput);
            $maxIterations += fmod($maxIterations, $maxRecordsInOutput) > 0 ? 1 : 0;
        } else {
            $maxRecordsInOutput = 1;
            $maxIterations = $dataProvider->getTotalCount();
        }


        for ($i = 0; $i < $maxIterations; $i++) {
            $queryResult = $dataProvider->query->offset($i * $maxRecordsInOutput)->limit($maxRecordsInOutput)->createCommand()->queryAll();
            foreach ($queryResult as $key => $order) {
                fputcsv($stream, $order);
            }
            ob_flush();
            flush();
        }
        ob_end_clean();
        exit;
    }
}