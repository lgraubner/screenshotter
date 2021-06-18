<?php

namespace App\Model;

class Screenshot
{
    private $path;

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
}
