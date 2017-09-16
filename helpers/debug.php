<?php

if (! function_exists('app_trace')) {
    /**
     * @param int $backtrace
     * @param string $key
     * @param bool $exit
     */
    function app_trace($backtrace = 2, $key = null, $exit = false)
    {
        $trace = debug_backtrace();
        $caller = (! empty($trace[$backtrace])) ? $trace[$backtrace] : $trace[2];
        if ($exit) {
            if (is_string($key) && isset($caller[$key])) {
                $caller = $caller[$key];
            }
            dd($caller);
        }
        debug($caller);
    }
}
