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
    (new UpcomingEvents)->apply($query, $values);
    $query->orderBy('event_date', 'asc')->limit(1);
  }
}
