<?php

interface CurrencySubject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

interface Observer {
    public function update(float $currencyRate);
}

// Observe Currency
class Currency implements CurrencySubject {
    private $observers = [];
    private $rate;

    // Add observer
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Remove observer
    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this->rate);
        }
    }

    public function setRate(float $rate) {
        $this->rate = $rate;
        $this->notify();
    }
}

class Bank implements Observer {
    public function update(float $currencyRate) {
        echo "Bank: The currency rate has changed to $currencyRate. Adjusting transactions accordingly.\n";
    }
}

class Broker implements Observer {
    public function update(float $currencyRate) {
        echo "Broker: The currency rate has changed to $currencyRate. Making buy/sell decisions.\n";
    }
}

// Client code to test
function clientCode() {
    $currency = new Currency();

    $bank = new Bank();
    $broker = new Broker();

    $currency->attach($bank);
    $currency->attach($broker);

    // Simulating events
    $currency->setRate(25.50);
    $currency->setRate(26.00);
    $currency->setRate(24.75);
}

// Run the client code
clientCode();
