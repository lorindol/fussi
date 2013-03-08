<?php
    /**
     * Definition of Application\Models\Ranking
     *
     * @copyright Copyright (c) 2013 The Fußi-Team
     * @license   THE BEER-WARE LICENSE (Revision 42)
     *
     * "THE BEER-WARE LICENSE" (Revision 42):
     * The Fußi-Team wrote this software. As long as you retain this notice you
     * can do whatever you want with this stuff. If we meet some day, and you think
     * this stuff is worth it, you can buy us a beer in return.
     */

namespace Application\Models;

use \Application\Models\PlayerRanking;
use \Application\Models\Ranking;
use \Application\Entity\Match;

class SinglePlayerRanking extends Ranking
{
    protected $ranking = null;


    /**
     * @param int $count Number of top scoring players to display
     *
     * @return \Application\Models\PlayerRanking[]
     */
    public function getRanking($count = null)
    {
        if ($this->ranking == null) {
            $this->calculateRanking();
        }

        foreach ($this->ranking as $k => $rank) {
            echo "player ".$rank->getPlayer()->getId().": ".$k. " matches ".$rank->getMatchCount().", points ".$rank->getScore()."\n";
        }

        if ($count != null) {
            return array_slice($this->ranking, 0, $count);
        } else {
            return $this->ranking;
        }
    }

    protected function calculateRanking()
    {
        $this->ranking = array();
        if (empty($this->matches)) {
            echo "no matches\n";
            return;
        }
        echo "matches: ".count($this->matches)."\n";
        /**
         * @var \Application\Entity\SingleMatch $match
         */
        foreach($this->matches as $match) {
            $One = $match->getPlayer1();
            $Two = $match->getPlayer2();

            $rankingOne = $this->getPlayerRanking($One);
            $rankingTwo = $this->getPlayerRanking($Two);

            $pointsOne = 0;
            $pointsTwo = 0;
            foreach ($match->getGames() as $game) {
                $goalsOne = $game->getGoalsTeamOne();
                $goalsTwo = $game->getGoalsTeamTwo();
                $rankingOne->addGoals($goalsOne);
                $rankingTwo->addGoals($goalsTwo);
                if ($goalsOne > $goalsTwo) {
                   $pointsOne++;
                } else {
                   $pointsTwo++;
                }
            }
            $rankingOne->addPoints($pointsOne);
            $rankingTwo->addPoints($pointsTwo);
        }
        uasort($this->ranking, function($a, $b) {
                return $b->getScore() - $a->getScore();
        });
    }

    /**
     * @param \Application\Entity\Player $player
     *
     * @return \Application\Models\PlayerRanking
     */
    protected function getPlayerRanking($player)
    {
        $id = $player->getId();
        if (!isset($this->ranking[$id])) {
            $this->ranking[$id] = new PlayerRanking($player);
        }

        return $this->ranking[$player->getId()];
    }
}
