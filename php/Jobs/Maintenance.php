<?php

namespace Jobs;

class Maintenance
{
    /**
     * This is the ranges of result minutes
     * that give you ability to check the current time and decide the next checking
     *
     * PS: I counted it manually and didn't use dynamic calculation,
     * because the task clearly set the conditions and I'm a passionate supporter of the YAGNI principle
     *
     * 10  = 10
     * 30  = 10+20
     * 60  = 10+20+30
     * 100 = 10+20+30+40
     * 150 = 10+20+30+40+50
     * 210 = 10+20+30+40+50+60
     * 280 = 10+20+30+40+50+60+70
     * 360 = 10+20+30+40+50+60+70+80
     * 450 = 10+20+30+40+50+60+70+80+90
     * 550 = 10+20+30+40+50+60+70+80+90+100
     * 660 = 10+20+30+40+50+60+70+80+90+100+110
     */
    private const RANGES = [10, 30, 60, 100, 150, 210, 280, 360, 450, 550, 660];

    /**
     * Clean the job (either postpone or delete depending on conditions)
     *
     * Consider this task is triggered by cron every 2 minutes
     * either Job is locked or cannot be deleted by some reason
     * re-schedule the check to in 10, 20, 30, 40, 50, 60, 70, 80, 90... minutes
     * i.e. if first check is done at 01:00, the next should be done on 01:10, then on 01:30, then on 02:00 etc.
     * force delete if Job runs over 10 hours
     *
     * @param  Job $job A job to check
     * @return void
     */
    public function cleanup(Job $job): void
    {
        $currentTime = time();
        if ($job->lastCheck() === 0) {
            $this->postpone($job, $currentTime);
            return;
        }
        /** @var int $deltaCurrent time difference in minutes between start job and current timestamp */
        $deltaCurrent = intdiv($currentTime - $job->jobStarted(), 60);
        if ($deltaCurrent > 600) {
            $job->delete(true);
            return;
        }
        /** @var int $deltaChecked time difference in minutes between last check and current timestamp */
        $deltaChecked = intdiv($job->lastCheck() - $job->jobStarted(), 60);
        foreach (self::RANGES as $i => $hours) {
            if ($deltaChecked > $hours) {
                continue;
            }
            if ($deltaCurrent >= $hours) { // The current date is in the next range so try delete the job
                $this->postpone($job, $currentTime);
                break;
            }
        }
    }

    /**
     * If job wasn't locked we remove it.
     * If job locked or cant be removed we should postpone it
     * @param Job $job
     * @param $currentTime
     */
    private function postpone(Job $job, $currentTime): void
    {
        if ($job->isLocked() || !$job->delete()) {
            $job->setChecked($currentTime);
        }
    }
}
