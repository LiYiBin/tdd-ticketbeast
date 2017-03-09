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
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2017-03-09 03:30pm'),
        ]);

        $this->assertEquals('March 9, 2017', $concert->formatted_date);
    }

    /** @test */
    public function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2017-03-09 03:30pm'),
        ]);
        
        $this->assertEquals('3:30pm', $concert->formatted_start_time);
    }

    /** @test */
    public function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750,
        ]);
        
        $this->assertEquals('67.50', $concert->ticket_price_in_dollars);
    }

    /** @test */
    public function concerts_with_a_published_at_date_are_published()
    {
        $published = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $published2 = factory(Concert::class)->create(['published_at' => Carbon::parse('-2 week')]);
        $unpublished = factory(Concert::class)->create(['published_at' => null]);
        
        $publishedConcerts = Concert::published()->get();

        $this->assertTrue($publishedConcerts->contains($published));
        $this->assertTrue($publishedConcerts->contains($published2));
        $this->assertFalse($publishedConcerts->contains($unpublished));
    }
}
