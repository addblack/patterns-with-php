<?php

// Abstract class for parts
abstract class Part
{
    protected bool $done = false;
    protected string $type;

    public function isDone(): bool
    {
        return $this->done;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function complete(): void
    {
        $this->done = true;
    }
}

class Foundation extends Part
{
    protected string $type = 'Foundation';

    public function __construct()
    {
        sleep(1); // Simulate time taken for construction
        $this->complete();
    }
}

class Wall extends Part
{
    protected string $type = 'Wall';

    public function __construct()
    {
        sleep(1);
        $this->complete();
    }
}

class Roof extends Part
{
    protected string $type = 'Roof';

    public function __construct()
    {
        sleep(1);
        $this->complete();
    }
}

class Window extends Part
{
    protected string $type = 'Window';

    public function __construct()
    {
        sleep(1);
        $this->complete();
    }
}

class Door extends Part
{
    protected string $type = 'Door';

    public function __construct()
    {
        sleep(1);
        $this->complete();
    }
}

class House
{
    private array $parts = [];

    public function addPart(Part $part): void
    {
        $this->parts[] = $part;
    }

    public function calculateCost(): int
    {
        // Example costs for parts
        $costs = [
            'Foundation' => 5000,
            'Wall' => 3000,
            'Roof' => 4000,
            'Window' => 1000,
            'Door' => 1200
        ];

        $totalCost = 0;
        foreach ($this->parts as $part) {
            $totalCost += $costs[$part->getType()];
        }

        return $totalCost;
    }
}

class HouseBuilder
{
    private House $house;

    public function __construct()
    {
        $this->house = new House();
    }

    public function buildFoundation(): self
    {
        $this->house->addPart(new Foundation());
        return $this;
    }

    public function buildWall(): self
    {
        $this->house->addPart(new Wall());
        return $this;
    }

    public function buildRoof(): self
    {
        $this->house->addPart(new Roof());
        return $this;
    }

    public function buildWindow(): self
    {
        $this->house->addPart(new Window());
        return $this;
    }

    public function buildDoor(): self
    {
        $this->house->addPart(new Door());
        return $this;
    }

    public function getHouse(): House
    {
        return $this->house;
    }
}

$builder = new HouseBuilder();
$house = $builder
    ->buildFoundation()
    ->buildWall()
    ->buildRoof()
    ->buildWindow()
    ->buildDoor()
    ->getHouse();

$totalCost = $house->calculateCost();
echo "Total cost of building the house: $" . $totalCost . PHP_EOL; 
