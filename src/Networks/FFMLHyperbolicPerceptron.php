<?php
/**
 * <b>Multi-layer Neural Network in PHP</b>
 *
 * Feed forward, multi-layer perceptron network with support for momentum learning and an advanced mechanism to prevent overfitting.
 *
 * Loosely based on source code by {@link http://www.philbrierley.com Phil Brierley},
 * that was translated into PHP by 'dspink' in sep 2005
 *
 * Algorithm was obtained from the excellent introductory book
 * "{@link http://www.amazon.com/link/dp/0321204662 Artificial Intelligence - a guide to intelligent systems}"
 * by Michael Negnevitsky (ISBN 0-201-71159-1)
 * // Add test-data to the network. In this case,
 * // we want the network to learn the 'XOR'-function
 * $n->addTestData(array (-1, -1, 1), array (-1));
 * $n->addTestData(array (-1,  1, 1), array ( 1));
 * $n->addTestData(array ( 1, -1, 1), array ( 1));
 * $n->addTestData(array ( 1,  1, 1), array (-1));
 *
 * @author E. Akerboom
 * @author {@link http://www.tremani.nl/ Tremani}, {@link http://maps.google.com/maps?f=q&hl=en&q=delft%2C+the+netherlands&ie=UTF8&t=k&om=1&ll=53.014783%2C4.921875&spn=36.882665%2C110.566406&z=4 Delft}, The Netherlands
 * @since feb 2007
 * @version 1.1
 * @license http://opensource.org/licenses/bsd-license.php BSD License
 */

namespace KeltyNN\Networks;

class FFMLHyperbolicPerceptron extends FFMLPerceptron {
    /**
     * Creates a neural network.
     *
     * Example:
     * <code>
     * // create a network with 4 input nodes, 10 hidden nodes, and 4 output nodes
     * $n = new NeuralNetwork(4, 10, 4);
     *
     * // create a network with 4 input nodes, 1 hidden layer with 10 nodes,
     * // another hidden layer with 10 nodes, and 4 output nodes
     * $n = new NeuralNetwork(4, 10, 10, 4);
     *
     * // alternative syntax
     * $n = new NeuralNetwork(array(4, 10, 10, 4));
     * </code>
     *
     * @param array $nodeCount The number of nodes in the consecutive layers.
     */
    public function __construct($nodeCount) {
		if (!is_array($nodeCount)) {
			$nodeCount = func_get_args();
		}
        parent::__construct($nodeCount);

        $this->type = 'FFMLHyperbolicPerceptron';
        $this->version = '1.1';
    }

	/**
	 * Implements the standard (default) activation function for backpropagation networks.
	 *
	 * @param float $value The preliminary output to apply this function to
	 * @return float The final output of the node
	 */
	protected function activation($value) {
		return ((exp($value) - exp(-$value)) / (exp($value) + exp(-$value)));
	}
}
