# Docker Installation Instructions

## Installation on Linux

### Requirements
- Supported Linux distribution (Ubuntu, Debian, Fedora, etc.)

### Step-by-Step

1. **Install Docker:**
- Follow the Docker installation instructions for your Linux distribution from the official site.

- ***Example for Ubuntu:***

```sh
sudo apt-get update
sudo apt-get install \
    ca-certificates \
    curl \
    gnupg \
    lsb-release

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli
```

2. **Start Docker:**

```sh
sudo systemctl start docker
```

3. **Verify Installation:**

- Run the command:

```sh
docker --version
```

You should see the installed Docker version.

4. **Install Docker Compose:**

```sh
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

5. **Add your user to the Docker group:**

```sh
sudo usermod -aG docker $USER
```

- Note: You may need to restart your session for the changes to take effect.

6. ***Verify Docker Compose Installation:***

- Run the command:

```sh
docker-compose --version
```