<?php

namespace Tests\Feature\Geografia;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;

class DepartamentoTest extends CrudConPadreTestCase
{
    protected string $model = Departamento::class;

    protected string $parentModel = Pais::class;

    protected ?string $childModel = Municipio::class;

    protected string $route = 'departamentos';

    protected string $nameColumn = 'depa_nomb';

    protected string $foreignKey = 'pais_codi';

    protected function parentRelation(): string
    {
        return 'pais';
    }

    protected function parentNameColumn(): string
    {
        return 'pais_nomb';
    }
}
