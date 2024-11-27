<?php

// Завдання 1.1  Реалізувати приклад з адаптації круглого отвору під квадратний кілок.

class RoundHole
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getRadius(): float
    {
        return $this->radius;
    }

    public function fits(RoundPeg $peg): bool
    {
        return $this->radius >= $peg->getRadius();
    }
}

class RoundPeg
{
    protected float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function getRadius(): float
    {
        return $this->radius;
    }
}

// The SquarePeg class (Incompatible with RoundHole)
class SquarePeg
{
    private float $width;

    public function __construct(float $width)
    {
        $this->width = $width;
    }

    public function getWidth(): float
    {
        return $this->width;
    }
}

class SquarePegAdapter extends RoundPeg
{
    private SquarePeg $peg;

    public function __construct(SquarePeg $peg)
    {
        $this->peg = $peg;
        parent::__construct($this->calculateRadius());
    }

    private function calculateRadius(): float
    {
        // Calculate the minimum circle radius that fits the square
        return $this->peg->getWidth() * sqrt(2) / 2;
    }
}


$roundHole = new RoundHole(5);
$roundPeg = new RoundPeg(5);
$squarePegSmall = new SquarePeg(5);
$squarePegLarge = new SquarePeg(10);

// Test round peg fits round hole
if ($roundHole->fits($roundPeg)) {
    echo "Round peg fits in the round hole.\n";
} else {
    echo "Round peg doesn't fit in the round hole.\n";
}

// Use the adapter to fit square pegs in round holes
$smallSquarePegAdapter = new SquarePegAdapter($squarePegSmall);
$largeSquarePegAdapter = new SquarePegAdapter($squarePegLarge);

if ($roundHole->fits($smallSquarePegAdapter)) {
    echo "Small square peg fits in the round hole via adapter.\n";
} else {
    echo "Small square peg doesn't fit in the round hole.\n";
}

if ($roundHole->fits($largeSquarePegAdapter)) {
    echo "Large square peg doesn't fit in the round hole via adapter.\n";
}
