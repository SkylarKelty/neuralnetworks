<html>
	<head>
		<title>Learning the gt function</title>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<style type='text/css'>
			body { padding:0px; margin:0px; background: #e8e8e8; font-family: "Open Sans", Helvetica, Arial, sans; }
			.container { margin: 30px auto; padding:20px; max-width: 900px; background: #f8f8f8; border:2px solid #a8a8a8; border-radius: 10px; -moz-border-radius:10px; -webkit-border-radius:10px; -o-border-radius:10px;}
			.container > h1:first-child { margin-top:0px; }
			.result { padding:10px; background: #f0f0f0; margin: 0 auto; max-width:650px; }
			h1, h2 { padding:0px; margin:40px 0px 0px; }
			p { margin: 0px 0px 20px; }
		</style>
	</head>
	<body>
		<div class='container'>
		<?php
require_once ("lib.php");

// Create a new neural network with 3 input neurons,
// 4 hidden neurons, and 1 output neuron
$n = new KeltyNN\NeuralNetwork(2, 6, 1);
$n->setVerbose(false);

// Add test-data to the network. In this case,
// we want the network to learn the '>'-function
$n->addTestData(array (500, 200), array (1));
$n->addTestData(array (300, 20), array (1));
$n->addTestData(array (201, 70), array (1));
$n->addTestData(array (700, 300), array (1));
$n->addTestData(array (520, 100), array (1));
$n->addTestData(array (520, 2000), array (0));
$n->addTestData(array (50, 200), array (0));
$n->addTestData(array (20, 50), array (0));
$n->addTestData(array (500, 1000), array (0));
$n->addTestData(array (200, 500), array (0));

// we try training the network for at most $max times
$max = 6;
$i = 0;

echo "<h1>Learning the gt function</h1>";
// train the network in max 1000 epochs, with a max squared error of 0.01
while (!($success = $n->train(10000, 0.001)) && ++$i < $max) {
	echo "Round $i: No success...<br />";
}
// print a message if the network was succesfully trained
if ($success) {
    $epochs = $n->getEpoch();
    $n->save(dirname(__FILE__) . "/trained/maths/basic/gt.nn");
	echo "Success in $epochs training rounds!<br />";
}
echo "<h2>Result</h2>";
echo "<div class='result'>";
// in any case, we print the output of the neural network
for ($i = 0; $i < count($n->trainInputs); $i ++) {
	$output = $n->calculate($n->trainInputs[$i]);
	echo "<div>Testset $i; ";
	echo "expected output = (".implode(", ", $n->trainOutput[$i]).") ";
	echo "output from neural network = (".implode(", ", $output).")\n</div>";
}
echo "</div>";

echo "<h2>Internal network state</h2>";
$n->showWeights($force=true);

?>
		</div>
	</body>
</html>
