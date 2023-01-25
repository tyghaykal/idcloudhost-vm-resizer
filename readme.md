# Auto VM Resizer

This is **UNOFFICIAL** Auto VM Resizer for
[IdCloudhost Console VM](https://console.idcloudhost.com). For official API, you
can read from this [Documentation](https://api.idcloudhost.com/).

## Requirement

PHP 7.3++

## Usage

Install required composer package using command

```bash
composer install
```

After that, assign value to .env. If you dont want to use telegram as
notification channel, just let it null.

You should change xxx value on BASE_URL to your VM server location, for example
Singapore location will be sgp01.

```env
PROCESSOR_MAX = 2
PROCESSOR_MIN = 1
RAM_MAX = 2048
RAM_MIN = 1024
TOKEN = YOUR_TOKEN
VM_ID = YOUR_VM_ID
BASE_URL = "https://api.idcloudhost.com/v1/xxx/"
TELEGRAM_TOKEN =
CHAT_ID =
```

You can run the script for 2 method, the first one is minimize and maximize.

Minimize will use PROCESSOR_MIN and RAM_MIN, and maximize will use the
PROCESSOR_MAX and RAM_MAX for your VM spec.

For example minimize

```bash
php index.php minimize
```

For example maximize

```bash
php index.php maximize
```

## Bug

If you find a bug, please open new issue.
