<?php

namespace Tests\Feature\Geografia;

use App\Models\Comuna;
use App\Models\Departamento;
use App\Models\Municipio;

class MunicipioTest extends CrudConPadreTestCase
{
    protected string $model = Municipio::class;

    protected string $parentModel = Departamento::class;

    protected ?string $childModel = Comuna::class;

    protected string $route = 'municipios';

    protected string $nameColumn = 'muni_nomb';

    protected string $foreignKey = 'depa_codi';

    protected function parentRelation(): string
    {
        return 'departamento';
    }

    protected function parentNameColumn(): string
    {
        return 'depa_nomb';
    }
}
