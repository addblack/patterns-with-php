<?php
declare(strict_types=1);

interface Button
{
    public function render(): string;
}

class WindowsButton implements Button
{
    public function render(): string
    {
        return "Rendering Windows button.";
    }
}

class MacButton implements Button
{
    public function render(): string
    {
        return "Rendering Mac button.";
    }
}

interface Checkbox
{
    public function render(): string;
}

class WindowsCheckbox implements Checkbox
{
    public function render(): string
    {
        return "Rendering Windows checkbox.";
    }
}

class MacCheckbox implements Checkbox
{
    public function render(): string
    {
        return "Rendering Mac checkbox.";
    }
}

interface UIFactory
{
    public function createButton(): Button;
    public function createCheckbox(): Checkbox;
}

class WindowsFactory implements UIFactory
{
    public function createButton(): Button
    {
        return new WindowsButton();
    }

    public function createCheckbox(): Checkbox
    {
        return new WindowsCheckbox();
    }
}

class MacFactory implements UIFactory
{
    public function createButton(): Button
    {
        return new MacButton();
    }

    public function createCheckbox(): Checkbox
    {
        return new MacCheckbox();
    }
}

// Client class: Application
class Application
{
    private Button $button;
    private Checkbox $checkbox;

    public function __construct(UIFactory $factory)
    {
        $this->button = $factory->createButton();
        $this->checkbox = $factory->createCheckbox();
    }

    public function renderUI(): void
    {
        echo $this->button->render() . PHP_EOL;
        echo $this->checkbox->render() . PHP_EOL;
    }
}

// Client's OS Choice
function getOSFactory(string $os): UIFactory
{
    if ($os === 'Windows') {
        return new WindowsFactory();
    } elseif ($os === 'Mac') {
        return new MacFactory();
    } else {
        throw new InvalidArgumentException("Unsupported OS: $os");
    }
}

// Testing the factories
try {
    $os = 'Windows';  // Change to 'Mac' for Mac UI
    $factory = getOSFactory($os);
    $app = new Application($factory);
    $app->renderUI();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
