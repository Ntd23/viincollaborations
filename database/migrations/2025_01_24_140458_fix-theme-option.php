<?php

use Botble\Theme\Facades\ThemeOption;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        ThemeOption::setOption('logo', ThemeOption::getOption('logo_white'));
        ThemeOption::saveOptions();
    }
};
