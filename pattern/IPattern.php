<?php

namespace framework\icf\pattern;

interface IPattern {
	
	public function validateChild($childFileData);

	public function retrieveChildData($backtraceData);
	
}

?>