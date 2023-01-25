<?php

class Telegram
{
    public static function sendMessage(bool $isError = false, array $data): void
    {
        if ($_ENV["TELEGRAM_TOKEN"] != null) {
            echo "[-]Trying send notification" . PHP_EOL;
            $url =
                "https://api.telegram.org/bot" .
                $_ENV["TELEGRAM_TOKEN"] .
                "/sendMessage";

            if ($isError) {
                $message = self::generateErrorMessage($data);
            } else {
                $message = self::generateSuccessMessage($data);
            }

            $curl = Helper::curl();
            $curl->post($url, [
                "chat_id" => $_ENV["CHAT_ID"],
                "text" => $message,
                "parse_mode" => "Markdown",
            ]);

            if ($curl->error) {
                echo "[500] Failed send notification - " .
                    ($curl->response == ""
                        ? $curl->errorMessage
                        : $curl->response->description) .
                    PHP_EOL;
            } else {
                echo "[+]Success send notification" . PHP_EOL;
            }
        } else {
            echo "[+]Skip Send Notification" . PHP_EOL;
        }
    }

    private static function generateErrorMessage(array $data): string
    {
        $now = new \DateTime();
        $message = "*[ " . $now->format("H:i:s - d F Y") . " ]*\n";
        $message .= "*Status* : Failed\n";
        $message .=
            "*Message* : Error run script for " .
            $data["type"] .
            " the server\n";
        $message .= "*Error Code* : " . $data["error_code"];
        $message .= "\n*Error Message* : " . $data["error_message"];
        return $message;
    }

    private static function generateSuccessMessage(array $data): string
    {
        $now = new \DateTime();
        $message = "*[ " . $now->format("H:i:s - d F Y") . " ]*\n";
        $message .= "*Status* : Success\n";
        $message .=
            "*Message* : Success run script for " .
            $data["type"] .
            " the server";
        return $message;
    }
}
