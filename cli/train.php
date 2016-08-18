<?php
/**
 * Training script.
 */

require_once (dirname(__FILE__) . "/../lib.php");

$input = 2;
$output = 1;

$done = array();
for ($i = 0; $i <= 100000; $i++) {
    $layer1 = rand(1, 6);
    $layer2 = rand(0, 6);
    $layer3 = rand(0, 6);
    $k = "{$layer1}{$layer2}{$layer3}";
    if (isset($done[$k])) {
        continue;
    }
    $done[$k] = true;

    // Create a Perceptron network.
    if ($layer2 && $layer3) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $layer3, $output);
    } else if ($layer2) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $output);
    } else {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $output);
    }
    $n->setDescription("This network will output 1 if both inputs are equal, if not it will output -1.");
    $n->setVerbose(false);

    // Add test-data to the network.
    for ($i = 0; $i < 100; $i++) {
        $a = rand(1, 500);
        $b = rand(1, 500);
        if (rand(1, 2) == 1) {
            $n->addTestData(array($a, $a), array(1));
        } else {
            $n->addTestData(array($a, $b), array($a == $b ? 1 : -1));
        }
    }

    // we try training the network for at most $max times
    $max = 2;
    $i = 0;

    // Train the network.
    while (!($success = $n->train(1000, 0.1)) && ++$i < $max) {
    }

    // print a message if the network was succesfully trained
    if ($success) {
        $epochs = $n->getEpoch();
        $n->save(dirname(__FILE__) . "/../trained/maths/basic/eq.nn");
    	echo "{$layer1} | {$layer2} | {$layer3}\n";
    	echo "Success in $epochs training rounds!\n";
        exit(0);
    }
}

echo "Failed\n";
exit(1);
