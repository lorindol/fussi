<?php
/**
 * Definition of Application\Form\Tournament
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */
namespace Application\Form;

use Application\Model\Entity\AbstractTournament;
use \Zend\Form\Form;

class Tournament extends Form
{

    public function __construct()
    {
        parent::__construct('Tournament');

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'match-mode',
            'options' => array(
                'label' => 'Match type',
            ),
        ));
        $this->get('match-mode')->setValueOptions(
            array(
                 AbstractTournament::MODE_EXACTLY => 'Play exact number of games',
                 AbstractTournament::MODE_BEST_OF => 'Best of the number of games'
            )

        );

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'games-per-match',
            'options' => array(
                'label' => 'Games per match',
            ),
            'attributes' => array(
                'maxlength' => 2
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'max-score',
            'options' => array(
                'label' => 'Max. score to win a game',
            ),
            'attributes' => array(
                'maxlength' => 2
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'options' => array(
                'type'  => 'submit'
            )
        ));
        $this->get('submit')->setValue('Save');

    }

}
