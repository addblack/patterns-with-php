<?php
// Base component interface
interface Unit {
    public function getDescription(): string;
    public function getAttackPower(): int;
}

// Concrete component
class BasicUnit implements Unit {
    public function getDescription(): string {
        return "Basic Unit";
    }

    public function getAttackPower(): int {
        return 10;
    }
}

// Base decorator
abstract class UnitDecorator implements Unit {
    protected Unit $unit;

    public function __construct(Unit $unit) {
        $this->unit = $unit;
    }

    public function getDescription(): string {
        return $this->unit->getDescription();
    }

    public function getAttackPower(): int {
        return $this->unit->getAttackPower();
    }
}

// Concrete decorator for Armored Unit
class ArmoredUnit extends UnitDecorator {
    public function getDescription(): string {
        return $this->unit->getDescription() . ", Armored";
    }

    public function getAttackPower(): int {
        return $this->unit->getAttackPower() - 2; // Less attack due to armor
    }
}

// Concrete decorator for Speedy Unit
class SpeedyUnit extends UnitDecorator {
    public function getDescription(): string {
        return $this->unit->getDescription() . ", Speedy";
    }

    public function getAttackPower(): int {
        return $this->unit->getAttackPower() + 5; // More attack due to speed
    }
}

// Concrete decorator for Accurate Unit
class AccurateUnit extends UnitDecorator {
    public function getDescription(): string {
        return $this->unit->getDescription() . ", Accurate";
    }

    public function getAttackPower(): int {
        return $this->unit->getAttackPower() + 3; // More attack due to accuracy
    }
}

// Client code to test the pattern
function clientCode() {
    $basicUnit = new BasicUnit();
    echo $basicUnit->getDescription() . " with attack power: " . $basicUnit->getAttackPower() . "\n";

    $armoredUnit = new ArmoredUnit($basicUnit);
    echo $armoredUnit->getDescription() . " with attack power: " . $armoredUnit->getAttackPower() . "\n";

    $speedyUnit = new SpeedyUnit($armoredUnit);
    echo $speedyUnit->getDescription() . " with attack power: " . $speedyUnit->getAttackPower() . "\n";

    $accurateUnit = new AccurateUnit($speedyUnit);
    echo $accurateUnit->getDescription() . " with attack power: " . $accurateUnit->getAttackPower() . "\n";
}

clientCode();
