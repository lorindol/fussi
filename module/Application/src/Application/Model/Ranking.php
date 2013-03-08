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

namespace Application\Model;

use \Application\Model\PlayerRanking;
use \Application\Entity\Match;

abstract class Ranking {
    /**
     * @var \Application\Entity\Match[]
     */
    protected $matches;

    /**
     * Set the matches that will be used to calculate the ranking
     *
     * @param \Application\Entity\Match[] $matches List of matches
     */
    public function setMatches($matches)
    {
        $this->matches = $matches;

    }

    /**
     * Get the calculated results
     * @abstract
     *
     * @return \Application\Model\PlayerRanking[]
     */
    abstract public function getRanking();
}
