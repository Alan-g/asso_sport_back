<?php


class ColumnChart
{
    public $name;
    public $value;

    /**
     * ColumnChart constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

}