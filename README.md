# Chamada Kung-Fu

<p>
Este sistema é uma aplicação web desenvolvida em PHP para controle de presença dos alunos em uma academia de Kung-Fu. O projeto foi criado com fins de estudo, aplicando uma arquitetura organizada baseada em MVC, com separação em Services, DTOs e Helpers.
</p>

## Tecnologia utilizadas
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
  <li>Exceptions para tratamento de </li>
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

## Funcionalidades
<ul>
  <li>Login de usuários</li>
  <li>Cadastro de alunos</li>
  <li>Registro de presença (chamada)</li>
  <li>Histórico de chamadas</li>
</ul>

## Objetivo
Este projeto foi desenvolvido para prática de arquitetura em PHP, com foco em organização de código, separação de responsabilidades e boas práticas de desenvolvimento web.
