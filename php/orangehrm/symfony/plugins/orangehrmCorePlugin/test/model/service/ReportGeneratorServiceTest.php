<?php

/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
class ReportGeneratorServiceTest extends PHPUnit_Framework_TestCase {

    private $reportGeneratorService;

    protected function setUp() {

        $this->reportGeneratorService = new ReportGeneratorService();
        TestDataService::truncateTables(array('MetaDisplayField', 'SelectedCompositeDisplayField', 'CompositeDisplayField', 'SelectedGroupField', 'SummaryDisplayField', 'SelectedDisplayField', 'DisplayField', 'SelectedFilterField', 'FilterField', 'GroupField', 'Report', 'ReportGroup', 'ProjectActivity', 'Project', 'Customer'));
        TestDataService::populate(sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ReportGeneratorService.yml');
        $this->fixture = sfConfig::get('sf_plugins_dir') . '/orangehrmCorePlugin/test/fixtures/ReportGeneratorService.yml';
    }

    /* Test getReportName */

    public function testGetReportName() {

        $reportId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport'));
        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $result = $this->reportGeneratorService->getReportName($reportId);

        $this->assertEquals("Project Report", $result);
    }

    public function testGetRuntimeFilterFieldWidgetNamesAndLabels() {

        $reportId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);

        $selectedFilterFields = new Doctrine_Collection("SelectedFilterField");
        $runtimeFilterFields = new Doctrine_Collection("FilterField");

        $selectedFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 1)));
        $selectedFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 2)));

        $runtimeFilterFields->add(TestDataService::fetchObject('FilterField', 1));
        $runtimeFilterFields->add(TestDataService::fetchObject('FilterField', 2));

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport', 'getSelectedFilterFields', 'getRuntimeFilterFields'));

        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $reportableServiceMock->expects($this->once())
                ->method('getSelectedFilterFields')
                ->with($reportId)
                ->will($this->returnValue($selectedFilterFields));

        $reportableServiceMock->expects($this->once())
                ->method('getRuntimeFilterFields')
                ->will($this->returnValue($runtimeFilterFields));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $runtimeFilterFieldWidgetNamesAndLabels = $this->reportGeneratorService->getRuntimeFilterFieldWidgetNamesAndLabels($reportId);

        $this->assertEquals(2, count($runtimeFilterFieldWidgetNamesAndLabels));
        $this->assertEquals('ohrmWidgetInputCheckbox', $runtimeFilterFieldWidgetNamesAndLabels[1]['widgetName']);
        $this->assertEquals('activity_show_deleted', $runtimeFilterFieldWidgetNamesAndLabels[1]['labelName']);
    }

    /* Test getSelectedFilterFieldIdsByReportId method */

    public function testGetSelectedFilterFieldIdsByReportId() {

        $reportId = 1;

        $selecteFilterFields = new Doctrine_Collection("SelectedFilterField");

        $selecteFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 1)));
        $selecteFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 2)));

        $reportableServiceMock = $this->getMock('ReportableService', array('getSelectedFilterFields'));
        $reportableServiceMock->expects($this->once())
                ->method('getSelectedFilterFields')
                ->with($reportId)
                ->will($this->returnValue($selecteFilterFields));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $result = $this->reportGeneratorService->getSelectedFilterFieldIdsByReportId($reportId);

        $this->assertEquals(2, count($result));
        $this->assertEquals(1, $result[0]);
        $this->assertEquals(2, $result[1]);
    }

    /* Test getReportGroupIdOfAReport method */

    public function testGetReportGroupIdOfAReport() {

        $reportId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport'));

        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $reportGroupId = $this->reportGeneratorService->getReportGroupIdOfAReport($reportId);

        $this->assertEquals(1, $reportGroupId);
    }

    /* Test getSelectedRuntimeFilterFields method */

    public function testGetSelectedRuntimeFilterFields() {

        $reportId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);

        $selectedFilterFields = new Doctrine_Collection("SelectedFilterField");
        $runtimeFilterFields = new Doctrine_Collection("FilterField");

        $selectedFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 1)));
        $selectedFilterFields->add(TestDataService::fetchObject('SelectedFilterField', array(1, 2)));

        $runtimeFilterFields->add(TestDataService::fetchObject('FilterField', 1));
        $runtimeFilterFields->add(TestDataService::fetchObject('FilterField', 2));

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport', 'getSelectedFilterFields', 'getRuntimeFilterFields'));

        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $reportableServiceMock->expects($this->once())
                ->method('getSelectedFilterFields')
                ->with($reportId)
                ->will($this->returnValue($selectedFilterFields));

        $reportableServiceMock->expects($this->once())
                ->method('getRuntimeFilterFields')
                ->will($this->returnValue($runtimeFilterFields));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $selectedRuntimeFilterFieldList = $this->reportGeneratorService->getSelectedRuntimeFilterFields($reportId);

        $this->assertEquals(2, count($selectedRuntimeFilterFieldList));
        $this->assertEquals(1, $selectedRuntimeFilterFieldList[0]->getFilterFieldId());
        $this->assertEquals(2, $selectedRuntimeFilterFieldList[1]->getFilterFieldId());
    }

    /* Test generateRuntimeWhereClauseConditions method */

    public function testGenerateRuntimeWhereClauseConditions() {

        $selectedRuntimeFilterFields = TestDataService::loadObjectList('FilterField', $this->fixture, 'FilterField');
        $values = array('project_name' => 2, 'project_date_range' => Array('from' => 2011 - 05 - 17, 'to' => 2011 - 05 - 24), 'activity_show_deleted' => '');

        $conditionArray = $this->reportGeneratorService->generateRuntimeWhereClauseConditions($selectedRuntimeFilterFields, $values);

        $this->assertEquals(2, count($conditionArray));
        $this->assertEquals("hs_hr_project.project_id = 2 AND hs_hr_project_activity.deleted = 0", $conditionArray[2]);
        $this->assertEquals("( date BETWEEN '1989' AND '1982' )", $conditionArray[1]);
    }

    /* Tests getSelectConditionWithoutSummaryFunction method */

    public function testGetSelectConditionWithoutSummaryFunction() {

        $reportId = 1;

        $selectedDisplayFields = new Doctrine_Collection("SelectedDisplayField");

        $selectedDisplayFields->add(TestDataService::fetchObject('SelectedDisplayField', array(1, 1, 1)));
        $selectedDisplayFields->add(TestDataService::fetchObject('SelectedDisplayField', array(2, 2, 1)));

        $reportableServiceMock = $this->getMock('ReportableService', array('getSelectedDisplayFields'));

        $reportableServiceMock->expects($this->once())
                ->method('getSelectedDisplayFields')
                ->with($reportId)
                ->will($this->returnValue($selectedDisplayFields));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $selectStatement = $this->reportGeneratorService->getSelectConditionWithoutSummaryFunction($reportId);

        $this->assertEquals('CONCAT(hs_hr_employee.emp_firstname, " " ,hs_hr_employee.emp_lastname) AS employeeName , hs_hr_project.name AS projectname,hs_hr_project_activity.name AS activityname , hs_hr_project_activity.project_id,hs_hr_project_activity.activity_id', $selectStatement);
    }

    /* Tests generateSql method */

    public function testGenerateSql() {

        $reportId = 1;
        $reportGroupId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);
        $reportGroup = TestDataService::fetchObject('ReportGroup', $reportGroupId);
        $selectedGroupField = TestDataService::fetchObject('SelectedGroupField', array(1, 1, 1));

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport', 'getReportGroup', 'getSelectedGroupField'));

        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $reportableServiceMock->expects($this->once())
                ->method('getReportGroup')
                ->will($this->returnValue($reportGroup));

        $reportableServiceMock->expects($this->once())
                ->method('getSelectedGroupField')
                ->with($reportId)
                ->will($this->returnValue($selectedGroupField));

        $selectConditionWithoutSummaryFunction = "hs_hr_project_activity.name AS activityname";

        $reportGeneratorServiceMock = $this->getMock('ReportGeneratorService', array('getSelectConditionWithoutSummaryFunction'));

        $reportGeneratorServiceMock->expects($this->once())
                ->method('getSelectConditionWithoutSummaryFunction')
                ->with($reportId)
                ->will($this->returnValue($selectConditionWithoutSummaryFunction));

        $conditionArray = array('2' => "hs_hr_project.project_id = 1 AND hs_hr_project_activity.deleted = 0");
        $reportGeneratorServiceMock->setReportableService($reportableServiceMock);
        $sql = $reportGeneratorServiceMock->generateSql($reportId, $conditionArray);

        $this->assertEquals("SELECT hs_hr_project_activity.name AS activityname,ROUND(COALESCE(sum(duration)/3600, 0),2) AS totalduration FROM hs_hr_project_activity LEFT JOIN (SELECT * FROM ohrm_timesheet_item WHERE true) AS ohrm_timesheet_item  ON (ohrm_timesheet_item.activity_id = hs_hr_project_activity.activity_id) LEFT JOIN hs_hr_project ON (hs_hr_project.project_id = hs_hr_project_activity.project_id) WHERE hs_hr_project.project_id = 1 AND hs_hr_project_activity.deleted = 0 GROUP BY hs_hr_project_activity.activity_id", $sql);
    }

    /* Test getProjectActivityNameByActivityId */

    public function testGetProjectActivityNameByActivityId() {

        $activityId = 1;
        $activity = TestDataService::fetchObject('ProjectActivity', $activityId);

        $reportableServiceMock = $this->getMock('ReportableService', array('getProjectActivityByActivityId'));
        $reportableServiceMock->expects($this->once())
                ->method('getProjectActivityByActivityId')
                ->with($activityId)
                ->will($this->returnValue($activity));

        $this->reportGeneratorService->setReportableService($reportableServiceMock);
        $result = $this->reportGeneratorService->getProjectActivityNameByActivityId($activityId);

        $this->assertEquals("Create Schema", $result);
    }

    public function testSimplexmlToArray() {

        $elementPropertyXmlString = "<xml><labelGetter>activityname</labelGetter><placeholderGetters><id>activity_id</id><total>totalduration</total><projectId>projectId</projectId><from>fromDate</from><to>toDate</to></placeholderGetters><urlPattern>../../displayProjectActivityDetailsReport?reportId=3&amp;activityId={id}&amp;total={total}&amp;from={from}&amp;to={to}&amp;projectId={projectId}</urlPattern></xml>";

        $xmlIterator = new SimpleXMLIterator($elementPropertyXmlString);

        $elementPropertyArray = $this->reportGeneratorService->simplexmlToArray($xmlIterator);

        $this->assertEquals(3, count($elementPropertyArray));
        $this->assertEquals("activityname", $elementPropertyArray['labelGetter']);
        $this->assertEquals("totalduration", $elementPropertyArray["placeholderGetters"]["total"]);
    }

    public function testGetHeaders() {

        $reportId = 1;

        $headers = $this->reportGeneratorService->getHeaders($reportId);

        $this->assertTrue(true);
    }

    /* Tests generateSql with meta display fields method */

    public function testGenerateSqlWithStaticColumns() {

        $reportId = 1;
        $reportGroupId = 1;
        $report = TestDataService::fetchObject('Report', $reportId);
        $reportGroup = TestDataService::fetchObject('ReportGroup', $reportGroupId);
        $selectedGroupField = TestDataService::fetchObject('SelectedGroupField', array(1, 1, 1));

        $reportableServiceMock = $this->getMock('ReportableService', array('getReport', 'getReportGroup', 'getSelectedGroupField'));

        $reportableServiceMock->expects($this->once())
                ->method('getReport')
                ->with($reportId)
                ->will($this->returnValue($report));

        $reportableServiceMock->expects($this->once())
                ->method('getReportGroup')
                ->will($this->returnValue($reportGroup));

        $reportableServiceMock->expects($this->once())
                ->method('getSelectedGroupField')
                ->with($reportId)
                ->will($this->returnValue($selectedGroupField));

        $selectConditionWithoutSummaryFunction = "hs_hr_project_activity.name AS activityname";

        $reportGeneratorServiceMock = $this->getMock('ReportGeneratorService', array('getSelectConditionWithoutSummaryFunction'));

        $reportGeneratorServiceMock->expects($this->once())
                ->method('getSelectConditionWithoutSummaryFunction')
                ->with($reportId)
                ->will($this->returnValue($selectConditionWithoutSummaryFunction));

        $staticColumns = null;
        $staticColumns["projectId"] = 1;
        $staticColumns["fromDate"] = "1970-01-01";
        $staticColumns["toDate"] = date("Y-m-d");

        $conditionArray = array('2' => "hs_hr_project.project_id = 1 AND hs_hr_project_activity.deleted = 0");
        $reportGeneratorServiceMock->setReportableService($reportableServiceMock);
        $sql = $reportGeneratorServiceMock->generateSql($reportId, $conditionArray, $staticColumns);

        $this->assertEquals("SELECT '1' AS projectId , '1970-01-01' AS fromDate , '2011-07-25' AS toDate , hs_hr_project_activity.name AS activityname,ROUND(COALESCE(sum(duration)/3600, 0),2) AS totalduration FROM hs_hr_project_activity LEFT JOIN (SELECT * FROM ohrm_timesheet_item WHERE true) AS ohrm_timesheet_item  ON (ohrm_timesheet_item.activity_id = hs_hr_project_activity.activity_id) LEFT JOIN hs_hr_project ON (hs_hr_project.project_id = hs_hr_project_activity.project_id) WHERE hs_hr_project.project_id = 1 AND hs_hr_project_activity.deleted = 0 GROUP BY hs_hr_project_activity.activity_id", $sql);
    }

    public function testLinkFilterFieldIdsToFormValues() {

        $formValues = array(
            'project_name' => 2,
            'activity_show_deleted' => 'on',
            'project_date_range' => array('from' => '2011-01-12', 'to' => '2011-09-23')
        );

        
        $selectedRuntimeFilterFieldList = new Doctrine_Collection("FilterField");

        $selectedRuntimeFilterFieldList->add(TestDataService::fetchObject('FilterField', 1));
        $selectedRuntimeFilterFieldList->add(TestDataService::fetchObject('FilterField', 2));

        $filterFieldIdAndValueArray = $this->reportGeneratorService->linkFilterFieldIdsToFormValues($selectedRuntimeFilterFieldList, $formValues);

        $this->assertEquals(2, count($filterFieldIdAndValueArray));
        $this->assertEquals(2, $filterFieldIdAndValueArray[1]['filterFieldId']);
        $this->assertEquals('on', $filterFieldIdAndValueArray[1]['value']);
    }

    public function testGenerateWhereClauseConditionArray() {

        $filterFieldIdsAndValues = array(
            '0' => array('filterFieldId' => 1, 'value' => 2),
            '1' => array('filterFieldId' => 2, 'value' => 'on'));

        $conditionArray = $this->reportGeneratorService->generateWhereClauseConditionArray($filterFieldIdsAndValues);

        $this->assertEquals(1, count($conditionArray));
        $this->assertEquals('hs_hr_project.project_id = 2', $conditionArray[2]);
        
    }

}
