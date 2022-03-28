<div>

    <div class="card mb-5">

        @if($beforeTableSlot)
            <div class="mt-8">
                @include($beforeTableSlot)
            </div>
        @endif

        <div class="card-header border-bottom-1 pt-5 pb-5 d-flex align-items-center">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">

                    @if(method_exists($this, 'getTableTitle'))
                        {{$this->getTableTitle()}}
                    @else
                        Datatable results
                    @endif
                </span>
                <span class="text-muted mt-1 fw-bold fs-7">
                    @if ($this->results->total() >= 1)
                        <strong>{{$this->results->total()}}</strong> records in total
                    @else
                        <strong>{{$this->results->total()}}</strong> records
                    @endif
                </span>
            </h3>
            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Actions">
                <div class="d-flex align-items-center">
                    <div class="px-2 px2">
                        <div wire:loading>
                            <div class="d-flex justify-content-start">
                                <span>{{__('livewire-datatables::datatable.loading')}}</span>
                                <span class="mx-2">@include('datatables::icons.loading')</span>
                            </div>
                        </div>
                        @switch($hideable)
                            @case('buttons')
                            @foreach($this->columns as $index => $column)
                                @if ($column['type'] !== 'checkbox')
                                    <span class="badge badge-primary m-2" wire:click.prefech="toggle('{{ $index }}')">
                                {{ str_replace('_', ' ', $column['label']) }}
                                        @if($column['hidden'])
                                            @include('datatables::icons.eye-slash')
                                        @else
                                            @include('datatables::icons.eye')
                                        @endif
                            </span>
                                @endif
                            @endforeach
                            @break
                        @endswitch
                    </div>

                    <div class="d-flex align-items-center input-group px-2 px2">
                        @if($exportable)
                            <div class="input-group-append mx-1" id="export-excel">
                                <div class="ml-2" x-data="{ init() { window.livewire.on('startDownload', link => window.open(link,'_blank')) } }" x-init="init">
                                    <button wire:click="export" class="btn btn-outline-success">
                                        @include('datatables::icons.excel', ['text' => __('livewire-datatables::datatable.export')])
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($hideable === 'select')
                            <div class="input-group-append mx-1" id="hideable-select">
                                @include('datatables::hide-column-multiselect')
                            </div>
                        @endif

                        <div class="input-group-append mx-1" id="simple-pagination">
                            {{ $this->results->links('datatables::paginators.simple') }}
                        </div>

                        <div class="input-group-append mx-1" id="button-close">
                            <button wire:click="$set('search', null)" class="btn btn-light-primary btn-sm py-2 px-4">
                                @include('datatables::icons.x-circle', ['classIcon' => 'text-red'])
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($this->searchableColumns()->count())
            <div class="border-bottom border-bottom-1 bg-dark text-dark bg-opacity-5 px-6 py-6">
                <div class="input-group input-group-sm my-1 mx-1 col-4" id="loading-search">
                    <input wire:model.debounce.500ms="search" class="form-control border-light" placeholder="{{ __('livewire-datatables::datatable.search', ['columns' => $this->searchableColumns()->map->label->join(', ')]) }}"/>
                    <span class="input-group-text btn btn-light-primary btn-sm ">@include('datatables::icons.search')</span>
                </div>
            </div>
        @endif

        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 m-0 p-0">
                    @unless($this->hideHeader)
                        <thead>
                        <tr class="fw-bolder text-muted">
                            @foreach($this->columns as $index => $column)
                                @if($column['type'] === 'checkbox')
                                    <th class="w-25px">
                                        <span>{{ __('livewire-datatables::datatable.select_all') }}</span>
                                        <div class="custom-control custom-switch">
                                            <input id="select-all" type="checkbox" class="custom-control-input" wire:click="toggleSelectAll" @if(count($selected) === $this->results->total()) checked @endif />
                                            <label for="select-all" class="custom-control-label"></label>
                                        </div>
                                        {{ count($selected) }}
                                    </th>
                                @endif

                                @if ($column['filterable'] && !$column['hidden'])
                                    <th>
                                        @if(is_iterable($column['filterable']))
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                                            </div>
                                        @else
                                            <div wire:key="{{ $index }}">
                                                @include('datatables::filters.' . ($column['filterView'] ?? $column['type']), ['index' => $index, 'name' => $column['label']])
                                            </div>
                                        @endif
                                        @if($column['type'] !== 'checkbox')
                                            @switch($hideable)
                                                @case('inline')
                                                @include('datatables::headers.inline', ['column' => $column, 'sort' => $sort])
                                                @break
                                                @case('select')
                                                @include('datatables::headers.select', ['column' => $column, 'sort' => $sort])
                                                @break
                                                @case('buttons')
                                                @include('datatables::headers.buttons', ['column' => $column, 'sort' => $sort])
                                                @break
                                                @default
                                                @include('datatables::headers.default', ['column' => $column, 'sort' => $sort])
                                                @break
                                            @endswitch
                                        @endif
                                    </th>
                                @else
                                    @if($column['type'] !== 'checkbox')
                                        @switch($hideable)
                                            @case('inline')
                                            @include('datatables::headers.inline', ['column' => $column, 'sort' => $sort, 'isTemplateSyntax' => true])
                                            @break
                                            @case('select')
                                            @include('datatables::headers.select', ['column' => $column, 'sort' => $sort, 'isTemplateSyntax' => true])
                                            @break
                                            @case('buttons')
                                            @include('datatables::headers.buttons', ['column' => $column, 'sort' => $sort, 'isTemplateSyntax' => true])
                                            @break
                                            @default
                                            @include('datatables::headers.default', ['column' => $column, 'sort' => $sort, 'isTemplateSyntax' => true])
                                            @break
                                        @endswitch
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        </thead>
                    @endif
                    <tbody>
                    @forelse($this->results as $result)

                        <tr class="fw-bold clearfix {{ isset($result->checkbox_attribute) && in_array($result->checkbox_attribute, $selected) ? 'table-warning' : '' }}">
                            @foreach($this->columns as $column)
                                @if($column['hidden'])
                                    @switch($hideable)
                                        @case('inline')
                                        <th></th>
                                        @break
                                        @case('')
                                        <th></th>
                                        @break
                                    @endswitch
                                @elseif($column['type'] === 'checkbox')
                                    <th>@include('datatables::checkbox', ['value' => $result->checkbox_attribute])</th>
                                @else
                                    <th class=" @if($column['align'] === 'right') text-right @elseif($column['align'] === 'center') text-center @else text-left @endif">
                                        {!! $result->{$column['name']} !!}
                                    </th>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th class="text-center" colspan="{{ count($this->columns) }}">
                                <small>{{ __('livewire-datatables::datatable.no_data_table') }}</small>
                            </th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                @unless($this->hidePagination)

                    <div class="card-footer d-flex justify-content-end py-2 px-4">
                        <div class="paging_simple_numbers">
                            <div class="d-flex align-items-center justify-content-end pt-4">
                                <div class="clearfix mx-2 my-2">
                                    {{ $this->results->links('datatables::paginators.bootstrap') }}
                                </div>
                                <div class="clearfix mx-2 my-2">
                                    @include('datatables::paginators.per-page')
                                </div>
                                <div class="clearfix mx-2 my-2">
                                    {{ __('livewire-datatables::datatable.pagination_text', ['start' => $this->results->firstItem(), 'end' => $this->results->lastItem(), 'total' => $this->results->total()]) }}
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
        </div>

        @if($afterTableSlot)
            <div class="mt-8">
                @include($afterTableSlot)
            </div>
        @endif
    </div>

</div>
