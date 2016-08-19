<?php
/**
 * Training script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

$input = 2;
$output = 1;

$done = array();
for ($i = 1; $i <= 12; $i++) {
    $layer1 = $i; //rand(1, 6);
    $layer2 = 0; //rand(0, 6);
    $layer3 = 0; //rand(0, 6);
    $k = "{$layer1}{$layer2}{$layer3}";
    if (isset($done[$k])) {
        continue;
    }
    $done[$k] = true;

    // Create a Perceptron network.
    if ($layer2 && $layer3) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $layer3, $output);
    } elseif ($layer2) {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $layer2, $output);
    } else {
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $output);
    }
    $n->setTitle('AND logic gate');
    $n->setDescription('Given two inputs, this will output 1 if both are 1 and -1 if both, or either, are 0.');
    $n->setVerbose(false);

    // Add test-data to the network.
    $n->addTestData(array(1, 1), array(1));
    $n->addTestData(array(0, 1), array(-1));
    $n->addTestData(array(1, 0), array(-1));
    $n->addTestData(array(0, 0), array(-1));

    // we try training the network for at most $max times
    $max = 10;
    $j = 0;

    // Train the network.
    while (!($success = $n->train(1000, 0.001)) && ++$j < $max) {
    }

    // print a message if the network was succesfully trained
    if ($success) {
        $epochs = $n->getEpoch();
        $n->save(dirname(__FILE__) . '/../trained/maths/basic/and.nn');
        echo "{$layer1} | {$layer2} | {$layer3}\n";
        echo "Success in $epochs training rounds!\n";
        exit(0);
    }
}

echo "Failed\n";
exit(1);
