<?php

namespace KeltyNN\Trainers;

class Genetic implements Trainer
{
    protected $basenet;
    protected $bestnet;
    protected $species;
    protected $genes;

    public function __construct($network) {
        $this->basenet = $network;
        $this->bestnet = $network;
        $this->species = array();
        $this->genes = array();
    }

    /**
     * Train the net.
     */
    public function run($getscore) {
        // Run the initial network and see what score we get.
        $network = $this->basenet->clone();
        $score = $getscore(function ($inputs) use ($network) {
            // Do nothing.
            return $network->calculate($inputs);
        });

        // Create the first species.
        // Create a genus of networks, each with random mutations.
        // Select the top networks and spawn sub species.
        // Rinse and Repeat.
    }

    /**
     * Return the best net.
     */
    public function bestNetwork() {
        return $this->bestnet;
    }
}
