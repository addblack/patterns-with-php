<?php
interface iDoor {
    public function open(): void;
    public function close(): void;
    public function getStatus(): string;
    public function showStatus(): void;
}

class Door implements iDoor {
    private bool $isOpen = false;

    // Private constructor to prevent direct instantiation
    private function __construct() {}

    public static function create(): self {
        return new self();
    }

    public function open(): void {
        $this->isOpen = true;
    }

    public function close(): void {
        $this->isOpen = false;
    }

    public function getStatus(): string {
        return $this->isOpen ? 'open' : 'closed';
    }

    public function showStatus(): void {
        echo "The door is " . $this->getStatus() . ".\n";
    }
}

class DoorProxy implements iDoor {
    private Door $door;
    private string $password;

    public function __construct(string $password) {
        $this->password = $password;
        $this->door = Door::create(); // Door can only be created here
    }

    private function authenticate(): bool {
        return $this->password === 'correct_password';
    }

    public function open(): void {
        if ($this->authenticate()) {
            $this->door->open();
            echo "Door is now open.\n";
        } else {
            echo "Access denied.\n";
        }
    }

    public function close(): void {
        if ($this->authenticate()) {
            $this->door->close();
            echo "Door is now closed.\n";
        } else {
            echo "Access denied.\n";
        }
    }

    public function getStatus(): string {
        return $this->door->getStatus();
    }

    public function showStatus(): void {
        $this->door->showStatus();
    }
}

// Example
// Password - ok
$proxyWithCorrectPassword = new DoorProxy('correct_password');
// Open door via proxy
$proxyWithCorrectPassword->open();
$proxyWithCorrectPassword->showStatus(); 
// close the door via proxy
$proxyWithCorrectPassword->close(); 
$proxyWithCorrectPassword->showStatus(); 

// Wrong pass
$proxyWithWrongPassword = new DoorProxy('wrong_password');
$proxyWithWrongPassword->open(); // Access denied.
$proxyWithWrongPassword->showStatus(); //  The door is closed.

