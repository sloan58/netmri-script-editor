<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class ScriptList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public array $scripts;
    public array $scriptList;
    public string $filter = '';
    public string $language = '';

    public function mount()
    {
        $response = json_decode(
            Http::withBasicAuth(env('NET_MRI_USER'), env('NET_MRI_PASSWORD'))
                ->withOptions(["verify" => false])
                ->get(sprintf('https://%s/api/3.8/scripts/index', env('NET_MRI_HOST')))
                ->body()
        )->scripts;

        $this->scripts = json_decode(json_encode($response), true);
        $this->scriptList = $this->scripts;

    }

    private function filterScripts()
    {
        $filteredScripts = $this->scriptList;

        if($this->filter) {
            $filteredScripts = collect($filteredScripts)->filter(function($script) {
                return Str::contains(strtolower($script['name']), strtolower($this->filter))
                    or Str::contains(strtolower($script['description']), strtolower($this->filter));
            })->toArray();
        }

        if($this->language) {
            $filteredScripts = collect($filteredScripts)->filter(function($script) {
                return $script['language'] == $this->language;
            })->toArray();
        }

        return $filteredScripts;
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function render()
    {
        return view('livewire.script-list', [
            'tests' => $this->paginate($this->filterScripts())
        ]);
    }
}
