<?php
/**
 * Training script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

$input = 2;
$output = 1;

$done = array();
for ($i = 1; $i <= 12; $i++) {
    $time = microtime(True);

    do {
        $layer1 = 1;
        $layer2 = 0;// rand(0, 40);
        $layer3 = 0;//rand(0, 40);
        $k = "{$layer1}{$layer2}{$layer3}";
    } while (isset($done[$k]));
    $done[$k] = true;

    // Create a Perceptron network.
    if ($layer2 && $layer3) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $layer3, $output);
    } elseif ($layer2) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $output);
    } else {
        $n = new KeltyNN\Networks\FFMLHyperbolicPerceptron($input, $layer1, $output);
    }
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
    while (!($success = $n->train(1000, 0.1)) && ++$j < $max) {
    }

    // Print a message.
    $epochs = $n->getEpoch();
    $time = microtime(True) - $time;
    if ($success) {
        echo "Success in {$epochs} training rounds over {$j} attempts in {$time}s.\n";
        echo "{$layer1} | {$layer2} | {$layer3}\n";

        $n->save(dirname(__FILE__) . '/../trained/maths/basic/or_hyperbolic.nn');
        exit(0);
    } else {
        echo "Failed after {$epochs} training rounds over {$time}s.\n";
    }
}

echo "Failed\n";
exit(1);
