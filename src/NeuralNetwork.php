<?php
/**
 * Base Neural Network.
 */

namespace KeltyNN;

class NeuralNetwork
{
    protected $type;
    protected $version;
    protected $title;
    protected $description;

    /**
     * Get a title.
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set a title.
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get a description.
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set a description.
     */
    public function setDescription($description) {
        $this->description = $description;
    }

	/**
	 * Saves a neural network to a file
	 *
	 * @param string $filename The filename to save the neural network to
	 * @return boolean 'true' on success, 'false' otherwise
	 */
	public function save($filename) {
        $export = $this->export();
        return file_put_contents($filename, serialize($export));
	}

	/**
	 * Loads a neural network from a file saved by the 'save()' function. Clears
	 * the training and control data added so far.
	 *
	 * @param string $filename The filename to load the network from
	 * @return boolean 'true' on success, 'false' otherwise
	 */
	public static function load($filename) {
		if (!file_exists($filename)) {
        	return false;
        }

        $data = file_get_contents($filename);
        $data = unserialize($data);
        if (!$data) {
            return false;
        }

        $class = "\\KeltyNN\\Networks\\" . $data['type'];

        $obj = new $class($data['nodeCount']);
        if ($obj->restore($data)) {
            return $obj;
        }

		return false;
	}

	/**
	 * Loads a neural network from a file saved by the 'save()' function. Clears
	 * the training and control data added so far.
	 *
	 * @param string $filename The filename to load the network from
	 * @return boolean 'true' on success, 'false' otherwise
	 */
	protected function restore($data) {
		// make sure all standard preparations performed
		$this->initWeights();

		$this->weightsInitialized = true;

		// if we do not reset the training and control data here, then we end up
		// with a bunch of IDs that do not refer to the actual data we're training
		// the network with.
		$this->controlInputs = array();
		$this->controlOutput = array();

		$this->trainInputs = array();
		$this->trainOutput = array();

        $this->import($data);

        return true;
	}

    /**
     * Combines two neural networks such that the output nodes of network a
     * are fed into the input nodes of network b.
     */
    public static function combine($networka, $networkb) {
        // TODO.
    }
}
