
<div class="btn-group mx-1" role="group" aria-label="simple-pagination">
    <!-- Previous Page Link -->
    <a class="btn btn-light-primary py-5 px-3" @unless ($paginator->onFirstPage()) wire:click="previousPage" @endunless data-toggle="tooltip" data-placement="top" title="{{ __('livewire-datatables::datatable.prev') }}">
               <span class="text-md {{$paginator->onFirstPage() ? 'text-gray' : ''}}">
            @include('datatables::icons.arrow-left')
        </span>
    </a>

    <!-- Next Page Link -->
    <a class="btn btn-light-primary py-5 px-3" @if ($paginator->hasMorePages()) wire:click="nextPage" @endif data-toggle="tooltip" data-placement="top" title="{{ __('livewire-datatables::datatable.next') }}">
        <span class="text-md {{!$paginator->hasMorePages() ? 'text-gray' : ''}}">
            @include('datatables::icons.arrow-right')
        </span>
    </a>
</div>
