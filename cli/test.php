<?php
/**
 * Testing script.
 */

require_once (dirname(__FILE__) . "/../lib.php");

// Create a Perceptron network.
$n = new KeltyNN\Networks\FFMLPerceptron(2, 3, 1);

// Add test-data to the network.
for ($i = 0; $i < 100; $i++) {
    $a = rand(1, 500);
    $b = rand(1, 500);
    $n->addTestData(array($a, $b), array($a == $b ? 1 : -1));
}

// we try training the network for at most $max times
$max = 10;
$i = 0;

// Train the network.
while (!($success = $n->train(1000, 0.1)) && ++$i < $max) {
}

// print a message if the network was succesfully trained
if ($success) {
    $epochs = $n->getEpoch();
	echo "Success in $epochs training rounds!\n";
    exit(0);
}

echo "Failed\n";
exit(1);
