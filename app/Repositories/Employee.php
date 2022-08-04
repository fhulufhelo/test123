<?php


namespace App\Repositories;

class Employee
{
    public int|null $id = null;
    public string|null $name = null;
    public string|null $lastname = null;
    public string|null $dateOfBirth = null;
    public string|null $employmentStartDate = null;
    public string|null $employmentEndDate = null;
    public string|null $lastNotification = null;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {

            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }


    public function haveBornToday(): bool
    {
        return date("md", strtotime($this->dateOfBirth)) === date("md");
    }

    public function stillEmployed(): bool
    {
        return is_null($this->employmentEndDate);
    }

    public function hasAlreadyStartedWorking(): bool
    {

        if (is_null($this->employmentStartDate)) {
            return false;
        }

        return strtotime($this->employmentStartDate) < time();
    }

    public function hasNotYetReceivedBirthDayWishes(): bool
    {
        if (is_null($this->lastNotification)) {
            return true;
        }

        return date("Y", strtotime($this->lastNotification)) !== date("Y");
    }

    public function fullName(): string
    {
        return $this->name .' ' . $this->lastname;
    }

    public function id(): ?int
    {
        return $this->id;
    }

}
