<tr>
	<td class="w-25">
		<div class="d-flex flex-column">
			@if(@$label) 
				<span class="input-title">{!! $label !!}</span> 
			@endif
			@if(@$description) 
				<small  class="mt-1 text-muted">
					{!! $description !!}
				</small>
			@endif
		</div>
	</td>
    <td>
        <div class='d-flex flex-column'>                                                   
            <el-switch              
                :disabled='{{$disabled}}'                               
                class='ml-3'                          
                v-model='{{"form.$field"}}'                 
                active-color='{{$active_color}}'          
                inactive-color='{{$inactive_color}}'      
                active-text='{{$active_text}}'            
                inactive-text='{{$inactive_text}}'>       
            </el-switch> 
            @if(@$description)
                <br><small style='color:gray;' class='mt-1 pl-3'>{!! $description!!}</small>
            @endif
        </div>                             
    </td>                             
</tr>
