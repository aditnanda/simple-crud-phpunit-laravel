<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    use RefreshDatabase;
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    public function goRegist($browser){
        $browser->visit('/') //Go to the homepage
                    ->clickLink('Register') //Click the Register link
                    ->assertSee('Register') //Make sure the phrase in the arguement is on the page
            //Fill the form with these values
                    ->value('#name', 'Joe') 
                    ->value('#email', 'joe@example.com')
                    ->value('#password', '12345678')
                    ->value('#password_confirmation', '12345678')
                    ->click('button[type="submit"]') //Click the submit button on the page
                    ->assertPathIs('/dashboard') //Make sure you are in the home page
            //Make sure you see the phrase in the arguement
                    ->assertSee("You're logged in!");
        return $browser;
    }

    public function testRegister(){
        $this->browse(function ($browser) {
            $browser = $this->goRegist($browser);
        });
    }

    public function testLogin(){
        $this->browse(function ($browser) {
            $browser->visit('/dashboard')
            ->clickLink('Log Out') 
            ->assertSee('Laravel') 
            ->clickLink('Login') 
            ->value('#email', 'joe@example.com')
            ->value('#password', '12345678')
            ->click('button[type="submit"]') 
            ->assertPathIs('/dashboard') 
            ->assertSee("You're logged in!");
        });
    }

    public function testPost(){
        $this->browse(function ($browser) {
            $browser->visit('/posts')
            ->assertSee('Tutorial CRUD Laravel') 
            ;
            $browser->pause(1000);

        });
    }

    public function testPostCreate(){
        $this->browse(function ($browser) {
            $browser->visit('/posts')
            ->clickLink('Create Post') 
            ->assertSee('Create New Post') 
            ->value('#title', 'Aditt')
            ->value('#content', '12345678')
            ->click('button[type="submit"]') 
            ->assertPathIs('/posts') 
            ->assertSee('Aditt') 

            ;
            $browser->pause(1000);

        });
    }

    public function testPostEdit(){
        $this->browse(function ($browser) {
            $browser
            ->clickLink('Edit') 
            ->value('#title', 'Aditt Nanda')
            ->value('#content', '12345678')
            ->click('button[type="submit"]') 
            ->assertPathIs('/posts') 
            ->assertSee('Aditt Nanda') 

            ;
            $browser->pause(1000);

        });
    }

    public function testPostDelete(){
        $this->browse(function ($browser) {
            $browser
            ->visit('/posts')
            ->click('@Delete') 
            ->acceptDialog()
            ->assertPathIs('/posts')

            ;
            $browser->pause(1000);

        });
    }
}
