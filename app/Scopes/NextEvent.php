<?php
namespace App\Scopes;
use Statamic\Query\Scopes\Scope;

class NextEvent extends Scope
{
  /**
   * Apply the scope.
   *
   * @param \Statamic\Query\Builder $query
   * @param array $values
   * @return void
   */
  public function apply($query, $values)
  {
    $query->where('event_date', '>=', now())->orderBy('event_date', 'asc')->limit(1);
  }
}
