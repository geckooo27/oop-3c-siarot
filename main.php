<?php

class Main {

    private EmployeeRoster $roster;
    private $size;
    private $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;
    
        // Prompt for the size of the roster
        $this->size = readline("Enter the size of the roster: ");
    
        // Validate the roster size
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
            return; // Ensure the function exits after a restart
        }
    
        // Initialize the roster with the provided size
        $this->roster = new EmployeeRoster($this->size);
    
        // Proceed to the main entrance method
        $this->entrance();
    }
    

    public function entrance() {
        while ($this->repeat) {
            $this->clear();
    
            // Calculate available space on the roster
            $availableSpace = $this->size - $this->roster->count();
            echo "Available space on the roster: $availableSpace\n";
    
            // Display the main menu
            $this->menu();
    
            // Get user choice and handle input
            $choice = readline("Pick from the menu: ");
    
            // Ensure the user input is a valid choice
            if (!in_array($choice, [0, 1, 2, 3])) {
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                continue; // Skip to the next iteration of the loop
            }
    
            switch ($choice) {
                case 1:
                    // Call the method to add an employee
                    $this->addMenu();
                    break;
    
                case 2:
                    // Call the method to delete an employee
                    $this->deleteMenu();
                    break;
    
                case 3:
                    // Call the method for other menu options
                    $this->otherMenu();
                    break;
    
                case 0:
                    // Exit the program
                    echo "Exiting program...\n";
                    $this->repeat = false; // Terminate the loop
                    break;
    
                default:
                    // This shouldn't happen if input is validated correctly
                    echo "Invalid option. Please try again.\n";
                    break;
            }
        }
    
        // Process termination message
        echo "Process terminated.\n";
    }
    
    

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        echo "--- Add Employee ---\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = readline("Enter age: ");
        $cName = readline("Enter company name: ");
        $this->empType($name, $address, $age, $cName);
    }

    public function empType($name, $address, $age, $cName) {
        $this->clear();
        echo "[1] Commission Employee       [2] Hourly Employee       [3] Piece Worker\n";
        $type = readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $cName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $cName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $cName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $cName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $cName) {
        $regularSalary = readline("Enter regular salary: ");
        $itemSold = readline("Enter number of items sold: ");
        $commissionRate = readline("Enter commission rate: ");
        $employee = new CommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsHE($name, $address, $age, $cName) {
        $hoursWorked = readline("Enter hours worked: ");
        $rate = readline("Enter hourly rate: ");
        $employee = new HourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $cName) {
        $numberItems = readline("Enter number of items produced: ");
        $wagePerItem = readline("Enter wage per item: ");
        $employee = new PieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "*** List of Employees on the current Roster ***\n";
        $this->roster->display();
        $index = readline("Enter the employee index to delete or [0] to return: ");
        
        if ($index == 0) return;
        
        $this->roster->remove($index - 1);
        echo "Employee removed!\n";
        readline("Press \"Enter\" key to continue...");
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                readline("Press \"Enter\" key to continue...");
                break;
            case 0:
                return;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employee\n";
        echo "[2] Display Commission Employee\n";
        echo "[3] Display Hourly Employee\n";
        echo "[4] Display Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 0:
                return;
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            default:
                echo "Invalid Input!";
                break;
        }
        readline("\nPress \"Enter\" key to continue...");
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employee\n";
        echo "[2] Count Commission Employee\n";
        echo "[3] Count Hourly Employee\n";
        echo "[4] Count Piece Worker\n";
        echo "[0] Return\n";
        $choice = readline("Select Menu: ");

        switch ($choice) {
            case 0:
                return;
            case 1:
                echo "Total Employees: " . $this->roster->count() . PHP_EOL;
                break;
            case 2:
                echo "Total Commission Employees: " . $this->roster->countCE() . PHP_EOL;
                break;
            case 3:
                echo "Total Hourly Employees: " . $this->roster->countHE() . PHP_EOL;
                break;
            case 4:
                echo "Total Piece Workers: " . $this->roster->countPE() . PHP_EOL;
                break;
            default:
                echo "Invalid Input!";
                break;
        }
        readline("\nPress \"Enter\" key to continue...");
    }

    public function clear() {
        if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            // For Windows
            system('cls');
        } else {
            // For Unix-based systems (Linux, macOS)
            system('clear');
        }
    }
    

    public function repeat() {
        echo "Employee Added!\n";
        
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y') {
                $this->entrance(); // Go back to the main menu instead of directly to addMenu()
            } else {
                $this->entrance();
            }
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
    
}
