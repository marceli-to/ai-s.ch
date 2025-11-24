<?php
namespace App\Scopes;
use Statamic\Query\Scopes\Scope;

class UpcomingEvents extends Scope
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
    $query->where(function ($q) {
      $q->where(function ($inner) {
        $inner->whereNotNull('event_periode_end')
              ->where('event_periode_end', '>=', now());
      })->orWhere(function ($inner) {
        $inner->whereNull('event_periode_end')
              ->where('event_date', '>=', now()->startOfDay());
      });
    });
  }
}
