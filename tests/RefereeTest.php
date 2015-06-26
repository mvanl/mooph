<?php
/**
 * Maarten van Leeuwen <maarten@significantbits.nl>
 * 26-6-15 23:38
 */ 

namespace Mooph;


class RefereeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function cross_player_moves_first()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer
        );

        $referee = new Referee();

        $this->assertSame($crossPlayer, $referee->playerToMove($game));
    }

    public function players_take_turns()
    {
        $crossPlayer = new CrossPlayer('crosser', new Brain());
        $noughtPlayer = new NoughtPlayer('noughty', new Brain());
        $game = Game::create(
            $crossPlayer,
            $noughtPlayer
        );

        $referee = new Referee();

        $game->board()->play($crossPlayer, 0, 0);

        $this->assertSame($noughtPlayer, $referee->playerToMove($game));

        $game->board()->play($noughtPlayer, 1, 1);

        $this->assertSame($crossPlayer, $referee->playerToMove($game));
    }
}