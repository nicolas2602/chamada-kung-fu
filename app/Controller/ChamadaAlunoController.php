<?php

namespace App\Controller;

use Config\Conexao;
use App\Services\ChamadaAlunoService;
use App\Dto\ChamadaAluno\ChamadaAlunoDto;
use App\Dto\HistoricoChamadaAluno\HistoricoChamadaAlunoEntradaDto;
use App\Exceptions\ChamadaAluno\ChamadaInvalidaException;
use App\Exceptions\ChamadaAluno\FalhaChamadaException;
use App\Helpers\Logger;
use App\Helpers\MensagemHelpers;

/**
 * @property ChamadaAlunoService $chamadaAlunoService
 */
class ChamadaAlunoController
{
    private ChamadaAlunoService $chamadaAlunoService;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->chamadaAlunoService = new ChamadaAlunoService($conexao);
    }

    /**
     * @return array<ChamadaAlunoDto>
     */
    public function listarChamadaAlunos(): array
    {
        return $this->chamadaAlunoService->listarChamadaAlunos();
    }

    /**
     * @return HistoricoChamadaAlunoEntradaDto
     */
    public function listarHistoricoChamadaAlunos(): HistoricoChamadaAlunoEntradaDto
    {
        return $this->chamadaAlunoService->listarHistoricoChamadaAlunos();
    }

    /**
     * @return void
     * @throws ChamadaInvalidaException|FalhaChamadaException
     */
    public function registrarChamada(): void
    {
        try {
            $this->chamadaAlunoService->registrarChamadaAluno();
            header("location: /app/view/chamada_aluno");
            exit;
        } catch (ChamadaInvalidaException $erro) {
            Logger::info($erro->getMessage());
            MensagemHelpers::aviso($erro->getMessage());
        } catch (FalhaChamadaException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro(
                "Ocorreu um erro ao registrar a chamada! Por favor, entre em contato com o administrador do sistema!"
            );
        }
    }

    /**
     * @param array{
     *  'statusChamada': array<string>
     * } $campo
     * @param array<ChamadaAlunoDto> $entradaDados
     * @return void
     * @throws FalhaChamadaException
     */
    public function salvarChamadaAluno($campo, $entradaDados): void
    {
        try {
            $this->chamadaAlunoService->salvarChamadaAluno($campo, $entradaDados);
            header("location: /app/view/chamada_aluno");
            exit;
        } catch (ChamadaInvalidaException $erro) {
            Logger::info($erro->getMessage());
            MensagemHelpers::aviso($erro->getMessage());
        } catch (FalhaChamadaException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro(
                "Ocorreu um erro ao salvar a chamada! Por favor, entre em contato com o administrador do sistema!"
            );
        }
    }
}
