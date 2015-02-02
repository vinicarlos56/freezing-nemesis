<?php namespace Game;

use Game\Camp;

class BattleField
{
    protected $attackerCamp;
    protected $defenderCamp;
    protected $attackPower;
    protected $guardPower;
    protected $winner;

    public function __construct(Camp $attackerCamp, Camp $defenderCamp)
    {
        $this->attackerCamp = $attackerCamp;
        $this->defenderCamp = $defenderCamp;
    }

    public function calculateAttackerPower()
    {
        foreach ($this->attackerCamp->getTroops() as $troop) {
            $this->attackPower += $troop->getAttackPower();
        }
    }

    public function calculateDefenderPower()
    {
        foreach ($this->defenderCamp->getTroops() as $troop) {
            $this->guardPower += $troop->getGuardPower();
        }
    }

    public function fight()
    {
        $this->calculateAttackerPower();
        $this->calculateDefenderPower();

        if ($this->attackPower > $this->guardPower) {
            $this->winner = $this->attackerCamp;
        } elseif($this->attackPower < $this->guardPower) {
            $this->winner = $this->defenderCamp;
        }
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function wasTie()
    {
        return !$this->winner ?: false;
    }
}
