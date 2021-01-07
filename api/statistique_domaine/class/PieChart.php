<?php


class PieChart
{
    public $pie = array();
    public $header = array();

    /**+
     * PieChart constructor.
     * @param $array []
     */
    public function __construct($array)
    {
        $total = 0;
        foreach ($array as $value){
            $total += $value;
        }

        foreach ($array as $key => $value){
            array_push($this->header, $key.": ".$value);
            array_push($this->pie, new ColumnChart($key.": ".$value, round(($value / $total) * 100, 1)));
        }
    }

    /**
     * @param $ligne
     */
    function setEnTete($ligne){
        $this->header = $ligne;
    }

}