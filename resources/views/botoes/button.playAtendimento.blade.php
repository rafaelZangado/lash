@section('button')
    @if(!$agendamento->status == 1)
        {{-- iniciar --}}                     
        <button type="button" 
            class="btn btn-primary btn-rounded btn-icon-text" 
            id="meuBotao"
            value="" >
            <i class="mdi mdi-play-circle-outline"></i>
        </button>
        @else
        {{-- Encerrar Atendimento --}}    
        <button type="button" 
            class="btn btn-primary btn-rounded btn-icon-text" 
            id="meuBotao"
            value="" >
            <i class="mdi mdi-alarm-check"></i>                                                              
        </button>                        
    @endif
@endsection