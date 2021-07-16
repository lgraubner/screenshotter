<?php

declare(strict_types=1);

namespace App\Model;

class Screenshot
{
    private $url;
    private $filename;
    private $path;
    private $parameters;

    public function __construct(string $url, $parameters = [])
    {
        $this->url = $url;
        $this->parameters = $parameters;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }
}
