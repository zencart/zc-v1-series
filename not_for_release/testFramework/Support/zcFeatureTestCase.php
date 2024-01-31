<?php
/**
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */

namespace Tests\Support;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use Tests\Support\Traits\ConfigurationSettingsConcerns;
use Tests\Support\Traits\CustomerAccountConcerns;
use Tests\Support\Traits\DatabaseConcerns;
use Tests\Support\Traits\GeneralConcerns;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Support\Traits\LogFileConcerns;

/**
 *
 */
abstract class zcFeatureTestCase extends WebTestCase
{
    use DatabaseConcerns, GeneralConcerns, CustomerAccountConcerns, ConfigurationSettingsConcerns, LogFileConcerns;

    static $firstrun = false;

    /**
     * @param TestResult|null $result
     * @return TestResult
     *
     * This allows us to run in full isolation mode including
     * classes, functions, and defined statements
     */
    public function run(TestResult $result = null): TestResult
    {
        return parent::run($result);
    }

    public function setUp(): void
    {
        $this->createHttpBrowser();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     *
     * set some defines where necessary
     */
    public static function setUpBeforeClass(): void
    {
        if (!defined('ZENCART_TESTFRAMEWORK_RUNNING')) {
            define('ZENCART_TESTFRAMEWORK_RUNNING', true);
        }
        if (!defined('TESTCWD')) {
            define('TESTCWD', realpath(__DIR__ . '/../') . '/');
        }
        if (!defined('ROOTCWD')) {
            define('ROOTCWD', realpath(__DIR__ . '/../../../') . '/');
        }
        if (!defined('TEXT_PROGRESS_FINISHED')) {
            define('TEXT_PROGRESS_FINISHED', '');
        }

    }

}
