<div class="input-group input-group-sm mx-1">
    {{-- Check if there is any data --}}
    @if($this->results[1])
        <div class="form-group">
            <select name="perPage" class="form-select form-select-solid" wire:model="perPage">
                @foreach(config('livewire-datatables.per_page_options', [10, 25, 50, 100]) as $perPageOption)
                    <option value="{{ $perPageOption }}">{{ $perPageOption }}</option>
                @endforeach
                <option value="99999999">{{ __('livewire-datatables::datatable.all') }}</option>
            </select>
        </div>
    @endif
</div>
