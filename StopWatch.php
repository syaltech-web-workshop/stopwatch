<?php


class StopWatch
{
    protected $storage;
    protected $startTime;
    protected $stopTime;

    public function __construct($storage)
    {
        $this->storage = $storage;
        $data = $storage->restore();
        $this->startTime = isset($data[0]) ? $data[0] : null;
        $this->stopTime = isset($data[1]) ? $data[1] : null;
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
            return -1;
        }
        if ($this->stopTime){
            return -2 ;
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
        $this->storage->clear();
    }

    public function save()
    {
        $this->storage->store($this->startTime,$this->stopTime);
    }
}