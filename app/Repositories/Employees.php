<?php


namespace App\Repositories;


use Illuminate\Support\Collection;

class Employees extends Repository
{
    public Collection $items;

    public string $api = 'https://interview-assessment-1.realmdigital.co.za/';

    public function __construct()
    {
        $this->items = $this->fetch($this->api . 'employees')
            ->filter(fn($item) => isset($item['name']))
            ->map(fn($item) => new Employee($item));

    }

    public function haveBornToday(): static
    {
        $this->items =  $this->items->filter(fn ($employee) => $employee->haveBornToday());

        return $this;
    }

    public function stillEmployed(): static
    {
        $this->items =  $this->items->filter(fn ($employee) => $employee->stillEmployed());

        return $this;
    }

    public function hasAlreadyStartedWorking(): static
    {

        $this->items =  $this->items->filter(fn ($employee) => $employee->hasAlreadyStartedWorking());

        return $this;
    }


    public function hasNotYetReceivedBirthDayWishes(): static
    {

        $this->items =  $this->items->filter(fn ($employee) => $employee->hasNotYetReceivedBirthDayWishes());

        return $this;
    }

    public function idsExcludedBirthdayWishes(): array
    {
        return $this->fetch($this->api . 'do-not-send-birthday-wishes')
            ->all();
    }

    public function birthWishBlackListed(): static
    {
        $ids = $this->idsExcludedBirthdayWishes();
        $this->items =  $this->items->filter(fn ($employee) => !in_array($employee->id(), $ids));

        return $this;
    }

    public function get(): Collection
    {
        return $this->items;
    }

}
