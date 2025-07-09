<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    public int $perPage = 10;

    public array $templates = [
        'default' => 'App\Views\Pager\bootstrap', // use \ not /
        'bootstrap' => 'App\Views\Pager\bootstrap',
    ];
}
