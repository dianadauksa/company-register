<?php

function showCompanies(\Generator $companies): void {
    foreach ($companies as $company) {
        echo $company;
    }
}