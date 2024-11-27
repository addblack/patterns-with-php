<?php

interface Handler {
    public function setNext(Handler $handler): Handler;
    public function handle(int $amount): array;
}

abstract class CashHandler implements Handler {
    protected ?Handler $nextHandler = null;
    protected int $denomination;
    protected int $availableNotes;

    public function __construct(int $denomination, int $availableNotes) {
        $this->denomination = $denomination;
        $this->availableNotes = $availableNotes;
    }

    public function setNext(Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(int $amount): array {
        if ($amount >= $this->denomination && $this->availableNotes > 0) {
            $neededNotes = min(floor($amount / $this->denomination), $this->availableNotes);
            $amount -= $neededNotes * $this->denomination;
            $this->availableNotes -= $neededNotes;

            return [$this->denomination => $neededNotes] + ($this->nextHandler ? $this->nextHandler->handle($amount) : []);
        }

        return $this->nextHandler ? $this->nextHandler->handle($amount) : [];
    }
}

class HundredHandler extends CashHandler {
    public function __construct(int $availableNotes) {
        parent::__construct(100, $availableNotes);
    }
}

class FiftyHandler extends CashHandler {
    public function __construct(int $availableNotes) {
        parent::__construct(50, $availableNotes);
    }
}

class TwentyHandler extends CashHandler {
    public function __construct(int $availableNotes) {
        parent::__construct(20, $availableNotes);
    }
}

class FiveHandler extends CashHandler {
    public function __construct(int $availableNotes) {
        parent::__construct(5, $availableNotes);
    }
}

// Bankomat class
class Bankomat {
    private Handler $chain;

    public function __construct() {
        // Create the chain of handlers
        $this->chain = new HundredHandler(10);
        $fiftyHandler = new FiftyHandler(10);
        $twentyHandler = new TwentyHandler(10);
        $fiveHandler = new FiveHandler(10);

        $this->chain->setNext($fiftyHandler)->setNext($twentyHandler)->setNext($fiveHandler);
    }

    public function withdraw(int $amount): array {
        $result = $this->chain->handle($amount);
        if (empty($result)) {
            return ["error" => "Unable to dispense the requested amount."];
        }
        return $result;
    }
}

// Client code
$Bankomat = new Bankomat();
$amountToWithdraw = 260; // Amount requested by the client
$result = $Bankomat->withdraw($amountToWithdraw);

if (isset($result['error'])) {
    echo $result['error'];
} else {
    echo "Dispensed:\n";
    foreach ($result as $denomination => $count) {
        if ($count > 0) {
            echo "{$count} notes of {$denomination} грн\n";
        }
    }
}

?>
