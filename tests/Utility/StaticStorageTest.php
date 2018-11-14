<?php
declare(strict_types=1);

namespace App\Tests\Utility;

use PHPUnit\Framework\TestCase;

use App\Utility\StaticStorage as Target;

/**
 * Class StaticStorageTest
 *
 * @package App\Tests\Utility
 */
class StaticStorageTest extends TestCase
{
    /**
     * Test `seoTransIndex` static method
     *
     * @return void
     * @group utility
     * @group done
     */
    public function testSeoTransIndex(): void
    {
        $expected = 'default';

        $this->assertEquals($expected, Target::seoTransIndex());
    }

    /**
     * Test `seoTransSiteNameIndex` static method
     *
     * @return void
     * @group utility
     * @group done
     */
    public function testSeoTransSiteNameIndex(): void
    {
        $expected = 'default.site_name';

        $this->assertEquals($expected, Target::seoTransSiteNameIndex());
    }

    /**
     * Test `seoTransTitleIndex` static method
     *
     * @return void
     * @group utility
     * @group done
     */
    public function testSeoTransTitleIndex(): void
    {
        $expected = 'default.title';

        $this->assertEquals($expected, Target::seoTransTitleIndex());
    }

    /**
     * Test `seoTransDescriptionIndex` static method
     *
     * @return void
     * @group utility
     * @group done
     */
    public function testSeoTransDescriptionIndex(): void
    {
        $expected = 'default.description';

        $this->assertEquals($expected, Target::seoTransDescriptionIndex());
    }

    /**
     * Test `seoTransKeywordsIndex` static method
     *
     * @return void
     * @group utility
     * @group done
     */
    public function testSeoTransKeywordsIndex(): void
    {
        $expected = 'default.keywords';

        $this->assertEquals($expected, Target::seoTransKeywordsIndex());
    }
}
