<?php
/**
 * Testing script.
 */
require_once(dirname(__FILE__) . '/../lib.php');

// Create a Perceptron network.
$ngte = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . '/../trained/maths/basic/gte.nn');
$ngt = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . '/../trained/maths/basic/gt.nn');
$xor = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . '/../trained/maths/basic/xor.nn');
$negnull = KeltyNN\NeuralNetwork::load(dirname(__FILE__) . '/../trained/maths/advanced/negtonull.nn');

$ngtenull = KeltyNN\NeuralNetwork::combine($ngte, $negnull);
$ngtnull = KeltyNN\NeuralNetwork::combine($ngt, $negnull);

$prexor = KeltyNN\NeuralNetwork::add($ngtenull, $ngtnull);

$eq = KeltyNN\NeuralNetwork::combine($prexor, $xor);
$eq->setTitle('Equals');
$eq->setDescription('Given two inputs, will return 1 if they are equal or -1 if they are not.');
$eq->save(dirname(__FILE__) . '/../trained/maths/advanced/equals.nn');

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

    $result = $eq->calculate(array($a, $b));
    $result = round($result[0]) == 1 ? 1 : -1;

    echo "{$a} == {$b} = {$result}\n";
}
