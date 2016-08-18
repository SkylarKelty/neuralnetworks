<?php
/**
 * Base Neural Network.
 */

namespace KeltyNN;

class NeuralNetwork
{
    protected $type;
    protected $version;
    protected $description;

    /**
     * Get a description.
     */
    public function get_description() {
        return $this->description;
    }

    /**
     * Set a description.
     */
    public function set_description($description) {
        $this->description = $description;
    }

	/**
	 * Loads a neural network from a file saved by the 'save()' function. Clears
	 * the training and control data added so far.
	 *
	 * @param string $filename The filename to load the network from
	 * @return boolean 'true' on success, 'false' otherwise
	 */
	public static function load($filename) {
		if (file_exists($filename)) {
			$data = parse_ini_file($filename);

			if (!array_key_exists("networktype", $data)) {
                throw new \Exception("Cannot parse Neural network: {$filename}");
            }

            $type = unserialize($data['networktype']);
            $class = "\\KeltyNN\\Networks\\{$type}";
            $obj = new $class();
            $obj->restore($data);
		}

		return false;
	}
}
