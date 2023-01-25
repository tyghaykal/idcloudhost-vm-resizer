<?php
require_once "helper.php";
require_once "telegram.php";
require_once "API.php";

Helper::load();

try {
    if ($argc == 2) {
        if (!in_array($argv[1], ["maximize", "minimize"])) {
            throw new Exception(
                "You can only use these 2 types of args, maximize or minimize.",
                500
            );
        }

        $vmInfo = API::VMInfo();
        if ($vmInfo->status == "running") {
            $vmInfo = API::shutdownVM();
        }

        $vmInfo = API::VMInfo();
        if ($argv[1] == "maximize") {
            Helper::checkEqual(
                $vmInfo,
                $_ENV["RAM_MAX"],
                $_ENV["PROCESSOR_MAX"]
            );
            $vmInfo = API::modifyVM($_ENV["RAM_MAX"], $_ENV["PROCESSOR_MAX"]);
        } else {
            Helper::checkEqual(
                $vmInfo,
                $_ENV["RAM_MIN"],
                $_ENV["PROCESSOR_MIN"]
            );
            $vmInfo = API::modifyVM($_ENV["RAM_MIN"], $_ENV["PROCESSOR_MIN"]);
        }
        $vmInfo = API::startVM();

        echo "[+]Success run function " . $argv[1] . PHP_EOL;
        Telegram::sendMessage(false, [
            "type" => $argv[1],
        ]);
    } else {
        throw new Exception(
            "Please add 1 args (maximize or minimize) to run this file",
            500
        );
    }
} catch (\Exception $e) {
    echo "[" . $e->getCode() . "]" . $e->getMessage() . " " . PHP_EOL;
    Telegram::sendMessage(true, [
        "type" => $argv[1],
        "error_message" => $e->getMessage(),
        "error_code" => $e->getCode(),
    ]);
}
