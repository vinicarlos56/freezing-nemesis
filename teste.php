<?php

interface Troop{
    public function getCost();
    public function getCampSize();
    public function getAttackPower();
    public function getGuardPower();
    public function getFieldPosition();
}

class Fighter implements Troop
{
    public function getCost()
    {
        return 1;
    }

    public function getCampSize()
    {
        return 2;
    }

    public function getAttackPower()
    {
        return 6;
    }

    public function getGuardPower()
    {
        return 3;
    }

    public function getFieldPosition()
    {
        return 'front';
    }
}

class Bomber implements Troop
{
    public function getCost()
    {
        return 3;
    }

    public function getCampSize()
    {
        return 4;
    }

    public function getAttackPower()
    {
        return 2;
    }

    public function getGuardPower()
    {
        return 6;
    }

    public function getFieldPosition()
    {
        return 'middle';
    }
}

class LightCalvary implements Troop
{
    public function getCost()
    {
        return 6;
    }

    public function getCampSize()
    {
        return 6;
    }

    public function getAttackPower()
    {
        return 9;
    }

    public function getGuardPower()
    {
        return 5;
    }

    public function getFieldPosition()
    {
        return 'front';
    }
}

class HeavyCalvary implements Troop
{
    public function getCost()
    {
        return 8;
    }

    public function getCampSize()
    {
        return 8;
    }

    public function getAttackPower()
    {
        return 5;
    }

    public function getGuardPower()
    {
        return 9;
    }

    public function getFieldPosition()
    {
        return 'back';
    }
}

class Camp
{
    protected $size = 100;
    protected $level = 1;
    protected $troops = [];
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addTroop(Troop $troop)
    {
        $this->troops[] = $troop;
    }

    public function getTroops()
    {
        return $this->troops;
    }

    public function getName()
    {
        return $this->name;
    }
}

class BattleField
{
    protected $attackPower;
    protected $guardPower;
    protected $attackerCamp;
    protected $defenderCamp;
    protected $winner;
    protected $report;

    public function __construct(Camp $attackerCamp, Camp $defenderCamp)
    {
        $this->attackerCamp = $attackerCamp;
        $this->defenderCamp = $defenderCamp;
    }

    public function fight()
    {
        foreach ($this->attackerCamp->getTroops() as $troop) {
            $this->attackPower += $troop->getAttackPower(); 
        }

        foreach ($this->defenderCamp->getTroops() as $troop) {
            $this->guardPower += $troop->getGuardPower();
        }

        if ($this->attackPower > $this->guardPower) {
            $this->winner = $this->attackerCamp;
        } else {
            $this->winner = $this->defenderCamp;
        }
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function getBattleReport()
    {
        return [
            'Attacker Camp' => [ 
                'Troops' => count($this->attackerCamp->getTroops()),
                'Total Attack Power' => $this->attackPower
            ],
            'Defender Camp' => [ 
                'Troops' => count($this->attackerCamp->getTroops()),
                'Total Guard Power' => $this->guardPower
            ]
        ];
    }
}

function add(Camp &$camp, $size, $type){

    for ($i = 0; $i < $size; $i++) {
        $camp->addTroop(new $type);
    }
}


class Game
{
    public function run()
    {
        $attackerCamp = new Camp('Attackers');
        add($attackerCamp,50,'Fighter');
        add($attackerCamp,10,'LightCalvary');

        $defenderCamp = new Camp('Defenders');
        add($defenderCamp,50,'Fighter');
        add($defenderCamp,30,'Bomber');

        $battleField = new BattleField($attackerCamp,$defenderCamp);
        $battleField->fight();

        $winner = $battleField->getWinner();
       
        $battleReport = $battleField->getBattleReport();

        echo $winner->getName();
        echo PHP_EOL;

        print_r($battleReport);
    }
}

$game = new Game();
$game->run();
