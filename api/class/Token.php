<?php


class Token
{
    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    public $token;
    public $endDate;

    /**
     * Token constructor.
     * @param $token
     * @param $endDate
     */
    public function __construct($token, $endDate)
    {
        $this->token = $token;
        $this->endDate = $endDate;
    }

}