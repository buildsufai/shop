<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:44
 *
 */
Yii::import('shop.models.*');
class Shop extends CComponent {

    protected $count = 0;
    protected $total = 0;

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }



    public function init() {
    }

    public function importCatalogFromExcel($filename, &$stat = array()) {
        require_once Yii::getPathOfAlias('shop.extensions').'/Excel/reader.php';

        $data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
        $data->setOutputEncoding('UTF8');

        $data->read($filename);
        $data->sheets[0]['cells'];
        for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
            //    var_dump($)
            //if(isset($data->sheets[0]['cells'][$i][1])){
            //    echo "\"".$data->sheets[0]['cells'][$i][1]."\",";
            //    var_dump($data->sheets[0]['cellsInfo'][$i][1]);
           // }

            /*
            for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
            }*/
            echo "<br>\n";

        }
        var_dump($data->sheets[0]['numRows']);
        $stat['rowCount'] = $data->sheets[0]['numRows'];
        return $stat;
    }

} 