<?php

interface IWorker {
    public function work(): void;
}

class Worker implements IWorker
{
    public function work(): void
    {
	# working
    }
}

class SuperWorker implements IWorker
{
    public function work(): void
    {
	# working much more
    }
}

class Manager 
{
    private $worker;

    public function setWorker(IWorker $worker): void
    {
	$this->worker = $worker;
    }

    public function manage(): void
    {
	$this->worker->work();
    }
}
