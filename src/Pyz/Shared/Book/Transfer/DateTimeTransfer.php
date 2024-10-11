<?php

namespace Generated\Shared\Transfer;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class DateTimeTransfer extends AbstractTransfer
{
    protected $date;
    protected $timezone;

    // Getters and Setters

    public function fromDateTime(\DateTime $dateTime)
    {
        $this->date = $dateTime->format('Y-m-d H:i:s');
        $this->timezone = $dateTime->getTimezone()->getName();

        return $this;
    }


    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }
}
