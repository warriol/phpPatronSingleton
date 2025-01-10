<?php
class RateLimiter {
    private $limit;
    private $interval;
    private $requests = [];

    public function __construct($limit, $interval) {
        $this->limit = $limit;
        $this->interval = $interval;
    }

    public function isAllowed($ip) {
        $currentTime = time();
        if (!isset($this->requests[$ip])) {
            $this->requests[$ip] = [];
        }
        $this->requests[$ip] = array_filter($this->requests[$ip], function ($timestamp) use ($currentTime) {
            return ($currentTime - $timestamp) < $this->interval;
        });
        if (count($this->requests[$ip]) < $this->limit) {
            $this->requests[$ip][] = $currentTime;
            return true;
        }
        return false;
    }
}