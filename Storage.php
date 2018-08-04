<?php

class Storage
{
    protected $filePath;
    protected $data = [];

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        if (file_exists($filePath)) {
            $text = trim(file_get_contents($filePath));
            if ($text) {
                $this->data = explode("\n", $text);
            }
        } else {
            file_put_contents($filePath, null);
        }
    }

    public function restore()
    {
        return $this->data;
    }

    public function store($startTime, $stopTime)
    {
        file_put_contents($this->filePath, $startTime . "\n" . $stopTime);
    }

    public function clear()
    {
        file_put_contents($this->filePath, null);
    }
}