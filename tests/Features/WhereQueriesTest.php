<?php

declare(strict_types=1);

namespace Tests\Features;

use App\User;
use Tests\TestCase;

final class WhereQueriesTest extends TestCase
{
    public function testExplicitOperator(): void
    {
        $this->mockIndex(User::class)->shouldReceive('search')->with('foo', [
            'numericFilters' => [
                'views_count != 100',
            ],
        ])->andReturn(['hits' => []]);

        User::search('foo')->where('views_count', '!=', '100')->get();
    }

    public function testInlineOperators(): void
    {
        $this->mockIndex(User::class)->shouldReceive('search')->with('foo', [
            'numericFilters' => [
                'views_count > 100',
            ],
        ])->andReturn(['hits' => []]);

        User::search('foo')->where('views_count', '> 100')->get();
    }

    public function testOmittedOperator(): void
    {
        $this->mockIndex(User::class)->shouldReceive('search')->with('foo', [
            'numericFilters' => [
                'views_count=100',
            ],
        ])->andReturn(['hits' => []]);

        User::search('foo')->where('views_count', '100')->get();
    }
}
