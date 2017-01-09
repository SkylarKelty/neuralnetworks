<?php
/**
 * Manually create an optimised XOR.
 */

// TODO - train properly with this model.

require_once(dirname(__FILE__) . '/../lib.php');

$data = file_get_contents(dirname(__FILE__) . "/../trained/maths/basic/xor.nn");
$data = unserialize($data);
$data['type'] = 'FFMLFlexPerceptron';
$data['version'] = '1.1';
$data['designed'] = false;
$data['nodeCount'] = array(2, 1, 1);
$data['edgeWeight'] = array(
    0 => array(
        0 => array(
            '1_1' => 0,
            '2_0' => 0
        ),
        1 => array(
            '1_1' => 0,
            '2_0' => 0
        )
    ),
    1 => array(
        0 => array(
            '2_0' => 0
        )
    ),
);
$data['nodeThreshold'] = array(
    1 => array(
        0 => 0
    ),
    2 => array(
        0 => 0
    )
);
$data['layerConnectors'] = array(
    '1_1' => array(
        0 => array(0, 1)
    ),
    '2_0' => array(
        0 => array(0, 1),
        1 => array(0)
    )
);

$newnn = KeltyNN\NeuralNetwork::load($data);

// Add test-data to the network.
$newnn->addTestData(array(1, 1), array(0));
$newnn->addTestData(array(0, 1), array(1));
$newnn->addTestData(array(1, 0), array(1));
$newnn->addTestData(array(0, 0), array(0));

$max = 10;
$j = 0;

// Train the network.
while (!($success = $newnn->train(10000, 0.1)) && ++$j < $max) {
}

$result = $newnn->calculate(array(1, 1));
echo "1 xor 1 = {$result[0]}\n";
$result = $newnn->calculate(array(1, 0));
echo "1 xor 0 = {$result[0]}\n";
$result = $newnn->calculate(array(0, 1));
echo "0 xor 1 = {$result[0]}\n";
$result = $newnn->calculate(array(0, 0));
echo "0 xor 0 = {$result[0]}\n";

// print a message if the network was succesfully trained
if ($success) {
    $epochs = $newnn->getEpoch();
    $newnn->save(dirname(__FILE__) . '/../trained/maths/basic/flex_xor.nn');
    echo "Success in $epochs training rounds!\n";
    exit(0);
}
