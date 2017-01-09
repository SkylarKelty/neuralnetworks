<?php
/**
 * Manually create an optimised XOR.
 */

require_once(dirname(__FILE__) . '/../lib.php');

$data = file_get_contents(dirname(__FILE__) . "/../trained/maths/basic/newxor.nn");
$data = unserialize($data);
$data['type'] = 'FFMLFlexPerceptron';
$data['version'] = '1.0';
$data['nodeCount'] = array(2, 1, 1);
$data['edgeWeight'] = array(
    0 => array(
        0 => array(
            '1_1' => 1,
            '2_0' => 1
        ),
        1 => array(
            '1_1' => 1,
            '2_0' => 1
        )
    ),
    1 => array(
        0 => array(
            '2_0' => -2
        )
    ),
);
$data['nodeThreshold'] = array(
    1 => array(
        0 => 1.5
    ),
    2 => array(
        0 => 0.5
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

$result = $newnn->calculate(array(1, 1));
echo "1 xor 1 = {$result[0]}\n";
$result = $newnn->calculate(array(1, 0));
echo "1 xor 0 = {$result[0]}\n";
$result = $newnn->calculate(array(0, 1));
echo "0 xor 1 = {$result[0]}\n";
$result = $newnn->calculate(array(0, 0));
echo "0 xor 0 = {$result[0]}\n";
