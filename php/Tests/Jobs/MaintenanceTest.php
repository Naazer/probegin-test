<?php
/*
 * Created by Nazar Salo.
 * as the part of the test Task for Probegin
 * at 16.12.17 22:11
 */

namespace Tests\Jobs;

use Jobs\Job;
use Jobs\Maintenance;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MaintenanceTest extends TestCase
{
    /** @var Maintenance */
    private $maintenance;

    /** @var Job|MockInterface */
    private $mockJob;

    public function setUp()
    {
        $this->maintenance = new Maintenance();
        $this->mockJob = \Mockery::mock(Job::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Test cleanup when: job has just started and has't checked yet, no locked and can be deleted
     */
    public function testCleanupMostCommon()
    {
        $this->mockJob
            ->shouldReceive('lastCheck')->once()->withNoArgs()->andReturn(0);
        $this->mockJob
            ->shouldReceive('setChecked')->never();
        $this->mockJob
            ->shouldReceive('isLocked')->once()->withNoArgs()->andReturn(false);
        $this->mockJob
            ->shouldReceive('delete')->once()->withNoArgs()->andReturnTrue();
        $this->mockJob
            ->shouldReceive('jobStarted')->never();

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    /**
     * Test cleanup when: job has just started and has't checked yet, no locked and can't be deleted
     */
    public function testCleanupCantDelete()
    {
        $this->mockJob
            ->shouldReceive('lastCheck')->once()->withNoArgs()->andReturn(0);
        $this->mockJob
            ->shouldReceive('setChecked')->once()->with(\Mockery::type('integer'))->andReturnUndefined();
        $this->mockJob
            ->shouldReceive('isLocked')->once()->withNoArgs()->andReturn(false);
        $this->mockJob
            ->shouldReceive('jobStarted')->never();
        $this->mockJob
            ->shouldReceive('delete')->once()->withNoArgs()->andReturnFalse();

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    /**
     * Test cleanup when: job has just started and has't checked yet and locked
     */
    public function testCleanupLocked()
    {
        $this->mockJob
            ->shouldReceive('lastCheck')->once()->withNoArgs()->andReturn(0);
        $this->mockJob
            ->shouldReceive('setChecked')->once()->with(\Mockery::type('integer'))->andReturnUndefined();
        $this->mockJob
            ->shouldReceive('isLocked')->once()->withNoArgs()->andReturn(true);
        $this->mockJob
            ->shouldReceive('jobStarted')->never();
        $this->mockJob
            ->shouldReceive('delete')->never();

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    /**
     * Test cleanup when: job has started 10 hours ago
     */
    public function testCleanupJobStarted10hoursAgo()
    {
        $cTime = time();
        $this->mockJob
            ->shouldReceive('lastCheck')->once()->withNoArgs()->andReturn($cTime - 600);
        $this->mockJob
            ->shouldReceive('jobStarted')->once()->withNoArgs()->andReturn($cTime - 36100);
        $this->mockJob
            ->shouldReceive('isLocked')->never();
        $this->mockJob
            ->shouldReceive('delete')->once()->with(true);

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    /**
     * Test no cleanup because the job was checked in the same diapason
     * @dataProvider providerNoCleanUpAndPostpone
     * @param int $jobStarted
     * @param int $lastCheck
     */
    public function testNoCleanupAndPostpone(int $jobStarted, int $lastCheck)
    {
        $this->mockJob
            ->shouldReceive('lastCheck')->twice()->withNoArgs()->andReturn($lastCheck);
        $this->mockJob
            ->shouldReceive('jobStarted')->twice()->withNoArgs()->andReturn($jobStarted);
        $this->mockJob
            ->shouldReceive('isLocked')->never();
        $this->mockJob
            ->shouldReceive('setChecked')->never();
        $this->mockJob
            ->shouldReceive('delete')->never();

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    public function providerNoCleanUpAndPostpone()
    {
        $data = [
            [8, 1], // 8 min ago job started and 1 minutes was last check
            [13, 2], // 13 min ago job started and 2 minutes was last check
            [50, 10], // 50 min ago job started and 10 minutes was last check
            [90, 2], // 90 min ago job started and 2 minutes was last check
            [111, 2], // 111 min ago job started and 2 minutes was last check
            [121, 5], // 121 min ago job started and 5 minutes was last check
            [180, 2], // 180 min ago job started and 2 minutes was last check
            [220, 2], // 220 min ago job started and 2 minutes was last check
            [300, 10], // 300 min ago job started and 10 minutes was last check
            [410, 1], // 410 min ago job started and 1 minutes was last check
            [490, 0.5], // 490 min ago job started and 0.5 minutes was last check
            [580, 5], // 580 min ago job started and 5 minutes was last check
        ];

        $t = time();
        array_walk_recursive($data, function (&$v) use ($t) { $v = $t - $v*60;});

        return $data;
    }

    /**
     * Test cleanup with check and delete
     * @dataProvider providerCleanUpAndDelete
     * @param int $jobStarted
     * @param int $lastCheck
     */
    public function testCleanupWithCheck(int $jobStarted, int $lastCheck)
    {
        $this->mockJob
            ->shouldReceive('lastCheck')->twice()->withNoArgs()->andReturn($lastCheck);
        $this->mockJob
            ->shouldReceive('jobStarted')->twice()->withNoArgs()->andReturn($jobStarted);
        $this->mockJob
            ->shouldReceive('isLocked')->once()->andReturnFalse();
        $this->mockJob
            ->shouldReceive('delete')->once()->withNoArgs()->andReturnTrue();

        $this->maintenance->cleanup($this->mockJob);

        self::assertTrue(true);
    }

    public function providerCleanUpAndDelete()
    {
        $data = [
            [11, 2], // 11 min ago job started and 2 minutes was last check
            [30, 2], // 30 min ago job started and 2 minutes was last check
            [50, 21], // 50 min ago job started and 21 minutes was last check
            [100, 2], // 100 min ago job started and 2 minutes was last check
            [151, 5], // 151 min ago job started and 5 minutes was last check
            [211, 52], // 211 min ago job started and 52 minutes was last check
            [280, 2], // 280 min ago job started and 2 minutes was last check
            [363, 4], // 363 min ago job started and 4 minutes was last check
            [451, 2], // 451 min ago job started and 2 minutes was last check
            [550, 1], // 550 min ago job started and 1 minutes was last check
        ];

        $t = time();
        array_walk_recursive($data, function (&$v) use ($t) { $v = $t - $v*60;});

        return $data;
    }
}
