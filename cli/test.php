<?php
/**
 * Testing script.
 */

require_once (dirname(__FILE__) . "/../lib.php");

// Create a Perceptron network.
$ngte = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . "/../trained/maths/basic/gte.nn");
$ngt = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . "/../trained/maths/basic/gt.nn");
$xor = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . "/../trained/maths/basic/xor.nn");
$negnull = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . "/../trained/maths/advanced/negtonull.nn");

// Add test-data to the network.
$testdata = array();
for ($i = 0; $i < 100; $i++) {
    $a = rand(1, 500);
    $b = rand(1, 500);
    if (rand(1, 2) == 1) {
        $testdata[] = array(array($a, $a), array(1));
    } else {
        $testdata[] = array(array($a, $b), array($a == $b ? 1 : -1));
    }
}

for ($i = 0; $i < 100; $i++) {
    $a = rand(1, 500);
    $b = rand(1, 500);
    if (rand(1, 2) == 1) {
        $b = $a;
    }

    $resulta = $ngte->calculate(array($a, $b));
    $resulta = round($resulta[0]);
    $resulta = $negnull->calculate(array($resulta));
    $resulta = round($resulta[0]);

    $resultb = $ngt->calculate(array($a, $b));
    $resultb = round($resultb[0]);
    $resultb = $negnull->calculate(array($resultb));
    $resultb = round($resultb[0]);

    $result = $xor->calculate(array($resulta, $resultb));
    $result = round($result[0]) == 1 ? 1 : -1;

    echo "{$a} == {$b} = {$resulta[0]} {$resultb[0]} {$result}\n";
}
