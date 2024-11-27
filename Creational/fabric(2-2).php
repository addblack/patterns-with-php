<?php
declare(strict_types=1);

abstract class Unit
{
    protected int $health;
    protected int $damage;

    public function __construct(int $health, int $damage)
    {
        $this->health = $health;
        $this->damage = $damage;
    }

    abstract public function getInfo(): string;
}

class Marine extends Unit
{
    public function __construct()
    {
        parent::__construct(100, 25);
    }

    public function getInfo(): string
    {
        return "Marine: Health = {$this->health}, Max damage = {$this->damage}";
    }
}

class MadScientist extends Unit
{
    public function __construct()
    {
        parent::__construct(80, 40);
    }

    public function getInfo(): string
    {
        return "Scientist: Health = {$this->health},  Max damage = {$this->damage}";
    }
}

class CombatMedic extends Unit
{
    public function __construct()
    {
        parent::__construct(120, 10);
    }

    public function getInfo(): string
    {
        return "Medic: Health = {$this->health}, Max damage = {$this->damage}";
    }
}

abstract class Barrack
{
    abstract public function createUnit(): Unit;
}

class MilitaryBarrack extends Barrack
{
    public function createUnit(): Unit
    {
        return new Marine();
    }
}

class ScientistBarrack extends Barrack
{
    public function createUnit(): Unit
    {
        return new MadScientist();
    }
}

class MedicalBarrack extends Barrack
{
    public function createUnit(): Unit
    {
        return new CombatMedic();
    }
}

// Test
function testBarracks(Barrack $barrack): void
{
    $unit = $barrack->createUnit();
    echo $unit->getInfo() . PHP_EOL;
}

testBarracks(new MilitaryBarrack()); 
testBarracks(new ScientistBarrack()); 
testBarracks(new MedicalBarrack());
