USE kung_fu;

# Perfil
CREATE TABLE perfil(
    idPerfil INT PRIMARY KEY AUTO_INCREMENT,
    tipoPerfil VARCHAR(20)
);

# Usuário
CREATE TABLE usuario(
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nomeUsuario VARCHAR(20) NOT NULL UNIQUE,
    emailUsuario VARCHAR(25) NOT NULL UNIQUE,
    senhaUsuario VARCHAR(12) NOT NULL UNIQUE,
    fkIdPerfil INT NOT NULL,
    FOREIGN KEY (fkIdPerfil) REFERENCES perfil(idPerfil)
);

# Faixa
CREATE TABLE nivel_faixa(
    idNivFaixa INT PRIMARY KEY AUTO_INCREMENT,
    tipoNivFaixa VARCHAR(20)
);

# Status matrícula
CREATE TABLE status_matricula(
    idStatusMat INT PRIMARY KEY AUTO_INCREMENT,
    statusMat VARCHAR(20)
);

# Pessoa
CREATE TABLE pessoa(
    idPessoa INT PRIMARY KEY AUTO_INCREMENT,
    nomePessoa VARCHAR(50) NOT NULL,
    sobNomePessoa VARCHAR(50) NOT NULL,
    dataNascimento DATE NOT NULL,
    fkIdNivFaixa INT NOT NULL,
    fkIdStatusMat INT NOT NULL,
    fkIdUsuario INT NOT NULL,
    FOREIGN KEY (fkIdStatusMat) REFERENCES status_matricula(idStatusMat),
    FOREIGN KEY (fkIdNivFaixa) REFERENCES nivel_faixa(idNivFaixa),
    FOREIGN KEY (fkIdUsuario) REFERENCES usuario(idUsuario)
);

# Status chamada
CREATE TABLE status_chamada(
    idStatusChamada INT PRIMARY KEY AUTO_INCREMENT,
    tipoStatusChamada VARCHAR(20)
);

# Chamada Pessoa
CREATE TABLE chamada_pessoa(
    idChamada INT PRIMARY KEY AUTO_INCREMENT,
    dataChamada DATE NOT NULL,
    fkIdPessoa INT NOT NULL,
    fkIdStatusChamada INT NOT NULL,
    FOREIGN KEY(fkIdPessoa) REFERENCES pessoa(idPessoa),
    FOREIGN KEY(fkIdStatusChamada) REFERENCES status_chamada(idStatusChamada),
    UNIQUE(fkIdPessoa, dataChamada)
);
