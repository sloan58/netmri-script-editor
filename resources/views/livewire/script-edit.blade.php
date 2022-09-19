<div>
    <div class="d-flex justify-content-center mb-2">
        <div class="col-10">
            <div class="d-flex justify-content-between">
                <div>
                    <div x-cloak x-data="{ shown: false, style: '' }"
                         x-init="@this.on('updated', (response) => {
                            style = response['success'] ? 'alert-success' : 'alert-danger';
                            shown = true;
                            setTimeout(() => { shown = false;}, 3000) })"
                    >
                        <div
                            x-transition
                            x-show="shown"
                            class="alert mb-0 py-1"
                            :class="style"
                            role="alert"
                        >
                            {{ $message }}
                        </div>
                    </div>
                </div>
                <div>
                    @if($modifiedScript)
                        <div>
                            <button wire:click="resetScript" type="button" class="btn btn-secondary">Reset</button>
                            <button wire:click="saveScript" wire:loading.remove wire:target="saveScript" type="button" class="btn btn-success ms-2">Save</button>
                            <button wire:loading wire:target="saveScript" type="button" class="btn btn-warning ms-2">Saving...</button>
                        </div>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>Reset</button>
                        <button type="button" class="btn btn-success ms-2" disabled>Save</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-10">
            <div wire:ignore id="editor"></div>
        </div>
    </div>
    @push('scripts')
        <script>
            let editorElement = document.getElementById('editor');

            // If we have an editor element
            if(editorElement){
                // pass options to ace.edit
                let editor = ace.edit(document.getElementById('editor'), {
                    mode: '{{ "ace/mode/" . strtolower($language)  }}',
                    theme: "ace/theme/dracula",
                    maxLines: 40,
                    minLines: 10,
                    fontSize: 14
                })
                // use setOptions method to set several options at once
                editor.setOptions({
                    autoScrollEditorIntoView: true,
                    copyWithEmptySelection: true,
                });

                editor.setValue(`{!! $sourceScript !!}`)

                editor.on("change", function(e){
                    @this.call('codeUpdated', { code : editor.getValue() });
                });

                window.Livewire.on('resetScript', () => { editor.setValue(`{!! $sourceScript !!}`)})
            }
        </script>
    @endpush
</div>
