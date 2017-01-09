<?php
/**
 * Training script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

$input = 20;
$output = 20;

function encodeNumber($num) {
    $result = array_pad(array(), 20, 0);
    $result[$num] = 1;
    return $result;
}

$done = array();
for ($i = 1; $i <= 12; $i++) {
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
        $n = new KeltyNN\Networks\FFMLPerceptron($input, $layer1, $output);
    }
    $n->setTitle('Digit Addition 0-9');
    $n->setDescription('Returns the sum of two numbers.');
    $n->setVerbose(false);

    // Add test-data to the network.
    for ($i = 0; $i < 1000; $i++) {
        $a = rand(0, 9);
        $b = rand(0, 9);
        $n->addTestData(array_merge(encodeNumber($a), encodeNumber($b)), encodeNumber($a + $b));
    }

    // we try training the network for at most $max times
    $max = 10;
    $j = 0;

    // Train the network.
    while (!($success = $n->train(10000, 0.1)) && ++$j < $max) {
    }

    // print a message if the network was succesfully trained
    if ($success) {
        $epochs = $n->getEpoch();
        $n->save(dirname(__FILE__) . '/../trained/maths/basic/addition.nn');
        echo "{$layer1} | {$layer2} | {$layer3}\n";
        echo "Success in $epochs training rounds!\n";
        exit(0);
    }
}

echo "Failed\n";
exit(1);
