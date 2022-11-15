<?php

require_once 'vendor/autoload.php';
require_once 'app/printout.php';
use App\Data;

// Please download necessary data file from: shorturl.at/jlJQY and add it locally to your project repository for further use
const DATA_FILE = 'register.csv';
$companyRegister = new Data(DATA_FILE);

echo "Atlasiet nepieciešamos Uzņēmumu reģistra datus:" . PHP_EOL;
do {
    echo "\n1. Apskatīt jaunākos uzņēmumus." . PHP_EOL; // only when this chosen, then offset sets to last 30 (446058)!!!
    echo "2. Apskatīt vecākos uzņēmumus." . PHP_EOL;
    echo "3. Meklēt uzņēmumu pēc nosaukuma." . PHP_EOL;
    echo "4. Meklēt uzņēmumu pēc reģistrācijas numura." . PHP_EOL;
    echo "5. Iziet no meklētāja." . PHP_EOL;
    do {
        $searchFor = intval(readline("Norādiet izvēli (1-5) >> "));
    } while ($searchFor < 1 || $searchFor > 5);

    switch ($searchFor) {
        case 1:
            $amount = intval(readline("Norādiet skaitu, cik uzņēmumus vēlaties apskatīt >> "));
            $companies = $companyRegister->getLatestRecords($amount);
            printOut($companies);
            break;
        case 2:
            $amount = intval(readline("Norādiet skaitu, cik uzņēmumus vēlaties apskatīt >> "));
            $companies = $companyRegister->getOldestRecords($amount);
            printOut($companies);
            break;
        case 3:
            $companyName = readline("Norādiet uzņēmuma nosaukumu >> ");
            $companies = $companyRegister->searchByName($companyName);
            printOut($companies);
            break;
        case 4:
            $registrationCode = readline("Norādiet uzņēmuma reģistrācijas numuru >> ");
            $companies = $companyRegister->searchByRegistrationCode($registrationCode);
            printOut($companies);
            break;
    }
} while ($searchFor !== 5);


