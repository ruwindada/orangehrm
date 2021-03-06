<?php

/**
 * BaseEmployeeImmigrationRecord
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property int                        $empNumber                  Type: integer(4), primary key
 * @property float                      $recordId                   Type: decimal(2), primary key
 * @property string                     $number                     Type: string(100)
 * @property string                     $status                     Type: string(100)
 * @property string                     $issuedDate                 Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @property string                     $expiryDate                 Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @property string                     $notes                      Type: string(255)
 * @property int                        $type                       Type: integer(2)
 * @property string                     $reviewDate                 Type: date(25), Date in ISO-8601 format (YYYY-MM-DD)
 * @property string                     $countryCode                Type: string(6)
 * @property Employee                   $Employee                   
 *  
 * @method int                          getEmpnumber()              Type: integer(4), primary key
 * @method float                        getRecordid()               Type: decimal(2), primary key
 * @method string                       getNumber()                 Type: string(100)
 * @method string                       getStatus()                 Type: string(100)
 * @method string                       getIssueddate()             Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @method string                       getExpirydate()             Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @method string                       getNotes()                  Type: string(255)
 * @method int                          getType()                   Type: integer(2)
 * @method string                       getReviewdate()             Type: date(25), Date in ISO-8601 format (YYYY-MM-DD)
 * @method string                       getCountrycode()            Type: string(6)
 * @method Employee                     getEmployee()               
 *  
 * @method EmployeeImmigrationRecord    setEmpnumber(int $val)      Type: integer(4), primary key
 * @method EmployeeImmigrationRecord    setRecordid(float $val)     Type: decimal(2), primary key
 * @method EmployeeImmigrationRecord    setNumber(string $val)      Type: string(100)
 * @method EmployeeImmigrationRecord    setStatus(string $val)      Type: string(100)
 * @method EmployeeImmigrationRecord    setIssueddate(string $val)  Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @method EmployeeImmigrationRecord    setExpirydate(string $val)  Type: timestamp, Timestamp in ISO-8601 format (YYYY-MM-DD HH:MI:SS)
 * @method EmployeeImmigrationRecord    setNotes(string $val)       Type: string(255)
 * @method EmployeeImmigrationRecord    setType(int $val)           Type: integer(2)
 * @method EmployeeImmigrationRecord    setReviewdate(string $val)  Type: date(25), Date in ISO-8601 format (YYYY-MM-DD)
 * @method EmployeeImmigrationRecord    setCountrycode(string $val) Type: string(6)
 * @method EmployeeImmigrationRecord    setEmployee(Employee $val)  
 *  
 * @package    orangehrm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEmployeeImmigrationRecord extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('hs_hr_emp_passport');
        $this->hasColumn('emp_number as empNumber', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('ep_seqno as recordId', 'decimal', 2, array(
             'type' => 'decimal',
             'primary' => true,
             'length' => 2,
             ));
        $this->hasColumn('ep_passport_num as number', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('ep_i9_status as status', 'string', 100, array(
             'type' => 'string',
             'default' => '',
             'length' => 100,
             ));
        $this->hasColumn('ep_passportissueddate as issuedDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_passportexpiredate as expiryDate', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('ep_comments as notes', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ep_passport_type_flg as type', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('ep_i9_review_date as reviewDate', 'date', 25, array(
             'type' => 'date',
             'length' => 25,
             ));
        $this->hasColumn('cou_code as countryCode', 'string', 6, array(
             'type' => 'string',
             'length' => 6,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Employee', array(
             'local' => 'empNumber',
             'foreign' => 'empNumber'));
    }
}