<?php

namespace Longinus\Apibanking;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Certificate
{
    public function __construct($certificate)
    {
        $this->certificate = $certificate;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPathPublicCertificate(): array|bool
    {
        $done = openssl_pkcs12_read($this->certificate, $certs, $this->password);
        if($done){
            if (!file_exists('temp/certificado/')) {
                mkdir('temp/certificado/', 0777, false);
            }else {
                $files = scandir('temp/certificado/');

                foreach ($files as $file) {
                    // Ignora os diretórios pai e atual
                    if ($file != "." && $file != "..") {
                        // Verifica se é um arquivo ou uma pasta
                        if (is_dir('temp/certificado/' . $file)) {
                            // Se for uma pasta, exclui-a recursivamente
                            rmdir('temp/certificado/' . $file);
                        } else {
                            // Se for um arquivo, exclui-o
                            unlink('temp/certificado/' . $file);
                        }
                    }
                }

                // Exclui a pasta principal
                rmdir('temp/certificado/');

                mkdir('temp/certificado/', 0777, false);
            }
            $cert = $certs['cert']; //.pem
            $privateKey = $certs['pkey']; //.key
            $certName = Str::random(5) . '_' . time() . '.cer';
            $publicPath = public_path('temp/certificado/');
            $certPath = $publicPath. $certName;
            file_put_contents($certPath, $cert);
            $keyName = Str::random(5) . '_' . time() . '.key';
            $keyPath = $publicPath. $keyName;
            file_put_contents($keyPath, $privateKey);

            return [$certPath, $keyPath];
        }else{
            return false;
        }
    }

}
