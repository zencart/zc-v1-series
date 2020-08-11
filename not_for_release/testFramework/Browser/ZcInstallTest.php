<?php

namespace Tests\Browser;

use Tests\Browser\Pages\zcInstallPage;
use Laravel\Dusk\Browser;

class ZcInstallTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        @unlink(DIR_FS_CATALOG . 'includes/configure.php');
        @unlink(DIR_FS_CATALOG . 'admin/includes/configure.php');#
        $conn = new \mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE, '3306');
        $sql = "DROP DATABASE IF EXISTS " . DB_DATABASE;
        $conn->query($sql);
        $sql = "CREATE DATABASE IF NOT EXISTS " . DB_DATABASE;
        $conn->query($sql);
    }

    /** @test */
    public function zcinstall_page_displays()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1920, 1080);
            $browser->visit(new ZcInstallPage)
                ->screenshot('system')
                ->assertSee('System Inspection')
                ->click('#btnsubmit')
                ->assertSee('Admin Settings')
                ->check('#agreeLicense')
                ->check('#enable_ssl_catalog')
                ->click('#btnsubmit')
                ->assertSee('Basic Settings')
                ->type('#db_host', DB_SERVER)
                ->type('#db_user', DB_SERVER_USERNAME)
                ->type('#db_password', DB_SERVER_PASSWORD)
                ->type('#db_name', DB_DATABASE)
                ->click('#btnsubmit')
                ->waitFor('#admin_user', 1000)
                ->type('#admin_user', ADMIN_NAME)
                ->type('#admin_email', ADMIN_EMAIL)
                ->type('#admin_email2', ADMIN_EMAIL)
                ->click('#btnsubmit')
                ->assertSee('Setup Complete')
            ;
        });
    }
}
