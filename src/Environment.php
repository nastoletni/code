<?php
declare(strict_types=1);

namespace Nastoletni\Code;

class Environment {
    private $debug;

    /**
     * Environment constructor.
     *
     * @param bool $debug
     */
    public function __construct(bool $debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * Creates Environment from server global variables.
     *
     * @return Environment
     */
    public static function createFromGlobals(): Environment
    {
        $debug = in_array($_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1']);

        return new static($debug);
    }
    
    /**
     * Returns if debug is enabled.
     *
     * @return bool
     */
    public function getDebug(): bool
    {
        return $this->debug;
    }
}
