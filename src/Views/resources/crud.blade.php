@extends("templates.admin")
@section('title',$resource->label())
<?php 
$cards = $data["fields"];
$raw_types = ["Edição" => "edit","Cadastro" => "create"];

?>
@section('breadcrumb')
<?php 
    $routes = [];
    $current = $data['page_type']." de ".$resource->singularLabel();
    $current_route = $resource->route()."/".@$content->code."/".$raw_types[$data["page_type"]];
    Session::push("breadcrumb",[$current=>$current_route]);
    $bc = Session::get("breadcrumb");
    Session::forget('breadcrumb');
    $indexes = [];
    foreach($bc as $row)
    {
        foreach($row as $key=>$value)
        {
            if(!in_array($key,$indexes))
            {
                $indexes[] = $key;
                Session::push("breadcrumb",[$key=>$value]);
                $routes[] = $value;
            }
            if($key==$current) {
                break 2;
            };
        }
    }
    $bc = Session::get("breadcrumb");
?>
<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <?php $bc = Session::get('breadcrumb');?>
                    @foreach($bc as $rows)
                        @foreach($rows as $key=>$value)
                            <li class="breadcrumb-item">
                                <a  href="{{$value}}" class="link">{{$key}}</a>
                            </li>
                        @endforeach
                    @endforeach
                </ol>
            </nav>
        </nav>
    </div>
</div>
@endsection
@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="d-flex flex-row justify-content-between mb-3">
            <h4>@if( @$resource->icon() ) <span class="{{$resource->icon()}} mr-2"></span> @endif {{$data["page_type"]}} de {{$resource->singularLabel()}}</h4>
        </div>
    </div>
</div>
@if(($data["page_type"]=="Edição") && $resource->useTags())
	<resource-tags-input resource='{{$resource->id}}' resource_code='{{@$content->code}}'></resource-tags-input>
@endif
@if(@!$data->id)
    @if(@$resource->beforeCreateSlot())
        {!! @$resource->beforeCreateSlot() !!}
    @endif
@else 
    @if(@$resource->beforeEditSlot())
    {!! @$resource->beforeEditSlot() !!}
    @endif
@endif
<resource-crud 
    :data="{{json_encode($data)}}"  
    :params="{{json_encode($params)}}"  
    redirect="{{$current_route}}" 
    :breadcrumb="{{json_encode($routes)}}" >
    @if(@!$data->id && !@$data["id"])
        @if(@$resource->afterCreateSlot())
            <template slot="aftercreate">
                {!! @$resource->afterCreateSlot() !!}
            </template>
        @endif
    @else
        @if(@$resource->afterEditSlot())
            <template slot="afteredit">
                {!! @$resource->afterEditSlot() !!}
            </template>
        @endif
    @endif
</resource-crud>


@endsection
