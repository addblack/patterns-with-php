<?php
declare(strict_types=1);

interface Weapon
{
    public function clone(): Weapon;
    public function getDescription(): string;
}

class Sword implements Weapon
{
    public function clone(): Weapon
    {
        return new self(); 
    }

    public function getDescription(): string
    {
        return "This is a Sword.";
    }
}

class Gun implements Weapon
{
    public function clone(): Weapon
    {
        return new self();
    }

    public function getDescription(): string
    {
        return "This is a Gun.";
    }
}

class Bow implements Weapon
{
    public function clone(): Weapon
    {
        return new self();
    }

    public function getDescription(): string
    {
        return "This is a Bow.";
    }
}

class WeaponStorage
{
    private array $prototypes = [];

    public function addPrototype(string $name, Weapon $prototype): void
    {
        $this->prototypes[$name] = $prototype;
    }

    public function orderClone(string $name): ?Weapon
    {
        if (isset($this->prototypes[$name])) {
            return $this->prototypes[$name]->clone(); // Return a clone of the prototype
        }
        return null; // Prototype not found
    }
}

// Client code
$storage = new WeaponStorage();

// Adding prototypes
$storage->addPrototype('sword', new Sword());
$storage->addPrototype('gun', new Gun());
$storage->addPrototype('bow', new Bow());

// Ordering clones
$swordClone = $storage->orderClone('sword');
$gunClone = $storage->orderClone('gun');
$bowClone = $storage->orderClone('bow');

// Displaying descriptions
echo $swordClone->getDescription() . PHP_EOL; // Output: This is a Sword.
echo $gunClone->getDescription() . PHP_EOL;   // Output: This is a Gun.
echo $bowClone->getDescription() . PHP_EOL;    // Output: This is a Bow.
