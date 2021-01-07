<?php


class StatsAnnee
{
    public $aderentTotal;
    public $newAdherent;
    public $oldAdherent;
    public $essai;
    public $repartitionSexe;

    /**
     * StatsAnnee constructor.
     * @param $aderentTotal
     * @param $newAdherent
     * @param $oldAdherent
     * @param $essai
     * @param $repartitionSexe
     */
    public function __construct($aderentTotal, $newAdherent, $oldAdherent, $essai, $repartitionSexe)
    {
        $this->aderentTotal = $aderentTotal;
        $this->newAdherent = $newAdherent;
        $this->oldAdherent = $oldAdherent;
        $this->essai = $essai;
        $this->repartitionSexe = $repartitionSexe;
    }


}