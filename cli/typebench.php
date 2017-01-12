<?php
/**
 * Training script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

//for ($hidden = 1; $hidden < 20; $hidden++) {
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
    $n = new $classname(1, 8, 2, 6, 2, 2, 1);
    $n->setTitle('Equals function');
    $n->setDescription('Given two inputs, returns 1 if they are equal.');
    $n->setVerbose(false);

    // Add test-data to the network.
    for ($i = 0; $i < 10000; $i++) {
        $a = rand(-10000, 10000);
        $n->addTestData(array($a), array($a > 0 ? 1 : 0));
        //$n->addTestData(array($i, $i + rand(1, 3000)), array(0));
        //if ($i >= 2) {
        //    $n->addTestData(array($i, $i / 2), array(0));
        //}
    }
    //$n->addTestData(array(1, 0), array(1));
    //$n->addTestData(array(1, 1), array(0));
    //$n->addTestData(array(0, 1), array(1));
    //$n->addTestData(array(0, 0), array(0));

    // we try training the network for at most $max times
    $max = 1;
    $j = 0;

    // Train the network.
    while (!($success = $n->train(10000, 0.01)) && ++$j < $max) {
    }

    $epochs = $n->getEpoch();
    $time = microtime(True) - $time;
    if ($success) {
        echo "{$classname} - Success in {$epochs} training rounds over {$j} attempts in {$time}s.\n";

        $n->save(dirname(__FILE__) . '/../trained/maths/basic/negtonull_optimised.nn');
        exit(0);
    } else {
        echo "{$classname} - failed after {$epochs} training rounds over {$time}s.\n";
    }
}
//}
