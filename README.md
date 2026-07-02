# Chamada Kung-Fu

<p>
Este sistema é uma aplicação web desenvolvida em PHP para controle de presença dos alunos em uma academia de Kung-Fu. O projeto foi criado com fins de estudo, aplicando uma arquitetura organizada baseada em MVC, com separação em Services, DTOs e Helpers.
</p>

## Tecnologias utilizadas
<ul>
  <li>PHP 8.2</li>
  <li>MySQL</li>
  <li>HTML5</li>
  <li>CSS3</li>
  <li>JavaScript</li>
  <li>Bootstrap</li>
  <li>Dev Container</li>
  <li>Docker</li>
</ul>

## Arquitetura do sistema

O projeto segue a arquitetura:
<ul>
  <li>MVC (Model-View-Controller)</li>
  <li>Services para regras de negócio</li>
  <li>DTO (Data Transfer Objects) para transporte de dados</li>
  <li>Helpers para funções auxiliares</li>
  <li>Exceptions para tratamento de erros</li>
</ul>

## Organização geral
<ul>
  <li>Models → Acesso ao banco de dados</li>
  <li>Views → Interface do usuário</li>
  <li>Controllers → Controle das requisições</li>
  <li>Services → Regras de negócio (ex: registrar presença)</li>
  <li>DTOs → Estruturas de dados entre camadas</li>
  <li>Helpers → Funções reutilizáveis (formatação, validação etc.)</li>
  <li>Exceptions → Tratamento de erros e validações do sistema</li>
</ul>

## Detalhes da Arquitetura e Estrutura de Pastas
```text
app
├── Controller
│   ├── CadastroAlunoController.php
│   ├── ChamadaAlunoController.php
│   └── LoginController.php
├── Dto
│   ├── CadastroAluno
│   │   ├── CadastroAlunoCampoAtualizacaoDto.php
│   │   ├── CadastroAlunoCampoDto.php
│   │   ├── CadastroAlunoDto.php
│   │   ├── CadastroAlunoEntradaDto.php
│   │   └── CadastroAlunoFiltroDto.php
│   ├── ChamadaAluno
│   │   ├── ChamadaAlunoDto.php
│   │   ├── ChamadaAlunoInsereDto.php
│   │   └── ChamadaAlunoSalvaDto.php
│   ├── HistoricoChamadaAluno
│   │   ├── HistoricoChamadaAlunoDto.php
│   │   ├── HistoricoChamadaAlunoEntradaDto.php
│   │   └── HistoricoChamadaAlunoPorDataDto.php
│   ├── Login
│   │   ├── LoginCampoDto.php
│   │   └── LoginDto.php
│   ├── NivelFaixaDto.php
│   ├── PaginacaoDto.php
│   ├── PerfilUsuarioDto.php
│   ├── StatusChamadaDto.php
│   └── StatusMatriculaDto.php
├── Exceptions
│   ├── CadastroAluno
│   │   ├── CadastroInvalidoException.php
│   │   └── FalhaCadastroException.php
│   └── ChamadaAluno
│       ├── ChamadaInvalidaException.php
│       └── FalhaChamadaException.php
├── Helpers
│   ├── CaminhoHelpers.php
│   ├── FormularioHelpers.php
│   ├── Logger.php
│   ├── MensagemHelpers.php
│   ├── PaginacaoHelpers.php
│   └── ValidacaoHelpers.php
├── Model
│   ├── CadastroAlunoModel.php
│   ├── ChamadaAlunoModel.php
│   ├── ClasseAuxiliarModel.php
│   └── LoginModel.php
├── Services
│   ├── CadastroAlunoService.php
│   ├── ChamadaAlunoService.php
│   ├── LoginService.php
│   └── SessaoService.php
└── view
    ├── cadastro_aluno
    │   ├── conteudo.php
    │   ├── index.php
    │   └── logica.php
    ├── chamada_aluno
    │   ├── conteudo.php
    │   ├── index.php
    │   └── logica.php
    ├── historico_chamada
    │   ├── conteudo.php
    │   ├── index.php
    │   └── logica.php
    ├── login
    │   ├── conteudo.php
    │   ├── index.php
    │   └── logica.php
    └── pagina_principal
        ├── conteudo.php
        ├── index.php
        └── logica.php
config
└── Conexao.php
database
├── 1-create_tables.sql
├── 2-insert_perfil.sql
├── 3-insert_usuario.sql
├── 4-insert_nivel_faixa.sql
├── 5-insert_status_matricula.sql
├── 6-insert_pessoa.sql
├── 7-insert_status_chamada.sql
└── 8-insert_chamada_pessoa.sql
public
├── assets
│   ├── script
│   │   └── modalCadastroAluno.js
│   └── style
│       └── style.css
├── components
│   ├── campo.php
│   ├── mensagem.php
│   ├── menu.php
│   ├── modal.php
│   ├── paginacao.php
│   ├── rodape.php
│   └── tabela.php
├── index.php
└── logout.php
```

## Modelagem do banco de dados
#### Modelo Entidade-Relacionamento
<img width="1150" height="629" alt="image" src="https://github.com/user-attachments/assets/7d6e40dd-4b57-4d6a-b381-35a578a25268" />

#### Modelo Lógico
<img width="859" height="692" alt="image" src="https://github.com/user-attachments/assets/292c69bc-80f8-47b0-b92b-31e13f509199" />

## Funcionalidades
<ul>
  <li>Login de usuários</li>
  <li>Cadastro de alunos</li>
  <li>Registro de presença (chamada)</li>
  <li>Histórico de chamadas</li>
</ul>

## Pré-requistos de instalação
Para instalar o projeto, é necessário ter a seguintes ferramentas:
<ul>
  <li>Docker</li>
  <li>WSL ou Linux (para rodar o Docker)</li>
  <li>VS Code (Recomendado)</li>
</ul>

## Objetivo
Este projeto foi desenvolvido para prática de arquitetura em PHP, com foco em organização de código, separação de responsabilidades e boas práticas de desenvolvimento web.
