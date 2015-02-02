<?php namespace spec\Game;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Game\Camp;
use Game\Troop\Troop as Troop;

class BattleFieldSpec extends ObjectBehavior
{
    public function let(Camp $attackerCamp, Camp $defenderCamp)
    {
        $attackerCamp->beConstructedWith(['AttackersCamp']);
        $defenderCamp->beConstructedWith(['DefendersCamp']);

        $this->beConstructedWith($attackerCamp,$defenderCamp);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Game\BattleField');
    }

    public function it_should_calculate_the_attack_and_guard_power($attackerCamp, $defenderCamp, $attackerTroop, $defenderTroop)
    {
        $attackerTroop->beADoubleOf('Game\Troop\Troop');
        $attackerTroop->getAttackPower()->shouldBeCalled();

        $defenderTroop->beADoubleOf('Game\Troop\Troop');
        $defenderTroop->getGuardPower()->shouldBeCalled();

        $attackerCamp->getTroops()->willReturn([$attackerTroop]);
        $defenderCamp->getTroops()->willReturn([$defenderTroop]);

        $this->calculateAttackerPower();
        $this->calculateDefenderPower();
    }

    public function it_should_define_the_winner_when_fight_is_called($attackerCamp,$defenderCamp,Troop $fighter)
    {
        $fighter->getAttackPower()->willReturn(6);
        $fighter->getGuardPower()->willReturn(3);

        $attackerCamp->addTroop($fighter);
        $defenderCamp->addTroop($fighter);

        $attackerCamp->getTroops()->willReturn([$fighter]);
        $defenderCamp->getTroops()->willReturn([$fighter]);

        $this->fight();
        $this->getWinner()->shouldReturn($attackerCamp);
    }

    public function it_should_define_a_draw_when_it_happens($attackerCamp, $defenderCamp, Troop $fighter)
    {
        $fighter->getAttackPower()->willReturn(6);
        $fighter->getGuardPower()->willReturn(3);

        $attackerCamp->addTroop($fighter);
        $defenderCamp->addTroop($fighter);

        $attackerCamp->getTroops()->willReturn([$fighter]);
        $defenderCamp->getTroops()->willReturn([$fighter,$fighter]);

        $this->fight();
        $this->getWinner()->shouldReturn(null);
        $this->wasTie()->shouldReturn(true);
    }

}
