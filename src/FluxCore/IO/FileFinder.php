<?php

namespace FluxCore\IO;

/**
 * File finder class.
 */
class FileFinder
{
	/**
	 * The base path for the file finder.
	 * 
	 * @var string
	 */
	protected $path;

	/**
	 * Creates a new file finder instance.
	 * 
	 * @param string $path
	 */
	function __construct($path)
	{
		$this->path = rtrim($path, '\\/').'/';
		
		if(!is_dir($this->path)) {
			throw new \RuntimeException(
				"The path '{$this->path}' does not exist."
			);
		}
	}

	/**
	 * Find files from abstract. (dot-notated abstract path)
	 * 
	 * @param string $abstract
	 * @param string $extension
	 * @return array
	 */
	public function find($abstract, $extension = '*')
	{
		$findPath = str_replace('.', '/', $abstract).'.'.$extension;
		$results = glob($this->path.$findPath);

		return (is_array($results)) ? $results : array();
	}
}