<?php namespace Epic;

interface ServiceProvider
{
    public function service();
}

class Template implements ServiceProvider
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function service()
    {
        return function ($name, array $vars = []) use($this) {
            if (!is_file($name)) {
                throw new \Exception("Could not load template file {$name}");
            }
            ob_start();
            extract($vars);
            require($name);
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        };
    }
}