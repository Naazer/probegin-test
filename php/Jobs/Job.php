<?php

namespace Jobs;

interface Job
{
    /**
     * Get sheduled timestamp (Time the job started)
     *
     * @return int UNIX timestamp
     */
    public function jobStarted(): int;

    /**
     * Is job locked by some reason
     *
     * @return bool Indicates whether locked or not
     */
    public function isLocked(): bool;

    /**
     * Get last checked timestamp
     *
     * @return int UNIX timestamp (may return 0 if not exists)
     */
    public function lastCheck(): int;

    /**
     * Update last check timestamp
     *
     * @param int $timestamp UNIX timestamp
     * @void
     */
    public function setChecked(int $timestamp): void;

    /**
     * Delete job
     *
     * @param  bool $force optional Whether to force deletion
     * @return bool Indicates whether job has been successfully deleted
     *              Forced deletion always gives TRUE
     */
    public function delete(bool $force = false): bool;

}
