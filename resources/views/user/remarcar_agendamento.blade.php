<!DOCTYPE html>
<html lang="pt-BR">
<head>
    @include('admin.css')
</head>
<body>
<div class="container-scroller">
    @include('admin.sidebar')
    @include('admin.navbar')

    <div class="container-fluid page-body-wrapper">
        <div class="container" style="padding-top: 100px; max-width: 600px;">
            <h2 class="text-center mb-4">Remarcar Agendamento</h2>

            @if(session('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ url('/agendamento/' . $agendamento->id . '/remarcar') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="date">Nova Data</label>
                    <input type="date" name="date" id="data" class="form-control" value="{{ $agendamento->date }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="time">Novo Horário</label>
                    <select name="time" id="horario" class="form-control" required>
                        <option value="">Selecione uma data primeiro</option>
                    </select>
                </div>

                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ url('/meus-agendamentos') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.script')

{{-- Script para preencher horários disponíveis --}}
<script>
document.addEventListener('DOMContentLoaded', async function () {
    const campoData = document.getElementById('data');
    const campoHora = document.getElementById('horario');

    let dados = {};
    try {
        const resposta = await fetch('/disponibilidade');
        if (!resposta.ok) throw new Error();
        dados = await resposta.json();
    } catch (e) {
        campoHora.innerHTML = '<option value="">Erro ao carregar horários</option>';
        return;
    }

    const diasBloqueados = dados.datas_bloqueadas;
    const horariosBloqueados = dados.horarios_bloqueados;

    const hoje = new Date().toISOString().split('T')[0];
    campoData.setAttribute('min', hoje);

    campoData.addEventListener('change', function () {
        const dataSelecionada = this.value;
        campoHora.innerHTML = '';

        const diaSemana = new Date(dataSelecionada).getDay();
        if (diaSemana === 0 || diaSemana === 6) {
            campoHora.innerHTML = '<option value="">Fim de semana indisponível</option>';
            return;
        }

        if (diasBloqueados.includes(dataSelecionada)) {
            campoHora.innerHTML = '<option value="">Este dia está com limite esgotado</option>';
            return;
        }

        const horarios = [];
        for (let h = 8; h < 17; h++) {
            const hora = h.toString().padStart(2, '0') + ':00';
            if (!horariosBloqueados[dataSelecionada] || !horariosBloqueados[dataSelecionada].includes(hora)) {
                horarios.push(hora);
            }
        }

        if (horarios.length === 0) {
            campoHora.innerHTML = '<option value="">Nenhum horário disponível</option>';
        } else {
            campoHora.innerHTML = '<option value="">Selecione um horário</option>';
            horarios.forEach(h => {
                campoHora.innerHTML += `<option value="${h}">${h}</option>`;
            });
        }
    });

    // Se já existe uma data (carregamento inicial)
    if (campoData.value) {
        campoData.dispatchEvent(new Event('change'));
    }
});
</script>
</body>
</html>
