<?php
    /**
     * Definition of ApplicationTest\Models\SinglePlayerRankingTest
     *
     * @copyright Copyright (c) 2013 The Fußi-Team
     * @license   THE BEER-WARE LICENSE (Revision 42)
     *
     * "THE BEER-WARE LICENSE" (Revision 42):
     * The Fußi-Team wrote this software. As long as you retain this notice you
     * can do whatever you want with this stuff. If we meet some day, and you think
     * this stuff is worth it, you can buy us a beer in return.
     */

namespace ApplicationTest\Models;

use \Application\Models\SinglePlayerRanking;
use Doctrine\Common\Collections\ArrayCollection;

class SinglePlayerRankingTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatchesEmptyRanking()
    {
        $ranking = new SinglePlayerRanking();
        $this->assertCount(0, $ranking->getRanking());
    }

    public function testOneMatchTwoPlayerInRanking()
    {
        $ranking = new SinglePlayerRanking();

        $this->getMatchMock();

        $matchMock = $this->getMatchMock();
        $ranking->setMatches(array($matchMock, $matchMock));

        $this->assertCount(2, $ranking->getRanking());
    }

    public function testOneMatchPlayerTwoWins()
    {
        $ranking = new SinglePlayerRanking();

        $matchMock = $this->getMatchMock(array(array(1=>1,2=>10), array(1=>4,2=>10)));
        $matchMockToo = $this->getMatchMock(array(array(1=>10,2=>1), array(1=>4,2=>10)));

        $ranking->setMatches(array($matchMock, $matchMockToo));

        $ranks = $ranking->getRanking();
        reset($ranks);
        $this->assertEquals(2, current($ranks)->getPlayer()->getId());
        $this->assertEquals(3, current($ranks)->getScore());
    }

    protected function getMatchMock($results = null, $one = 1, $two = 2)
    {
        $match = $this->getMock('\Application\Entity\Match', array('getGames', 'getPlayer1', 'getPlayer2'));

        if (!empty($results)) {
            $games = array();
            foreach ($results as $result) {
                $games[] = $this->getGameMock($result[1], $result[2]);
            }
        } else {
           $games = array($this->getGameMock(1,10));
        }
        $match->expects($this->any())->method('getGames')
            ->will($this->returnValue(new ArrayCollection($games)));
        $match->expects($this->any())->method('getPlayer1')->will($this->returnValue($this->getPlayerMock($one)));
        $match->expects($this->any())->method('getPlayer2')->will($this->returnValue($this->getPlayerMock($two)));
        return $match;
    }
    protected function getGameMock($scoreA, $scoreB)
    {
        $game = $this->getMock('\Application\Entity\Game');
        $game->expects($this->any())->method('getGoalsTeamOne')->will($this->returnValue($scoreA));
        $game->expects($this->any())->method('getGoalsTeamTwo')->will($this->returnValue($scoreB));
        return $game;
    }
    public function getPlayerMock($id)
    {
        $player = $this->getMock('\Application\Entity\Player');
        $player->expects($this->any())->method('getId')->will($this->returnValue($id));
        return $player;
    }
}
