<?php
/**
 * Definition of ApplicationTest\Models\PlayerRankingTest
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

use \Application\Models\PlayerRanking;

class PlayerRankingTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSingleMatchPoints()
    {
        $player = $this->getMock('\Application\Entity\Player');
        $playerRank = new PlayerRanking($player);
        $playerRank->addPoints(5);

        $this->assertEquals(1, $playerRank->getMatchCount());
    }

    public function testAddTwoMatchesPoints()
    {
        $player = $this->getMock('\Application\Entity\Player');
        $playerRank = new PlayerRanking($player);
        $playerRank->addPoints(5,2);

        $this->assertEquals(2, $playerRank->getMatchCount());
    }
}