<div class="card p-4 shadow-lg">
    <div class="d-flex justify-content-between mb-2">
        <div class="card-title">
            NetMRI Scripts
        </div>
        <div class="d-flex gap-2">
            <div class="input-group">
                <input wire:model.debounce.250ms="filter" type="text" class="form-control rounded text-center" placeholder="Search...">
            </div>
        </div>
        <div>
            <select wire:model="language" class="form-select" aria-label="Default select example">
                <option selected value="">Filter by language</option>
                <option value="Python">Python</option>
                <option value="Perl">Perl</option>
                <option value="CCS">CCS</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Script Name</th>
            <th scope="col">Script Description</th>
            <th scope="col">Language</th>
            <th scope="col">Created By</th>
            <th scope="col">Read Only</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tests as $script)
            <tr>
                <td>
                    @if(!$script['read_only'])
                        <a href="{{ route('script.edit', ['netmri' => '1', 'scriptId' => $script['id'], 'language' => $script['language']]) }}">
                            {{ $script['name'] }}
                        </a>
                    @else
                        {{ $script['name'] }}
                    @endif
                </td>
                <td>{{ $script['description'] }}</td>
                <td>{{ $script['language'] }}</td>
                <td>{{ $script['created_by'] }}</td>
                <td>{{ $script['read_only'] ? 'True' : 'False' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {!! $tests->links() !!}
    </div>
</div>
