<?php

namespace XhprofEmbed\Gui\Render;

class CssRenderer implements Renderer {
    public function render() {
        echo file_get_contents(__DIR__ . '/../templates/main.css');
    }
}
