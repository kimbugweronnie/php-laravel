<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Testing\File;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use App\Models\Product;
use App\Events\ProcessProductImage;
use App\Listeners\ProductCreation;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_that_file_exists(): void
    {
    
        $file = storage_path('public/spreadsheet.xlx');
        $myfile = File::image('spreadsheet.xlx');
        $this->assertTrue(file_exists('public/spreadsheet.xlx'));

       
    }

    public function test_that_validation_exists(): void
    {
        // Storage::fake('public');
       
        Product::factory()->create([
            'product_code' => '1234412',
            'quantity' => 1222
    
        ]);

        Event::fake();
        Event::assertListening(
            ProcessProductImage::class,
            ProductCreation::class
    );


       


       
    }
}
