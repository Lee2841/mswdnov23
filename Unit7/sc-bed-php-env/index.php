<?php
namespace unit7;
require 'lib/com/icemalta/libpayroll/payroll.php';

use com\icemalta\libpayroll\Employee as PayrollEmployee;

class Employee
{
    //Class constants
    public const CURRENCY = '€';

    public const TAX_RATE = 'Individual';

    private const YEAR_HOURS_STANDARD = 1920;

    private const TAX_BRACKETS = [
        ['from' => 0, 'to' => 9100, 'rate' => 0, 'subtract' => 0],
        ['from' => 9101, 'to' => 14500, 'rate' => 15, 'subtract' => 1365],
        ['from' => 14501, 'to' => 19500, 'rate' => 25, 'subtract' => 2815],
        ['from' => 19501, 'to' => 60000, 'rate' => 25, 'subtract' => 2725],
        ['from' => 60001, 'to' => null, 'rate' => 35, 'subtract' => 8725]
    ];

    // Static member

    private static array $employeeList = [];
    private string $name;
    private string $surname;
    private string $jobTitle;
    protected float $hourlyRate;
    private bool $paidOvertime = false;

    public function __construct(string $name, string $surname, string $jobTitle, float $hourlyRate = 0, bool $paidOvertime = false)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->jobTitle = $jobTitle;
        $this->hourlyRate = $hourlyRate;
        $this->paidOvertime = $paidOvertime;
        self::$employeeList[] = $this;
    }

    // Getters and Setters

    public static function getEmployees(): array
    {
        return self::$employeeList;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function getHourlyRate(): float
    {
        return $this->hourlyRate;
    }

    public function setHourlyRate(float $hourlyRate): void
    {
        if (is_numeric($hourlyRate) && $hourlyRate > 0) {
            $this->hourlyRate = $hourlyRate;
        }
    }

    public function getBasicDetailsString(): string
    {
        return "$this->name $this->surname, $this->jobTitle";
    }

    public function getGrossPay(float $hoursWorked): float
    {
        return $hoursWorked * $this->hourlyRate;
    }

    /**
     * @param float $hoursWorked the total hours worked by this employee this year
     * @return object an object containing calculated fields for income statement
     */
    public function getIncomeStatement(float $hoursWorked): object
    {
        $standardHours = $hoursWorked >= self::YEAR_HOURS_STANDARD ? self::YEAR_HOURS_STANDARD : $hoursWorked;
        $overtimeHours = $hoursWorked > self::YEAR_HOURS_STANDARD ? $hoursWorked - self::YEAR_HOURS_STANDARD : 0;

        $wageDetail = new \stdClass();
        $wageDetail->standardHours = $standardHours;
        $wageDetail->overtimeHours = $this->paidOvertime ? $overtimeHours : 0;
        $wageDetail->standardGross = $standardHours * $this->hourlyRate;
        $wageDetail->standardGross += $this instanceof TeamLead ? $this->bonusEntitlement : 0;
        $wageDetail->overtimeGross = $this->paidOvertime ? $overtimeHours * $this->hourlyRate * 1.5 : 0;
        $wageDetail->totalGross = $wageDetail->standardGross + $wageDetail->overtimeGross;
        $wageDetail->totalTax = $this->getTaxAmount($wageDetail->totalGross);
        $wageDetail->totalNet = $wageDetail->totalGross - $wageDetail->totalTax;

        return $wageDetail;
    }

    /**
     * @param float $grossWage amount to calculate tax for
     * @return float the total tax to be paid, or null if wage given is invalid (ex: negative wage)
     */
    private function getTaxAmount(float $grossWage): float|null
    {
        foreach (self::TAX_BRACKETS as $taxBracket) {
            if ($grossWage >= $taxBracket['from'] && ($taxBracket['to'] === null || $grossWage <= $taxBracket['to'])) {
                return ($grossWage - $taxBracket['subtract']) * $taxBracket['rate'] / 100;
            }
        }
        return null;
    }
}

// Create a sub-class of Employee called TeamLead

class TeamLead extends Employee
{

    public function __construct(string $name, string $surname, string $jobTitle, float $hourlyRate = 0, bool $paidOvertime = false, float $bonusEntitlement = 0)
    {
        parent::__construct($name, $surname, $jobTitle, $hourlyRate, $paidOvertime);
        $this->bonusEntitlement = $bonusEntitlement;
    }
    protected float $bonusEntitlement = 0;

    public function getBonusEntitlement(): float
    {
        return $this->bonusEntitlement;
    }

    public function setBonusEntitlement(float $bonusEntitlement): void
    {
        $this->bonusEntitlement = $bonusEntitlement;
    }

    public function getGrossPay(float $hoursWorked): float
    {
        return ($hoursWorked * $this->hourlyRate) + $this->bonusEntitlement;
    }

}

// Creating an object (instance)
$emp1 = new Employee('Alice', 'Anderson', 'CTO');
$emp2 = new Employee('Bob', 'Parker', 'CMO');
$emp3 = new Employee('Claire', 'Curmi', 'Junior Programmer', 15);
$emp4 = new TeamLead('Dave', 'Dimech', 'Lead Programmer', 30, true, 4000);
?>

<!doctype html>
<html lang="en">

<head>
    <title>OOP in PHP</title>
</head>

<body>
    <h1>OOP</h1>
    <p>
        <?= $emp1->getBasicDetailsString() ?>
    </p>
    <p>
        <?= $emp2->getBasicDetailsString() ?>
    </p>
    <p>
        Name:
        <?= $emp3->getBasicDetailsString() ?><br>
        Wage:
        <?= $emp3->getGrossPay(160) ?>
    </p>
    <?php
    printf('<h3>Income Statement for %s %s (%s)</h3>', $emp4->getName(), $emp4->getSurname(), $emp4->getJobTitle());
    $payslip = $emp4->getIncomeStatement(2000);
    $c = Employee::CURRENCY;
    echo <<<DETAILS
        <table border='1'>                 
            <thead><tr><th>Item</th><th>Value</th></tr></thead>                 
            <tbody>                     
                <tr><td>Hours Worked</td><td>$payslip->standardHours</td></tr>                     
                <tr><td>Overtime Worked</td><td>$payslip->overtimeHours</td></tr>                     
                <tr><td>Standard Gross</td><td>$c$payslip->standardGross</td></tr>                     
                <tr><td>Overtime Gross</td><td>$c$payslip->overtimeGross</td></tr>                     
                <tr><td>Gross Wage</td><td>$c$payslip->totalGross</td></tr>                     
                <tr><td>Tax Due</td><td>$c$payslip->totalTax</td></tr>                     
                <tr><td>Net Wage</td><td>$c$payslip->totalNet</td></tr>                 
            </tbody>             
        </table>         
    DETAILS;
    ?>

    <p>
        Name:
        <?= $emp4->getBasicDetailsString() ?><br>
        Wage:
        <?= $emp4->getGrossPay(1920) ?>
    </p>
    <h3>List of Employees</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Job Title</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach (Employee::getEmployees() as $employee) {
                printf(
                    '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
                    $employee->getName(),
                    $employee->getSurname(),
                    $employee->getJobTitle(),
                    $employee instanceof TeamLead ? 'Team Lead' : 'Employee'
                );
            }
            ?>
        </tbody>
    </table>
    <h3>Using the Payroll Library</h3>
    <?php
        $joe = new PayrollEmployee();
        echo "<p>{$joe->getPaySlip()}</p>";
            ?>
    </body>

</html>