FROM node:lts-alpine

# instala um servidor http simples para servir conteúdo estático
RUN npm install -g http-server

# faz da pasta 'app' o diretório atual de trabalho
WORKDIR /app

# copia os arquivos 'package.json' e 'package-lock.json' (se disponível)
COPY package*.json ./

# instala dependências do projeto
RUN npm install

# copia arquivos e pastas para o diretório atual de trabalho (pasta 'app')
COPY . .

ARG VUE_APP_BACKEND_URL
ENV VUE_APP_BACKEND_URL=$VUE_APP_BACKEND_URL

# compila a aplicação de produção com minificação
RUN npm run build

EXPOSE 8080
CMD [ "http-server", "dist", "--cors"]