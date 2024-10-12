<?php

namespace App\Scheduler;

use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Ayto\NewslaterBundle\Scheduler\Message\SendDailySalesReportsMessage;
use Symfony\Component\Scheduler\RecurringMessage;

#[AsSchedule('mailing')]
class SaleTaskProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('1 second', new SendDailySalesReportsMessage())
        );
    }
}
