<?php

namespace XhprofEmbed\Profiler;

/**
 * Xhprof wrapper interface
 */
interface WrapperInterface {
	public function start();
	public function stop();
}
