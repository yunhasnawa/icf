<?php

namespace icf\pattern;

interface IPattern {
	
	public function validateChild($childFileData);

	public function retrieveChildData($backtraceData);
	
}

?>