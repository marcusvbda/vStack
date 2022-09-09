<resource-list-items resource_id="{{ $resource->id }}" :request_data='@json(request()->all())'></resource-list-items>   
<div class="row">
    <div class="col-12">
        @if ($data->total() > 0)
            @if ($report_mode)
                @include("vStack::resources.partials._report_table")
            @else
                @include("vStack::resources.partials._table")
            @endif
        @else
            @if ($resource->lenses())
                @include("vStack::resources.partials._lenses")
            @endif
            <h4 class="text-center my-4">
                {{ $resource->noResultsFoundText() }}
            </h4>
        @endif
    </div>
</div> 
    