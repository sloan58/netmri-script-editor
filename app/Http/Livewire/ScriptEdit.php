<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ScriptEdit extends Component
{
    public string $netmri;
    public string $scriptId;
    public ?string $modifiedScript;
    public string $sourceScript = '';
    public string $language;

    public function mount()
    {
        $this->sourceScript = json_decode(Http::withBasicAuth(env('NET_MRI_USER'), env('NET_MRI_PASSWORD'))
            ->withOptions(["verify" => false])
            ->get(sprintf('https://%s/api/3.8/scripts/export_file', env('NET_MRI_HOST')), [
                'id' => $this->scriptId,
            ])
            ->body())->content;
    }

    public function resetScript()
    {
        $this->modifiedScript = null;
        $this->emit('resetScript');  // Ace code editor is listening.

    }

    public function saveScript()
    {
        Http::withBasicAuth(env('NET_MRI_USER'), env('NET_MRI_PASSWORD'))
            ->withOptions(["verify" => false])
            ->get(sprintf('https://%s/api/3.8/scripts/update', env('NET_MRI_HOST')), [
                'id' => $this->scriptId,
                'script_file' => $this->modifiedScript,
                'language' => $this->language
            ])
            ->body();
    }

    public function codeUpdated($payload)
    {
        if($this->sourceScript !== $payload['code']) {
            $this->modifiedScript = $payload['code'];
        }
    }

    public function render()
    {
        return view('livewire.script-edit');
    }
}
