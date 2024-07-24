# Use a imagem base
FROM ubuntu:latest

# Instale o Git e o SSH
RUN apt-get update && \
    apt-get install -y git openssh-client && \
    apt-get clean

# Adicione o diretório .ssh
RUN mkdir -p /root/.ssh && \
    chmod 700 /root/.ssh

# Adicione o GitHub ao known_hosts
RUN ssh-keyscan github.com >> /root/.ssh/known_hosts

# Clone o repositório
RUN git clone git@github.com:Ericsonpiccoli/contact.git
