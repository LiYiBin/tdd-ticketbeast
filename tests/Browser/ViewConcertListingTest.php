<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Concert;
USE Carbon\Carbon;

class ViewConcertListingTest extends DuskTestCase
{
     use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_concert_listing()
    {
        // Arrange
        // Create a concert
        $concert = Concert::create([
            'title' => 'The Red Chord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2016 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'The Mosh Pit',
            'venue_address' => '123 Example Lane',
            'city' => 'Laraville',
            'state' => 'ON',
            'zip' => '17916',
            'additional_intformation' => 'For tickets, call (555) 555-5555.',
        ]);
        
        $this->browse(function ($browser) use ($concert) {
            // Act
            // View the concert listing
            $browser->visit('/concerts/'.$concert->id);

            // Assert
            // See the concert details
            $browser->assertSee('The Red Chord')
                ->assertSee('with Animosity and Lethargy')
                ->assertSee('December 13, 2016')
                ->assertSee('8:00pm')
                ->assertSee('32.50')
                ->assertSee('The Mosh Pit')
                ->assertSee('123 Example Lane')
                ->assertSee('Laraville, ON 17916')
                ->assertSee('For tickets, call (555) 555-5555.');
        });
    }
}