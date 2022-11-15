<?php

function printOut(\Generator $companies): void {
    foreach ($companies as $company) {
        echo $company;
    }
}