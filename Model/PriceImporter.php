<?php

declare(strict_types=1);

namespace Model;

use Exception;

class PriceImporter
{
    /** @var string */
    private $filename;

    /**
     * PriceImporter constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get pricing data from CSV
     *
     * @return array
     * @throws Exception
     */
    public function getPriceData(): array
    {
        // load CSV file
        $file = file_get_contents($this->filename);
        $rows = explode("\n", $file);
        if (count($rows) < 2) {
            throw new Exception('Insufficient pricing data');
        }

        // get header row info and remove from data
        $headings = explode(',', $rows[0]);
        if (!empty(array_diff($headings, ['code', 'qty', 'price']))) {
            throw new Exception('Invalid columns');
        }
        unset($rows[0]);

        // put csv data into array
        $data = [];
        foreach ($rows AS $row) {
            $rowData = array_combine($headings, explode(',', $row));
            $data[$rowData['code']][$rowData['qty']] = $rowData['price'];
        }
        return $data;
    }
}
