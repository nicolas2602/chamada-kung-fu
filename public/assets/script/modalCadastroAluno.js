const btnAtualizarAluno = document.getElementById('btnAtualizarAluno');
btnAtualizarAluno.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    let idAluno = document.getElementById('idAluno');
    let nomeAluno = document.getElementById('nomeAluno');
    let sobrenomeAluno = document.getElementById('sobrenomeAluno');
    let dataNascimento = document.getElementById('dataNascimento');
    let nivelFaixa = document.getElementById('nivelFaixa');
    let statusMatricula = document.getElementById('statusMatricula');

    idAluno.value = button.getAttribute('data-id-aluno');
    nomeAluno.value = button.getAttribute('data-nome-aluno');
    sobrenomeAluno.value = button.getAttribute('data-sobrenome-aluno');
    dataNascimento.value = button.getAttribute('data-data-nascimento');
    nivelFaixa.value = button.getAttribute('data-nivel-faixa');
    statusMatricula.value = button.getAttribute('data-status-matricula');
});
