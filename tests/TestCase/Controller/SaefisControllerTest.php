<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SaefisController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SaefisController Test Case
 */
class SaefisControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.saefis',
        'app.users',
        'app.aros',
        'app.acos',
        'app.permissions',
        'app.designations',
        'app.pqmps',
        'app.counties',
        'app.sadr_followups',
        'app.sadrs',
        'app.attachments',
        'app.sadr_list_of_drugs',
        'app.doses',
        'app.routes',
        'app.frequencies',
        'app.sadr_other_drugs',
        'app.feedbacks',
        'app.messages',
        'app.sub_counties',
        'app.countries',
        'app.groups',
        'app.adrs',
        'app.adr_lab_tests',
        'app.adr_list_of_drugs',
        'app.adr_other_drugs',
        'app.aefis',
        'app.provinces',
        'app.aefi_list_of_vaccines',
        'app.aefi_list_of_diluents',
        'app.saefi_list_of_vaccines'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
