
-- Criação da tabela Usuário
CREATE TABLE Usuario (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(255) NOT NULL,
    NomeUsuario VARCHAR(255) UNIQUE NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    FotoPerfil VARCHAR(255),
    Descricao TEXT
);

-- Criação da tabela Música
CREATE TABLE Musica (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255) NOT NULL,
    Genero VARCHAR(255),
    DataUpload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Artista INT NOT NULL,
    NomeArquivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (Artista) REFERENCES Usuario(ID) ON DELETE CASCADE
);

-- Criação da tabela Conexão
CREATE TABLE Conexao (
    UsuarioOrigemID INT NOT NULL,
    UsuarioDestinoID INT NOT NULL,
    DataCriacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (UsuarioOrigemID, UsuarioDestinoID),
    FOREIGN KEY (UsuarioOrigemID) REFERENCES Usuario(ID) ON DELETE CASCADE,
    FOREIGN KEY (UsuarioDestinoID) REFERENCES Usuario(ID) ON DELETE CASCADE
);

-- Criação da tabela Projeto Musical
CREATE TABLE ProjetoMusical (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(255) NOT NULL,
    Descricao TEXT,
    UsuarioCriadorID INT NOT NULL,
    FOREIGN KEY (UsuarioCriadorID) REFERENCES Usuario(ID) ON DELETE CASCADE
);

-- Criação da tabela Membros do Projeto
CREATE TABLE MembroProjeto (
    ProjetoID INT NOT NULL,
    UsuarioID INT NOT NULL,
    PRIMARY KEY (ProjetoID, UsuarioID),
    FOREIGN KEY (ProjetoID) REFERENCES ProjetoMusical(ID) ON DELETE CASCADE,
    FOREIGN KEY (UsuarioID) REFERENCES Usuario(ID) ON DELETE CASCADE
);

-- Criação da tabela Feed de Atividades
CREATE TABLE FeedAtividades (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UsuarioID INT NOT NULL,
    MusicaID INT,
    ProjetoID INT,
    DataAtividade TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UsuarioID) REFERENCES Usuario(ID) ON DELETE CASCADE,
    FOREIGN KEY (MusicaID) REFERENCES Musica(ID) ON DELETE CASCADE,
    FOREIGN KEY (ProjetoID) REFERENCES ProjetoMusical(ID) ON DELETE CASCADE
);