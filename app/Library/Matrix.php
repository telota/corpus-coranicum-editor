<?php
/**
 * Created by PhpStorm.
 * User: suchmaske
 * Date: 12.02.16
 * Time: 14:42
 */

namespace App\Library;


class Matrix
{

    public $arr, $rows, $cols;

    /**
     *
     * Generate a Matrix
     *
     * @param $row Number of Rows
     * @param $col Number of Columns
     */
    function __construct($row, $col)
    {

        // Make sure there is at least one row and column
        if ($row > 0 && $col > 0)
        {
            // Set internal values
            $this->arr = array();
            $this->rows = $row;
            $this->cols = $col;
        }

        // Populate matrix with zeros
        /*
        for ($i = 0; $i < $this->rows; $i++)
        {
            array_push($this->arr, array());

            for ($j = 0; $j < $this->cols; $j++)
            {
                array_push($this->arr[$i], 0);
            }

        }
        */

    }

    /**
     * Set an element of the matrix
     *
     * @param $row
     * @param $col
     * @param $value
     */
    function set($row, $col, $value)
    {

        // Make sure to select a valid row
        if ($row > -1 && $row < $this->rows)
        {

            if (!(array_key_exists($row, $this->arr)))
            {
                $this->arr[$row] = array();
            }

            // Make sure to select a valid column
            if ($col > -1 && $col < $this->cols)
            {

                // Set the element
                $this->arr[$row][$col] = $value;

            }

            return $value;

        }

    }

    /**
     * Get an element of the matrix
     *
     * @param $row
     * @param $column
     */
    function get($row, $col)
    {

        // Make sure to select a valid row
        if ($row > -1 && $row < $this->rows)
        {

            // Make sure to select a valid column
            if ($col > -1 && $col < $this->cols)
            {

                // If row doesn't exist, value is an implicit zero
                if (!(array_key_exists($row, $this->arr)))
                {
                    return 0;
                }

                // If value in column doesn't exist, value is an implicit zero
                if (!(array_key_exists($col, $this->arr[$row])))
                {
                    return 0;
                }


                // Return the element
                return $this->arr[$row][$col];

            }

        }

    }

    /**
     * Add two matrices
     *
     * @param $matrix
     */
    function add(Matrix $matrix)
    {

        // Make sure both matrices have the same dimensions
        if ($this->rows == $matrix->rows && $this->cols == $matrix->cols)
        {
            // Create new matrix to store the results in
            $result = new Matrix($this->rows, $this->col);

            for ($row = 0; $row < $this->rows; $row++)
            {
                for ($col = 0; $col < $this->cols; $col++)
                {
                    $sum = $this->get($row, $col) + $matrix->get($row, $col);
                    $result->set($row, $col, $sum);
                }
            }

            return $result;
        }

    }

    /**
     * Add two matrices
     *
     * @param $matrix
     */
    function subtract(Matrix $matrix)
    {

        // Make sure both matrices have the same dimensions
        if ($this->rows == $matrix->rows && $this->cols == $matrix->cols)
        {
            // Create new matrix to store the results in
            $result = new Matrix($this->rows, $this->col);

            for ($row = 0; $row < $this->rows; $row++)
            {
                for ($col = 0; $col < $this->cols; $col++)
                {
                    $difference = $this->get($row, $col) - $matrix->get($row, $col);
                    $result->set($row, $col, $difference);
                }
            }

            return $result;
        }

    }

    /**
     * Compute the cross product of two matrices
     *
     * @param Matrix $matrix
     */
    function dotProduct(Matrix $matrix)
    {

        $result = 0;
        $donePairs = array();

        if (sizeof($this->arr) == 0 || sizeof($matrix->arr) == 0) {
            return 0;
        }

        foreach($this->arr as $rowIndex => $columns)
        {

            foreach ($columns as $colIndex => $col)
            {

                if (!(array_key_exists($rowIndex, $donePairs))) {
                    $donePairs[$rowIndex] = array();
                }

                if (!(in_array($colIndex, $donePairs[$rowIndex])))
                {
                    $result += $this->get($rowIndex, $colIndex) * $matrix->get($rowIndex, $colIndex);
                    array_push($donePairs[$rowIndex], $colIndex);
                }

            }

        }

        foreach($matrix->arr as $rowIndex => $columns)
        {

            foreach ($columns as $colIndex => $col)
            {

                if (!(array_key_exists($rowIndex, $donePairs))) {
                    $donePairs[$rowIndex] = array();
                }

                if (!(in_array($colIndex, $donePairs[$rowIndex])))
                {
                    $result += $this->get($rowIndex, $colIndex) * $matrix->get($rowIndex, $colIndex);
                    array_push($donePairs[$rowIndex], $colIndex);
                }

            }

        }


        return $result;

    }

    function computeDenominator(Matrix $matrix)
    {

        $resultFirst = 0;
        $resultSecond = 0;

        $donePairs = array();

        foreach($this->arr as $rowIndex => $columns)
        {

            foreach ($columns as $colIndex => $col)
            {

                    $resultFirst += pow($this->get($rowIndex, $colIndex), 2);

            }

        }


        foreach($matrix->arr as $rowIndex => $columns)
        {

            foreach ($columns as $colIndex => $col)
            {

                    $resultSecond += pow($matrix->get($rowIndex, $colIndex), 2);

            }

        }

        return sqrt($resultFirst) * sqrt($resultSecond);

    }

    function euclidianSim(Matrix $matrix)
    {

        $numerator = $this->dotProduct($matrix);
        $denominator = $this->computeDenominator($matrix);

        if ($denominator == 0)
        {
            return null;
        }

        return $numerator / $denominator;

    }

    function columnIsEmpty($row)
    {

        for ($col = 0; $col <= $this->cols; $col++)
        {
            $value = $this->get($row, $col);

            if ($value)
            {
                return false;
            }

        }

        return true;


    }

}