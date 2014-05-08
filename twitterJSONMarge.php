<?php
/**
 * License: GPLv3
 * Date: 2014-05-08 Asia/Tokyo
 * GitHub: https://github.com/reinforchu/twitterJSONMarge
 * Web: http://reinforce.tv/
 */

/**
 * twitter JSON file marge script
 * @author reinforchu
 * @version 0.1.0.0
 */
class twitterJSONMarge {
	private $margeJSON;
	
	/**
	 * Constructor
	 * Execute
	 * @param sourcePath JSON files path
	 * @param outputPath output path
	 */
	public function __construct($sourcePath, $outputPath) {
		self::margeJSONStream($sourcePath);
		// self::margeJSONREST($sourcePath);
		self::writeJSONFile($outputPath);
	}
	/**
	 * for Stream API Search and Trend JSON file
	 * @param path JSON files path
	 */
	private function margeJSONStream($path) {
		$i = $count = 0;
		$this->margeJSON = array();
		if ($handle = opendir($path)) {
			while (FALSE !== ($fileName = readdir($handle))) {
				$i++;
				if ($i > 2 ) {
					$filePath = $path.$fileName;
					$data = json_decode(file_get_contents($filePath), TRUE);
					if (isset($data['text'])) {
						array_push($this->margeJSON, array($count));
						array_push($this->margeJSON[$count], $data);
						$count++;
					}
				}
			}
			closedir($handle);
		}
	}
	
	/**
	 * for REST API Search JSON file
	 * @param path JSON files path
	 */
	private function margeJSONREST($path) {
		$i = $count = $key = 0;
		$this->margeJSON = array();
		if ($handle = opendir($path)) {
			while (FALSE !== ($fileName = readdir($handle))) {
				$i++;
				if ($i > 2 ) {
					$filePath = $path.$fileName;
					$data = json_decode(file_get_contents($filePath), TRUE);
					while (isset($data['statuses'][$key])) {
						array_push($this->margeJSON, array($count));
						array_push($this->margeJSON[$count], $data['statuses'][$key]);
						$key++;
						$count++;
					}
				}
			}
			closedir($handle);
		}
	}

	/**
	 * JSON file writer
	 * @param path output path
	 */
	private function writeJSONFile($path) {
		$pointer = fopen($path, 'w+');
		if (flock($pointer, LOCK_EX)) {
			fwrite($pointer, json_encode($this->margeJSON));
			flock($pointer, LOCK_UN);
			fclose($pointer);
		}
	}
}