<?php

interface TrafficLightState {
    public function change(TrafficLightContext $context);
    public function getColor(): string;
}

// State: Green
class GreenState implements TrafficLightState {
    public function change(TrafficLightContext $context) {
        echo "Traffic light is now GREEN. Cars can go.\n";
        $context->setState(new YellowState()); // Change to Yellow
    }

    public function getColor(): string {
        return "Green";
    }
}

// State: Yellow
class YellowState implements TrafficLightState {
    public function change(TrafficLightContext $context) {
        echo "Traffic light is now YELLOW. Prepare to stop.\n";
        $context->setState(new RedState()); // Change to Red
    }

    public function getColor(): string {
        return "Yellow";
    }
}

// State: Red
class RedState implements TrafficLightState {
    public function change(TrafficLightContext $context) {
        echo "Traffic light is now RED. Cars must stop.\n";
        $context->setState(new GreenState()); // Change to Green
    }

    public function getColor(): string {
        return "Red";
    }
}

class TrafficLightContext {
    private TrafficLightState $state;

    public function __construct(TrafficLightState $state) {
        $this->setState($state);
    }

    public function setState(TrafficLightState $state) {
        $this->state = $state;
    }

    public function change() {
        $this->state->change($this);
    }

    public function getCurrentColor(): string {
        return $this->state->getColor();
    }
}

$trafficLight = new TrafficLightContext(new GreenState());

for ($i = 0; $i < 6; $i++) { // Loop through the states a few times
    echo "Current light: " . $trafficLight->getCurrentColor() . "\n";
    $trafficLight->change();
}

?>
