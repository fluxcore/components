<?php

namespace FluxCore\IO;

class FileFinder
{
	protected $path;

	function __construct($path)
	{
		$this->path = rtrim($path, '\\/').'/';
		
		if(!is_dir($this->path)) {
			throw new \RuntimeException(
				"The path '{$this->path}' does not exist."
			);
		}
	}

	public function find($abstract, $extension = '*')
	{
		$findPath = str_replace('.', '/', $abstract).'.'.$extension;
		$results = glob($this->path.$findPath);

		return (is_array($results)) ? $results : array();
	}
}