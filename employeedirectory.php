<?php
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {

    private array $employees;
    private int $size;

    public function __construct(int $size) {
        $this->employees = [];
        $this->size = $size;
    }

    public function add(Employee $employee) {
        if (count($this->employees) < $this->size) {
            $this->employees[] = $employee;
        } else {
            echo "Roster is full. Cannot add more employees.\n";
        }
    }

    public function remove(int $index) {
        if (isset($this->employees[$index])) {
            unset($this->employees[$index]);
            $this->employees = array_values($this->employees); // Reindex array
        } else {
            echo "Employee not found at this index.\n";
        }
    }

    public function display() {
        foreach ($this->employees as $employee) {
            echo $employee . "\n";  // Uses __toString() in each Employee subclass
        }
    }

    public function displayCE() {
        foreach ($this->employees as $employee) {
            if ($employee instanceof CommissionEmployee) {
                echo $employee . "\n";
            }
        }
    }

    public function displayHE() {
        foreach ($this->employees as $employee) {
            if ($employee instanceof HourlyEmployee) {
                echo $employee . "\n";
            }
        }
    }

    public function displayPE() {
        foreach ($this->employees as $employee) {
            if ($employee instanceof PieceWorker) {
                echo $employee . "\n";
            }
        }
    }

    public function count() {
        return count($this->employees);
    }

    public function countCE() {
        return count(array_filter($this->employees, fn($employee) => $employee instanceof CommissionEmployee));
    }

    public function countHE() {
        return count(array_filter($this->employees, fn($employee) => $employee instanceof HourlyEmployee));
    }

    public function countPE() {
        return count(array_filter($this->employees, fn($employee) => $employee instanceof PieceWorker));
    }

    public function payroll() {
        foreach ($this->employees as $employee) {
            echo $employee->getName() . "'s payroll: " . $employee->earnings() . "\n";
        }
    }
}

?>
