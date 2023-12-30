## Setup and Run

Create containers and execute composer install and run application:
```bash
bash docker/build.sh
```
<br />

Run application:
```bash
bash docker/start.sh
```

<br />
If you have issues with container ports, please change the NGINX_MAPPED_PORT

```bash
cp .env .env.local
```
Under `.env.local`, assign another available port, for instance:
```bash
NGINX_MAPPED_PORT=8088
```
## example test commands

verifying MonoBank with a currency threshold of 10 coins (the variance between the sell and buy prices)

```bash
bash docker/command-check-currency-rate.sh "10 monobank"
```
<br />

verifying PrivatBank with a currency threshold of 10 coins (the variance between the sell and buy prices)

```bash
bash docker/command-check-currency-rate.sh "10 privat_bank"
```

## notify channels

- telegram https://t.me/UGXywVSGEi
