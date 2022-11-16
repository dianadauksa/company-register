<?php

namespace App;
use League\Csv\{Reader, Statement};

class Data {
    private string $fileName;
    private int $recordAmount;
    private object $reader;

    public function __construct(string $fileName) {

        $this->fileName = $fileName;
        $file = new \SplFileObject($this->fileName, 'r');
        $file->seek(999999); // seek to specified line; if even bigger files, could use PHP_INT_MAX (PHP constant for largest integer supported by current build of PHP)
        $this->recordAmount = $file->key() - 1;
        /*Sometimes some fields can have line breaks so another way for counting lines can be to look for a pattern, which you know is in EVERY line/each record.
        In company register though could not really find a pattern which is in EVERY line, not SIA, not LV, maybe by quotes but could be buggy*/

        $this->reader = Reader::createFromPath($this->fileName);
        $this->reader->setDelimiter(";");
        $this->reader->setHeaderOffset(0);
    }

    public function getFileName(): string {
        return $this->fileName;
    }

    public function setFileName(string $newFileName): void {
        $this->fileName = $newFileName;
    }

    public function getLatestRecords(int $amount): ?\Generator {
        $records = Statement::create()
            ->offset($this->recordAmount - $amount)
            ->process($this->reader);
        foreach ($records as $record) {
            yield new Company($record["name"], $record["regcode"]);
        }
    }

    public function getOldestRecords(int $amount): ?\Generator {
        $records = Statement::create()
            ->offset(0)
            ->limit($amount)
            ->process($this->reader);
        foreach ($records as $record) {
            yield new Company($record["name"], $record["regcode"]);
        }
    }

    public function searchByName(string $companyName): ?\Generator {
        $records = Statement::create()
            ->where(fn(array $record) => stripos($record["name"], $companyName) !== false) // WHERE clause is used to filter records, to extract only those records that fulfill a specified condition.
            ->process($this->reader);
        foreach ($records as $record) {
            yield new Company($record["name"], $record["regcode"]);
        }
    }

    public function searchByRegistrationCode(int $registrationCode): ?\Generator  {
        $records = Statement::create()
            ->where(fn(array $record) => str_contains($record["regcode"], strval($registrationCode)) !== false)
            ->process($this->reader);
        foreach ($records as $record) {
            yield new Company($record["name"], $record["regcode"]);
        }
    }
}
