<?php
require_once(dirname(__FILE__) . '/lib.php');

$validNets = array();
$diriterator = new RecursiveDirectoryIterator("trained");
$iterator = new RecursiveIteratorIterator($diriterator, RecursiveIteratorIterator::SELF_FIRST);
foreach ($iterator as $file) {
    if (strrpos($file, '.nn') == strlen($file) - 3) {
        $validNets[] = $file;
    }
}

$networkstr = 'trained/maths/basic/flex_xor.nn';
if (isset($_GET['net']) && in_array($_GET['net'], $validNets)) {
    $networkstr = $_GET['net'];
}

$network = KeltyNN\NeuralNetwork::loadfile(dirname(__FILE__) . '/' . $networkstr);
?>
<html>
	<head>
		<title><?php echo $network->getTitle(); ?></title>
		<link href='//cdnjs.cloudflare.com/ajax/libs/vis/4.17.0/vis.min.css' rel='stylesheet' type='text/css'>
        <link href='//cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.min.css' rel='stylesheet' type='text/css'>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/vis/4.17.0/vis.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.min.js"></script>
	</head>
	<body>
		<div class='container'>
            <h1><?php echo $network->getTitle(); ?></h1>
            <form method="GET" action="index.php">
                <select name="net">
                    <?php
                    foreach ($validNets as $validNet) {
                        $selected = ($validNet == $networkstr) ? ' selected="selected"' : '';
                        echo "<option value=\"{$validNet}\"{$selected}>{$validNet}</option>";
                    }
                    ?>
                </select>
            </form>
            <div id="network"></div>
		</div>

        <script type="text/javascript">
          // create an array with nodes
          var nodes = new vis.DataSet([
              <?php
              for ($i = 0; $i < $network->getInputCount(); $i++) {
                  echo "{id: '0_{$i}', label: 'Input {$i}'},\n";
              }
              foreach ($network->nodeThreshold as $layer => $nodes) {
                  foreach ($nodes as $num => $node) {
                      echo "{id: '{$layer}_{$num}', label: '{$node}'},\n";
                  }
              }
              ?>
          ]);

          // create an array with edges
          var edges = new vis.DataSet([
              <?php
              foreach ($network->edgeWeight as $layer => $nodes) {
                  foreach ($nodes as $from => $weights) {
					  $nextlayer = $layer + 1;
                      foreach ($weights as $to => $weight) {
						  // Support FlexNet based nets.
						  if (is_string($to)) {
							  $strto = $to;
						  } else {
							  $strto = "{$nextlayer}_{$to}";
						  }

                          echo "{from: '{$layer}_{$from}', to: '{$strto}', label: '{$weight}'},\n";
                      }
                  }
              }
              ?>
          ]);

          // create a network
          var container = document.getElementById('network');
          var data = {
              nodes: nodes,
              edges: edges
          };
            var options = {
                layout: {
                    hierarchical: {
                        direction: "LR",
                        sortMethod: "directed",
                        levelSeparation: 500,
                        nodeSpacing: 150
                    }
                },
                physics: {
                    enabled: false
                },
                nodes: {
                    shape: 'circle'
                },
                edges: {
                    smooth: false,
                    arrows: {
                        to : true
                    }
                },
                configure: true
            };
          var network = new vis.Network(container, data, options);

          $('select').chosen().change(function() {
              $(this).parent().submit();
          });
        </script>
	</body>
</html>
