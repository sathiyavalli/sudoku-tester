<?php
/*
*  This is the Sudoku program which reads a 9x9 sudoku board from a txt file and checks if it is a valid or not.
*  Created input file by feeding the "example-solved" values as text values inside "input.txt".
*  Below are the conditions for a valid sudoku:
*    Validating values in each 9 rows
*    Validating values in each 9 column
*    Validation values in 3x3 boxes
*  Getting data from a file in string format, then converts it to a 2D array of size 9x9.
*  After converting from array it validates each row to verify no duplicate values.
*  Then checking each columns to verify no duplicate numbers and after that it checks each 3x3 boxes.
*  If sudoku is valid it retuns 1 else it returns 0
*/


class Sudoku 
 {
    
    // To get file input
    private $sudoku_string;

    // To keep sudoku in array after converting from file input
    private $sudoku_array;

    // Constructor to process input from file
    function __construct($sudoku_string)
    {
       $this->sudoku_string = preg_replace("/[\r\n]+/", " ", $sudoku_string);
    }

   /**
    * arrayConvertRowsValidate
    *
    * Converts file input from string format to 2D array
    * and checks if rows in array are valid
    *
   */
    private function arrayConvertRowsValidate()
    {

       // convert string to an array
       $this->sudoku_array = explode(' ', $this->sudoku_string);

       if(count($this->sudoku_array) != 9){
            return false;
        }

       // convert each string array to digits array
       foreach($this->sudoku_array as &$row){
           $row = str_split($row);
           // Validate row and values in the row
           if(count($row) != 9 || count(array_unique($row)) !=9){
                return false;
            }
        }

        return true;
    }

    /**
     * columnValidation
     *
     * Validates all columns in given sudoku board
     *
     */
    private function columnValidation()
    {

        for($i=0;$i<9;$i++){
            $col = array_column($this->sudoku_array, $i);
            // Validate column and values in the column
            if(count($col) !=9 || count(array_unique($col)) !=9){
                return false;
            }
        }
        return true;
    }

    /**
     * regionsVerification
     *
     * Validates all 3x3 regions in given sudoku board
     *
     */
    private function regionsVerification()
    {

        for ($row = 0; $row < 9; $row += 3) {
            for ($col = 0; $col < 9; $col += 3) {
                // validate each 3x3 region
                if (!$this->regionValidation($row, $col)) {
                   return false;
                }
            }
        }
        return true;
    }

    /**
     * regionValidation
     *
     * Validates a 3x3 region
     *
     */
    private function regionValidation($startRow, $startCol)
    {

        $temp = array();
        for ($row = $startRow; $row < $startRow+3; $row++) {
            for ($col = $startCol; $col < $startCol+3; $col++) {
                $temp[] = $this->sudoku_array[$row][$col];
            }
        }

        // check if all digits in a 3x3 regions are unique
        if(count(array_unique($temp)) !=9){
           return false;
        }

        return true;
    }

    /**
     * 
     * Validating sudoku in all conditions
     *
     */
    public function validate()
    {

        if(!$this->arrayConvertRowsValidate()){
            return 0;
        }

        if(!$this->columnValidation()){
            return 0;
        }

        if(!$this->regionsVerification()){
            return 0;
        }

        return 1;
    }
}

// Getting values from file
$puzzle = file_get_contents('input.txt');

// Create sudoku
$result = new Sudoku($puzzle);

// Validating sudoku is valid or not
print $result->validate();
