# teste-comerc

### 1. Instalação da API

Acessar o diretório **api**
```bash
cd api
```

#### 1.1. Criar um alias para o Sail
Para Linux e algumas versões de macOS execute:
```bash
nano ~/.bashrc
```
ou para usuários de **zsh** (padrão no macOS):
```bash
nano ~/.zshrc
```
e adicione a seguinte linha ao final do arquivo:
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```
Após a edição execute:
```bash
source ~/.bashrc
```
ou
```bash
source ~/.zshrc
```

Agora é possível usar o comando `sail` diretamente para rodar os serviços Docker do Laravel.

#### 1.2. Copiar os arquivos .env.example
```bash
cp .env.example .env
```
Após executar o último comando, lembre-se de alterar as variáveis de ambiente se necessário.

#### 1.3. Rodar o ambiente Docker
```bash
sail up -d
```

#### 1.4. Executar as migrations
```bash
sail artisan migrate
```

#### 1.4. Executar os testes
```bash
sail test
```