<?php

class Worker {
    public function work(): void
    {
        # working
    }
}

class Manager {
    private $worker;

    public function setWorker(Worker $worker): void
    {
        $this->worker = $worker;
    }

    public function manage(): void
    {
        $this->worker->work();
    }
}

class SuperWorker {
    public function work(): void
    {
        # working much more
    }
}
