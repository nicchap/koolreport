<?php

require_once "../../../../koolreport/autoload.php";

use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;

class TableDemo extends \koolreport\KoolReport
{
    use \koolreport\clients\FontAwesome;
    function settings()
    {
        return array(
            "dataSources"=>array(
                "data_sample"=>array(
                    "class"=>'\koolreport\datasources\CSVDataSource',
                    'filePath'=>dirname(__FILE__)."\data_sample.csv",
                )
            )
        ); 
    }
    function setup()
    {
        $this->src('data_sample')
        ->pipe(new CalculatedColumn(array(
            "total"=>"{quantity}*{price}"
        )))
        ->pipe(new ColumnMeta(array(
            "item"=>array(
                "type"=>"string",
                "label"=>"Item",
            ),
            "quantity"=>array(
                "label"=>"Qty",
                "type"=>"number"
            ),
            "price"=>array(
                "label"=>"Price",
                "type"=>"number",
                "prefix"=>"$",
            ),
            "total"=>array(
                "label"=>"Total",
                "type"=>"number",
                "prefix"=>"$",
            ),            
        )))
        ->pipe($this->dataStore('data_sample'));
    }
}