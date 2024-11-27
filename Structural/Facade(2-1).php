<?php

// Service to book rental equipment
class SkiRentalService
{
    public function rentSkis(string $customerName): void
    {
        echo "Ski rental service: Renting skis for $customerName.\n";
    }

    public function rentHelmet(string $customerName): void
    {
        echo "Ski rental service: Renting a helmet for $customerName.\n";
    }
}

// Service to book hotel rooms
class HotelBookingService
{
    public function bookRoom(string $customerName, string $roomType): void
    {
        echo "Hotel booking service: Booking a $roomType room for $customerName.\n";
    }
}

// Service for additional resort activities
class ResortActivityService
{
    public function bookSkiLesson(string $customerName): void
    {
        echo "Resort activity service: Booking a ski lesson for $customerName.\n";
    }

    public function bookSpa(string $customerName): void
    {
        echo "Resort activity service: Booking a spa session for $customerName.\n";
    }
}

// The Facade class
class ResortBookingFacade
{
    private SkiRentalService $skiRentalService;
    private HotelBookingService $hotelBookingService;
    private ResortActivityService $resortActivityService;

    public function __construct()
    {
        $this->skiRentalService = new SkiRentalService();
        $this->hotelBookingService = new HotelBookingService();
        $this->resortActivityService = new ResortActivityService();
    }

    public function bookCompletePackage(string $customerName, string $roomType): void
    {
        // Use facade to simplify booking process
        echo "Starting booking process for $customerName...\n";
        $this->hotelBookingService->bookRoom($customerName, $roomType);
        $this->skiRentalService->rentSkis($customerName);
        $this->skiRentalService->rentHelmet($customerName);
        $this->resortActivityService->bookSkiLesson($customerName);
        echo "Booking process completed for $customerName.\n";
    }

    public function bookCustomPackage(string $customerName, string $roomType, bool $spaIncluded): void
    {
        echo "Starting custom booking process for $customerName...\n";
        $this->hotelBookingService->bookRoom($customerName, $roomType);
        $this->skiRentalService->rentSkis($customerName);

        if ($spaIncluded) {
            $this->resortActivityService->bookSpa($customerName);
        }

        echo "Custom booking process completed for $customerName.\n";
    }
}

// Client code
$resortFacade = new ResortBookingFacade();
$resortFacade->bookCompletePackage("Alice", "Deluxe");
echo "\n";
$resortFacade->bookCustomPackage("Bob", "Standard", true);
