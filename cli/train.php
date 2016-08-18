<?php
/**
 * Training script.
 */

require_once (dirname(__FILE__) . "/../lib.php");

$done = array();
for ($i = 0; $i <= 10000; $i++) {
    $layer1 = rand(1, 100);
    $layer2 = rand(0, 100);
    $layer3 = 0;//rand(0, 6);
    $k = "{$layer1}{$layer2}{$layer3}";
    if (isset($done[$k])) {
        continue;
    }
    $done[$k] = true;

    // Create a Perceptron network.
    if ($layer2 && $layer3) {
        $n = new KeltyNN\Networks\FFMLPerceptron(2, $layer1, $layer2, $layer3, 1);
    } else if ($layer2) {
        $n = new KeltyNN\Networks\FFMLPerceptron(2, $layer1, $layer2, 1);
    } else {
        $n = new KeltyNN\Networks\FFMLPerceptron(2, $layer1, 1);
    }
    $n->setDescription("This network will output 1 if both inputs are equal, if not it will output 0.");
    $n->setVerbose(false);

    // Add test-data to the network.
    $n->addTestData(array(500, 200), array(-1));
    $n->addTestData(array(300, 20), array(-1));
    $n->addTestData(array(201, 70), array(-1));
    $n->addTestData(array(700, 300), array(-1));
    $n->addTestData(array(520, 100), array(-1));
    $n->addTestData(array(100, 100), array(1));
    $n->addTestData(array(130, 130), array(1));
    $n->addTestData(array(10, 10), array(1));
    $n->addTestData(array(1000, 1000), array(1));
    $n->addTestData(array(80, 80), array(1));
    $n->addTestData(array(520, 2000), array(-1));
    $n->addTestData(array(50, 200), array(-1));
    $n->addTestData(array(20, 50), array(-1));
    $n->addTestData(array(500, 1000), array(-1));
    $n->addTestData(array(200, 500), array(-1));

    // we try training the network for at most $max times
    $max = 5;
    $i = 0;

    // Train the network.
    while (!($success = $n->train(10000, 0.1)) && ++$i < $max) {
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
