<?php

namespace XhprofEmbed\Gui\Data;

use XhProf\Storage\StorageInterface;

abstract class BaseProvider implements Provider {
    protected $storage;

    public function __construct(StorageInterface $storage) {
        $this->storage = $storage;
    }
}
