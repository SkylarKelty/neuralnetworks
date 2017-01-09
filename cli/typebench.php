<?php
/**
 * Training script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

foreach (array(
    'KeltyNN\\Networks\\FFMLPerceptron',
    'KeltyNN\\Networks\\FFMLRELUPerceptron',
    'KeltyNN\\Networks\\FFMLLeakyRELUPerceptron',
    'KeltyNN\\Networks\\FFMLLinearPerceptron',
    'KeltyNN\\Networks\\FFMLHyperbolicPerceptron',
    'KeltyNN\\Networks\\FFMLSigPerceptron',
    'KeltyNN\\Networks\\FFMLBentIdentPerceptron'
) as $classname) {
    $time = microtime(True);
    // Create a Perceptron network.
    $n = new $classname(2, 4, 1);
    $n->setTitle('OR Gate');
    $n->setDescription('Given two inputs, this will output 1 if either input is 1 else it will output -1.');
    $n->setVerbose(false);

    // Add test-data to the network.
    $n->addTestData(array(1, 0), array(1));
    $n->addTestData(array(1, 1), array(1));
    $n->addTestData(array(0, 1), array(1));
    $n->addTestData(array(0, 0), array(0));

    // we try training the network for at most $max times
    $max = 10;
    $j = 0;

    // Train the network.
    while (!($success = $n->train(10000, 0.1)) && ++$j < $max) {
    }

    // print a message if the network was succesfully trained
    if ($success) {
        $epochs = $n->getEpoch();
        $time = microtime(True) - $time;
        echo "{$classname} - Success in {$epochs} training rounds over {$j} attempts in {$time}s.\n";
    } else {
        echo "{$classname} - failed.\n";
    }
}
