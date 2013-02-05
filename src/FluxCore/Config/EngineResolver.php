<?php

namespace FluxCore\Config;

use FluxCore\Config\Engine\EngineInterface;

class EngineResolver
{
	public function resolve($file)
	{
		$extension = file_extension($file);
		if(!isset($this->engines[$extension])) {
			throw new \RuntimeException(
				"There's no engine assigned for the '$extension' file-format."
			);
		}

		return $this->engines[$extension]->parse($file);
	}

	public function register($extension, EngineInterface $engine)
	{
		return ($this->engines[$extension] = $engine);
	}
}