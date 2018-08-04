<?php

class StopWatch
{
    protected $filePath;
    protected $startTime;
    protected $stopTime;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        if (file_exists($filePath)) {
            $text = trim(file_get_contents($filePath));
            if ($text) {
                $data = explode("\n", $text);
                $this->startTime = $data[0];
                $this->stopTime = isset($data[1]) ? $data[1] : null;
            }
        } else {
            file_put_contents($filePath, null);
        }

    }

    public function start()
    {
        if ($this->startTime) {
            return false;
        }
        $this->startTime = time();
        $this->save();
        return $this->startTime;
    }

    public function stop()
    {
        if (!$this->startTime) {
            return false;
        }
        $this->stopTime = time();
        $this->save();
        return $this->stopTime;
    }

    public function show()
    {
        if (empty($this->startTime)) {
            return -1;
        }
        if (empty ($this->stopTime)) {
            return time() - $this->startTime;
        }
        return $this->stopTime - $this->startTime;
    }

    public function reset()
    {
        file_put_contents($this->filePath, null);
    }

    public function save()
    {
        file_put_contents($this->filePath, $this->startTime . "\n" . $this->stopTime);
    }
}