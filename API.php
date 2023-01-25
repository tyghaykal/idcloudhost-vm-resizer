<?php

class API
{
    public static function VMInfo()
    {
        echo "[-]Trying to Get VM Info" . PHP_EOL;
        $curl = Helper::curl();
        $curl->get($_ENV["BASE_URL"] . "user-resource/vm", [
            "uuid" => $_ENV["VM_ID"],
        ]);

        if ($curl->error) {
            throw new Exception(
                $curl->response == ""
                    ? $curl->errorMessage
                    : $curl->response->errors->Error,
                500
            );
        } else {
            echo "[+]Get VM Info Success" . PHP_EOL;
            return $curl->response;
        }
    }

    public static function shutdownVM()
    {
        echo "[-]Trying to Shutdown VM" . PHP_EOL;
        $curl = Helper::curl();
        $curl->post($_ENV["BASE_URL"] . "user-resource/vm/stop", [
            "uuid" => $_ENV["VM_ID"],
        ]);

        if ($curl->error) {
            if ($curl->response == "") {
                self::shutdownVM();
            } else {
                throw new Exception($curl->response->errors->Error, 500);
            }
        } else {
            echo "[+]Shutdown VM Success" . PHP_EOL;
            return $curl->response;
        }
    }

    public static function modifyVM(int $ram, int $vcpu)
    {
        echo "[-]Trying to Modify VM" . PHP_EOL;
        $curl = Helper::curl();
        $curl->patch($_ENV["BASE_URL"] . "user-resource/vm", [
            "uuid" => $_ENV["VM_ID"],
            "ram" => $ram,
            "vcpu" => $vcpu,
        ]);

        if ($curl->error) {
            throw new Exception(
                $curl->response == ""
                    ? $curl->errorMessage
                    : $curl->response->errors->Error,
                500
            );
        } else {
            echo "[+]Modify VM Success" . PHP_EOL;
            return $curl->response;
        }
    }

    public static function startVM()
    {
        echo "[-]Trying to Start VM" . PHP_EOL;
        $curl = Helper::curl();
        $curl->post($_ENV["BASE_URL"] . "user-resource/vm/start", [
            "uuid" => $_ENV["VM_ID"],
        ]);

        if ($curl->error) {
            throw new Exception(
                $curl->response == ""
                    ? $curl->errorMessage
                    : $curl->response->errors->Error,
                500
            );
        } else {
            echo "[+]Start VM Success" . PHP_EOL;
            return $curl->response;
        }
    }
}
