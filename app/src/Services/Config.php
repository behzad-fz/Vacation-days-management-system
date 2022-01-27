<?php

namespace App\Services;

class Config
{
    const SOURCE_DIRECTORY = 'config';

    private array $data = [];

    /**
     * @var Config|null
     */
    private static Config|null $instance = null;

    /**
     * @return Config
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key, $default = null)
    {
        $key = explode('.', $key);

        if (isset($key[0]) && ! isset($this->data[$key[0]])) {
            $this->init($key[0], $default);
        }

        $config = $this->data;
        for ($i = 0;$i < count($key); $i++) {
            $config = $config[$key[$i]] ?? null;
        }

        return $config ?? $default;
    }

    /**
     * @param $configFileName
     * @param $default
     */
    private function init($configFileName, $default)
    {
        $fileName = self::SOURCE_DIRECTORY.'/'.($configFileName ?? '');

        if (! file_exists($fileName.'.php')) {
            return $default;
        }

        $this->data[$configFileName] = include(self::SOURCE_DIRECTORY.'/'.$configFileName.'.php');
    }
}