<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        JsonResource::withoutWrapping();

        Builder::macro('whereLike', function ($attributes, $searchTerm){
            $this->where(function (Builder $query) use($attributes, $searchTerm){
                foreach (Arr::wrap($attributes) as $attribute){
                    $query->when(str_contains($attribute, '.'), function (Builder $query)use($attribute, $searchTerm){
                        [$relationName, $relationAttribute] = explode('.', $attribute);
                        $query->orWhereHas($relationName, function (Builder $query)use($relationAttribute, $searchTerm){
                            $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                        });
                    },
                    function (Builder $query)use($attribute, $searchTerm){
                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    });
                }
            });
            return $this;
        });

        Builder::macro('search', function ($attributes, $searchTerm) {
            return $this->whereAny($attributes, 'LIKE', "%{$searchTerm}%")
                ->orderBy(request()->sort ?? 'id', request()->order ?? 'desc')
                ->paginate(request()->limit ?? 15);
        });

        Builder::macro('sortBy', function (){
            return $this->orderBy(request()->input('orderBy') ?? 'id', request()->input('sortBy') ?? 'desc');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
