<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Concert;
use Carbon\Carbon;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_get_formatted_date()
    {
        // Arrange
        $concert = factory(Concert::class)->create([
            'date' => Carbon::parse('2017-03-09 03:30pm'),
        ]);

        // Act
        $date = $concert->formatted_date;

        // Assert
        $this->assertEquals('March 9, 2017', $date);
    }
}
