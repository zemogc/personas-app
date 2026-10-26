<?php

namespace Tests\Feature\Geografia;

use App\Models\Comuna;
use App\Models\Municipio;

class ComunaTest extends CrudConPadreTestCase
{
    protected string $model = Comuna::class;

    protected string $parentModel = Municipio::class;

    protected string $route = 'comunas';

    protected string $nameColumn = 'comu_nomb';

    protected string $foreignKey = 'muni_codi';

    protected function parentRelation(): string
    {
        return 'municipio';
    }

    protected function parentNameColumn(): string
    {
        return 'muni_nomb';
    }
}
