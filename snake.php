<?php
require_once(dirname(__FILE__) . '/lib.php');

$network = new KeltyNN\Networks\FFMLFlexPerceptron(16, 0, 4);
$network->setDesignerMode();
$trainer = new KeltyNN\Trainers\Genetic($network);

// Train a network for this game.
$trainer->run(function($ontick) {
    $gamespace = new \KeltyNN\Input\Snake(50, 50);
    for ($i = 0; $i < 1000; $i++) {
        // Get the space around the head.
        $space = $gamespace->exportSnakeSpace(4, 4);
        // Translate to flattened array.
        $arr = array();
        foreach ($space as $x => $y) {
            foreach ($y as $val) {
                $arr[] = $val;
            }
        }
        // Get the network to calculate the next move.
        $moves = $ontick($arr);
        foreach ($moves as $direction => $value) {
            if ($value > 0 && $gamespace->changeDirection($direction)) {
                break;
            }
        }

        $gamespace->tick();
    }

    return $gamespace->turns + ($gamespace->score * 2);
});

// Grab the best result.
$network = $trainer->bestNetwork();

// Run through the chosen network and record its progress.
$gamespace = new \KeltyNN\Input\Snake(50, 50);
$stages = array($gamespace->exportNormal(false));
for ($i = 0; $i < 1000; $i++) {
    // Get the space around the head.
    $space = $gamespace->exportSnakeSpace(4, 4);
    // Translate to flattened array.
    $arr = array();
    foreach ($space as $x => $y) {
        foreach ($y as $val) {
            $arr[] = $val;
        }
    }
    // Get the network to calculate the next move.
    $moves = $network->calculate($gamespace->exportSnakeSpace(4, 4));
    foreach ($moves as $direction => $value) {
        if ($value > 0 && $gamespace->changeDirection($direction)) {
            break;
        }
    }

    $gamespace->tick();
    $stages[] = $gamespace->exportNormal(false);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Snek!</title>
		<link href='//cdnjs.cloudflare.com/ajax/libs/vis/4.17.0/vis.min.css' rel='stylesheet' type='text/css'>
        <link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
        <link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
        <p><?php echo "Best score: " . ($gamespace->turns + ($gamespace->score * 2)); ?></p>
        <canvas id="snakepit" width="500" height="500" style="border: 1px solid black;"></canvas>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/vis/4.17.0/vis.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
        <script type="text/javascript">
        function runFunction(name, arguments) {
            var fn = window[name];
            if(typeof fn !== 'function')
                return;

            fn.apply(window, arguments);
        }

        // Draw the snek pit!
        var canvas = document.getElementById("snakepit");
        var ctx = canvas.getContext("2d");

        <?php
        foreach ($stages as $stage => $points) {
            echo "function step{$stage}() {";
            echo 'ctx.fillStyle = "white";';
            echo "ctx.fillRect(0, 0, 500, 500);";
            foreach ($points as $x => $xpoints) {
                foreach ($xpoints as $y => $type) {
                    $realx = $x * 10;
                    $realy = $y * 10;
                    if ($type == 1) {
                        echo 'ctx.fillStyle = "green";';
                        echo "ctx.fillRect({$realx}, {$realy}, 10, 10);";
                    } else if ($type == -1) {
                        echo 'ctx.fillStyle = "red";';
                        echo "ctx.fillRect({$realx}, {$realy}, 10, 10);";
                    }
                }
            }
            echo "}\n";
        }
        ?>

        step0();
        var step = 1;
        setInterval(function() {
            runFunction('step' + step, []);
            step++;
        }, 250);

        </script>
    </body>
</html>
