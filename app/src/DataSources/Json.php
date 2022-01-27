<?php

namespace App\DataSources;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\JsonKeyUnknownException;
use App\Facades\Config;
use App\Interfaces\DataSourceInterface;

class Json implements DataSourceInterface
{
    private string $path;
    private string $entityName = '';

    public function __construct()
    {
        $this->path = Config::get('app.json.path');
    }

    /**
     * @param string $path
     * @return $this
     */
    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $entityName
     * @return $this
     */
    public function entity(string $entityName): self
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function fetch(): array
    {
        if(! file_exists($this->path))
        {
            throw new FileNotFoundException($this->path);
        }

        $string = file_get_contents($this->path);

        $result = json_decode($string, true);

        if (! $this->entityName) {
            throw new JsonKeyUnknownException();
        }

        return  $result[$this->entityName] ?? [];
    }
}