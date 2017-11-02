<?php

namespace Jobs;

use Job;

class Maintenance
{

    /**
     * Clean the job (either postpone or delete depending on conditions)
     *
     * @param Job $job A job to check
     * @void
     */
    public function cleanup(Job $job): void
    {
        // @TODO: implement check if job is done and cover with tests
        //
        // Consider this task is triggered by cron every 2 minutes
        // either Job is locked or cannot be deleted by some reason
        // re-schedule the check to in 10, 20, 30, 40, 50, 60, 60, 60, 90... minutes
        // i.e. if first check is done at 01:00, the next should be done on 01:10, then on 01:30, then on 02:00 etc.
        // force delete if Job runs over 10 hours
    }

}
